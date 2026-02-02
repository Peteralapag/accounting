<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseBill;
use App\Models\PurchaseBillSchedule;
use App\Models\PurchaseBillPayment;
use Illuminate\Support\Facades\DB;

class PayBillsController extends Controller
{
    // Show Pay Bills module
    public function index()
    {
        $bills = PurchaseBill::with([
                'receipt.purchaseOrder.supplier',
                'items',
                'schedules',
                'payments'
            ])
            ->where('approval_status', 'approved')   // AP approved bill
            ->where('balance', '>', 0)                // unpaid
            ->whereHas('schedules', function($q){
                $q->whereIn('status', ['pending','approved']);
            })                                        // ONLY scheduled bills
            ->orderBy('due_date', 'asc')
            ->get();

        return view('pay_bills.index', compact('bills'));
    }

    public function create()
    {
        $bills = PurchaseBill::where('status', 'approved')
            ->whereDoesntHave('paymentSchedules')
            ->get();

        return view('pay_bills.schedules.create', compact('bills'));
    }


    // Store payment
    public function storePayment(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:purchase_bills,id',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string'
        ]);

        DB::transaction(function() use ($request) {

            $bill = PurchaseBill::findOrFail($request->bill_id);

            $paid = $request->amount_paid;
            $bill->balance -= $paid;

            // Update status
            $bill->status = ($bill->balance <= 0) ? 'Paid' : 'Partial';

            $bill->save();

            // Save payment
            PurchaseBillPayment::create([
                'bill_id' => $bill->id,
                'payment_date' => $request->payment_date,
                'payment_account' => $request->payment_account,
                'payment_method' => $request->payment_method,
                'pdc_number' => $request->pdc_number,
                'reference_no' => $request->reference_no,
                'amount_paid' => $paid,
                'balance_after_payment' => $bill->balance,
                'status' => 'Posted',
            ]);

        });

        return back()->with('success', 'Payment recorded successfully.');
    }
}
