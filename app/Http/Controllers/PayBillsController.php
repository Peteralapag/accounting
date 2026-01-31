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
        $query = PurchaseBill::where('status', 'POSTED')
            ->with([
                'receipt.purchaseOrder.supplier',
                'items',
                'payments'
            ]);

        if ($request->date_from && $request->date_to) {
            $dateFrom = Carbon::parse($request->date_from);
            $dateTo   = Carbon::parse($request->date_to);

            // Max range 31 days
            if ($dateFrom->diffInDays($dateTo) > 31) {
                $dateTo = $dateFrom->copy()->addDays(31);
            }

            $query->whereBetween('bill_date', [$dateFrom, $dateTo]);
        }

        $bills = $query->get()->map(function($bill){
            $totalPaid = $bill->payments->sum('amount_paid');
            $balance = ($bill->total_amount ?? 0) - $totalPaid;

            return [
                'id' => $bill->id,
                'bill_no' => $bill->bill_no ?? '-',
                'bill_date' => $bill->bill_date ?? '-',
                'due_date' => $bill->due_date ?? '-',
                'status' => $balance <= 0 ? 'PAID' : 'POSTED',
                'total_amount' => $bill->total_amount ?? 0,
                'paid_amount' => $totalPaid,
                'balance' => $balance,
                'receipt' => [
                    'purchaseOrder' => [
                        'supplier' => [
                            'name' => optional($bill->receipt?->purchaseOrder?->supplier)->name ?? '-'
                        ]
                    ]
                ],
                'items' => $bill->items->map(function($item){
                    return [
                        'id'=>$item->id,
                        'receipt_item_id'=>$item->receipt_item_id ?? '-',
                        'qty'=>$item->qty ?? 0,
                        'unit_price'=>$item->unit_price ?? 0,
                        'amount'=>$item->amount ?? 0
                    ];
                }),
                'payments' => $bill->payments->map(function($p){
                    return [
                        'id' => $p->id,
                        'payment_date'=>$p->payment_date ?? '-',
                        'payment_method'=>$p->payment_method ?? '-',
                        'payment_account'=>$p->payment_account ?? '-',
                        'reference_no'=>$p->reference_no ?? '-',
                        'amount_paid'=>$p->amount_paid ?? 0,
                        'balance_after_payment'=>$p->balance_after_payment ?? 0,
                        'status'=>$p->status ?? '-'
                    ];
                })
            ];
        })
        ->filter(fn($bill) => $bill['balance'] > 0) // <-- **hide fully paid bills**
        ->values();


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
            // Lock the bill row
            $bill = PurchaseBill::lockForUpdate()->findOrFail($request->bill_id);

            // Calculate balance dynamically
            $totalPaid = $bill->payments()->sum('amount_paid');
            $newTotalPaid = $totalPaid + $request->amount_paid;
            $balance = ($bill->total_amount ?? 0) - $newTotalPaid;

            if ($balance < 0) {
                throw new \Exception('Payment exceeds remaining balance');
            }

            // Create payment
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

            if($request->payment_method === 'PDC'){
                $paymentData['pdc_number'] = $request->pdc_number;
            }

            $payment = PurchaseBillPayment::create($paymentData);

            // Update bill status only
            $bill->status = $balance == 0 ? 'PAID' : 'POSTED';
            $bill->balance = $balance; // optional, but can keep for quick access
            $bill->save();

            DB::commit();

            // Return updated bill info for live modal update
            $updatedBill = [
                'id' => $bill->id,
                'total_amount' => $bill->total_amount,
                'paid_amount' => $bill->paid_amount,
                'balance' => $bill->balance,
                'status' => $bill->status,
                'payments' => $bill->payments()->orderBy('created_at')->get()->map(function($p){
                    return [
                        'id' => $p->id,
                        'payment_date' => $p->payment_date,
                        'payment_method' => $p->payment_method,
                        'payment_account' => $p->payment_account,
                        'reference_no' => $p->reference_no,
                        'amount_paid' => $p->amount_paid,
                        'balance_after_payment' => $p->balance_after_payment,
                        'status' => $p->status
                    ];
                }),
            ];


            return response()->json([
                'success'=>true,
                'message'=>'Payment posted successfully',
                'bill'=>$updatedBill,
                'latest_payment_id'=>$payment->id
            ]);

        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }
}
