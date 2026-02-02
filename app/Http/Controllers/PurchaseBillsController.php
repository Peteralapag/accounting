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
    // Show all bills
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


        $bill = PurchaseBill::create([
        'receipt_id' => $receipt->id,
        'bill_no' => $billNo,
        'bill_date' => now()->toDateString(),
        'due_date' => now()->addDays(30)->toDateString(),
        'branch' => $receipt->branch,
        'remarks' => $receipt->remarks,
        'status' => 'draft',
        'total_amount' => $receipt->items->sum('amount'),
        'balance' => $grandTotal,
        'tax_type' => $taxType,
        'vat_amount' => $vatAmount,
        'withholding_amount'=> $withholdingAmount,
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

        return redirect()->route('purchase_bills.index')
                        ->with('success', 'Purchase bill created successfully!');
    }

    
}