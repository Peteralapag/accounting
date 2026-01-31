<?php

namespace App\Http\Controllers;

use App\Models\PurchaseBill;
use App\Models\PurchaseBillPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PayBillsController extends Controller
{
    /**
     * Show bills ready for payment
     */
    public function index(Request $request)
    {
        $query = PurchaseBill::where('status', 'POSTED');

        if ($request->date_from && $request->date_to) {

            $dateFrom = Carbon::parse($request->date_from);
            $dateTo   = Carbon::parse($request->date_to);

            if ($dateFrom->diffInDays($dateTo) > 31) {
                $dateTo = $dateFrom->copy()->addDays(31);
            }

            $query->whereBetween('bill_date', [$dateFrom, $dateTo]);
        }

        $bills = $query->get();

        return view('pay_bills.index', compact('bills'));
    }

    /**
     * Store payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'bill_id'        => 'required|exists:purchase_bills,id',
            'amount_paid'    => 'required|numeric|min:0.01',
            'payment_date'   => 'required|date',
            'payment_method' => 'required|in:Cash,Bank Transfer,PDC',
            'pdc_number'     => 'nullable|string|max:50',
            'payment_account'=> 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $bill = PurchaseBill::lockForUpdate()->findOrFail($request->bill_id);

            $newPaid = $bill->paid_amount + $request->amount_paid;
            $balance = $bill->total_amount - $newPaid;

            if ($balance < 0) {
                throw new \Exception('Payment exceeds remaining balance');
            }

            $paymentData = [
                'bill_id'               => $bill->id,
                'payment_date'          => $request->payment_date,
                'payment_account'       => $request->payment_account,
                'payment_method'        => $request->payment_method,
                'reference_no'          => $request->reference_no,
                'amount_paid'           => $request->amount_paid,
                'balance_after_payment' => $balance,
                'status'                => $balance == 0 ? 'PAID' : 'PARTIAL',
                'remarks'               => $request->remarks,
            ];

            // If PDC, include check number
            if($request->payment_method === 'PDC'){
                $paymentData['pdc_number'] = $request->pdc_number;
            }

            PurchaseBillPayment::create($paymentData);

            $bill->paid_amount = $newPaid;
            $bill->status      = $balance == 0 ? 'PAID' : 'PARTIAL';
            $bill->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment posted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    


}