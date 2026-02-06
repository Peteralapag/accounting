<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseBill;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseBillItem;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;

class PurchaseBillsController extends Controller
{

/*
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bills = PurchaseBill::with(['receipt.purchaseOrder.supplier'])
            ->where('status', '=', 'draft')
            ->when($search, function ($query, $search) {
                $query->where('bill_no', 'like', "%{$search}%")
                    ->orWhereHas('receipt', function ($q) use ($search) {
                        $q->where('receipt_no', 'like', "%{$search}%")
                        ->orWhereHas('purchaseOrder', function ($po) use ($search) {
                            $po->where('po_number', 'like', "%{$search}%")
                                ->orWhereHas('supplier', function ($s) use ($search) {
                                    $s->where('name', 'like', "%{$search}%");
                                });
                        });
                    });
            })
            ->orderBy('bill_date', 'desc')
            ->paginate(10);

        return view('purchase_bills.index', compact('bills'));
    }
*/
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status'); // for status dropdown
        $from = $request->input('from');
        $to = $request->input('to');

        // --- SUMMARY COUNTS ---
        $counts = [
            'draft' => PurchaseBill::where('status', 'draft')->count(),
            'submitted' => PurchaseBill::where('status', 'submitted')->count(),
            'approved' => PurchaseBill::where('status', 'approved')->count(),
            'overdue' => PurchaseBill::where('status', 'draft')
                            ->where('due_date', '<', now())
                            ->count(),
        ];

        // --- QUERY BILLS ---
        $billsQuery = PurchaseBill::with(['receipt.purchaseOrder.supplier']);

        // Apply filters
        if($search) {
            $billsQuery->where(function($q) use ($search) {
                $q->where('bill_no', 'like', "%{$search}%")
                ->orWhereHas('receipt', function($r) use ($search) {
                    $r->where('receipt_no', 'like', "%{$search}%")
                        ->orWhereHas('purchaseOrder', function($po) use ($search) {
                            $po->where('po_number', 'like', "%{$search}%")
                            ->orWhereHas('supplier', function($s) use ($search) {
                                $s->where('name', 'like', "%{$search}%");
                            });
                        });
                });
            });
        }

        if($statusFilter) {
            $billsQuery->where('status', $statusFilter);
        }

        if($from) {
            $billsQuery->whereDate('bill_date', '>=', $from);
        }

        if($to) {
            $billsQuery->whereDate('bill_date', '<=', $to);
        }

        $bills = $billsQuery->orderBy('bill_date', 'desc')->paginate(10);

        return view('purchase_bills.index', compact('bills', 'counts'));
    }



    // Show a single receipt to create a bill
    public function show($id)
    {
        $receipt = PurchaseReceipt::with(['purchaseOrder.supplier', 'items.poItem'])
            ->findOrFail($id);

        return view('enter_bills.show', compact('receipt'));
    }
    
    public function showpb($id)
    {
        $bill = PurchaseBill::with([
            'items.purchaseOrderItem',      // load PO item through receipt item
            'receipt.purchaseOrder.supplier'
        ])->findOrFail($id);

        return view('purchase_bills.bills_show', compact('bill'));
    }

    
    // Show form to create a new bill
    public function create(Request $request)
    {
        $receipts = PurchaseReceipt::with('purchaseOrder')
            ->where('status', 'confirmed')
            ->whereDoesntHave('bill') // only receipts not yet billed
            ->when($request->receipt_no, function ($q) use ($request) {
                $q->where('receipt_no', 'like', '%' . $request->receipt_no . '%');
            })
            ->orderBy('received_date', 'desc')
            ->paginate(10);

        return view('purchase_bills.create', compact('receipts'));
    }

    


    // app/Http/Controllers/PurchaseBillsController.php

    public function createFromReceipt($receiptId)
    {
        $receipt = PurchaseReceipt::with([
            'purchaseOrder.supplier',
            'items.poItem.purchaseOrder'
        ])
        ->where('id', $receiptId)
        ->where('status', 'confirmed')
        ->firstOrFail();

        return view('purchase_bills.purchase_request_show', compact('receipt'));
    }
    

    
    public function store(Request $request)
    {
        $receiptId = $request->input('receipt_id');
        $receipt = PurchaseReceipt::with('items')->findOrFail($receiptId);

        // Prevent duplicate bill
        if ($receipt->bill) {
            return redirect()->back()
                            ->with('error', 'A bill has already been created for this receipt.');
        }

        // Generate bill number
        $billNo = 'BILL-' . date('Ymd') . '-' . str_pad(
            PurchaseBill::count() + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        
        
        $taxType = $receipt->purchaseOrder->supplier->tax_type ?? 'Non-VAT';
        $vatrate = $receipt->purchaseOrder->supplier->vat_rate ?? 0;
        $withholdingrate = $receipt->purchaseOrder->supplier->withholding_rate ?? 0;


        $vatAmount = 0;
        $withholdingAmount = 0;
        $grandTotal = $receipt->items->sum('amount');


        if($taxType == 'VAT'){
        $vatAmount = $grandTotal * $vatrate;
        $grandTotal -= $vatAmount;
        }
        if($taxType == 'Withholding'){
        $withholdingAmount = $grandTotal * $withholdingrate;
        $grandTotal -= $withholdingAmount;
        }

        

        $terms = $receipt->purchaseOrder->supplier->payment_terms ?? null;

  


        $dueDate = now()->addDays(30); // fallback
        if($terms) {
            preg_match('/\d+/', $terms, $matches);
            if(!empty($matches)) {
                $dueDays = (int) $matches[0];
                $dueDate = $receipt->received_date->copy()->addDays($dueDays);
            }
        }

        $bill = PurchaseBill::create([
        'receipt_id' => $receipt->id,
        'bill_no' => $billNo,
        'bill_date' => now()->toDateString(),
        'due_date' => $dueDate->toDateString(),
        'goods_received_date' => $receipt->received_date->toDateString(),
        'branch' => $receipt->branch,
        'branch_remarks' => $receipt->remarks,
        'status' => 'draft',
        'total_amount' => $receipt->items->sum('amount'),
        'balance' => $grandTotal,
        'tax_type' => $taxType,
        'vat_rate' => $vatrate,
        'withholding_rate' => $withholdingrate,
        'vat_amount' => $vatAmount,
        'withholding_amount'=> $withholdingAmount,
        'payment_terms' => $terms,
        'created_by' => auth()->user()->name,
        ]);


        // Insert items
        foreach ($receipt->items as $item) {
            PurchaseBillItem::create([
                'bill_id'         => $bill->id,
                'receipt_item_id' => $item->id,
                'qty'             => $item->received_qty,
                'unit_price'      => $item->unit_price,
                'amount'          => $item->amount,
                'remarks'         => $item->remarks ?? '',
            ]);
        }



        return response()->json([
            'success' => true,
            'message' => 'Draft Purchase Bill created successfully.',
            'bill_id' => $bill->id
        ]);              
    }

    
}