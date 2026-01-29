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
        DB::beginTransaction();

        try {
            $bill = PurchaseBill::lockForUpdate()->findOrFail($request->bill_id);

            $newPaid = $bill->paid_amount + $request->amount_paid;
            $balance = $bill->total_amount - $newPaid;

            if ($balance < 0) {
                throw new \Exception('Payment exceeds remaining balance');
            }

            PurchaseBillPayment::create([
                'bill_id'               => $bill->id,
                'payment_date'          => $request->payment_date,
                'payment_account'       => $request->payment_account,
                'payment_method'        => $request->payment_method,
                'reference_no'          => $request->reference_no,
                'amount_paid'           => $request->amount_paid,
                'balance_after_payment' => $balance,
                'status'                => $balance == 0 ? 'PAID' : 'PARTIAL',
                'remarks'               => $request->remarks,
            ]);

            $bill->paid_amount = $newPaid;
            $bill->status      = $balance == 0 ? 'PAID' : 'PARTIAL';
            $bill->save();

            DB::commit();

            return back()->with('success', 'Payment posted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}