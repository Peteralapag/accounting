<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseReceipt;

class PurchaseReceiptsController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseReceipt::with('purchaseOrder');

        // Search / filter
        if ($request->filled('po_number')) {
            $query->whereHas('purchaseOrder', function($q) use ($request) {
                $q->where('po_number', 'like', '%' . $request->po_number . '%');
            });
        }

        if ($request->filled('branch')) {
            $query->where('branch', 'like', '%' . $request->branch . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination 20 per page
        $receipts = $query->orderBy('received_date', 'desc')->paginate(20);

        return view('purchase-receipts.index', compact('receipts'));
    }

    public function show($id)
    {
        $receipt = PurchaseReceipt::with(['purchaseOrder', 'items'])->findOrFail($id);

        return view('purchase-receipts.show', compact('receipt'));
    }
}
