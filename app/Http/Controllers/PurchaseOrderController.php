<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;

class PurchaseOrderController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = PurchaseOrder::with('supplier');

        if ($search) {
            $query->where('po_number', 'like', "%{$search}%");
        }

        $purchaseOrders = $query
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('purchase_orders.index', compact('purchaseOrders', 'search'));
    }

    public function show($id)
    {
        $po = PurchaseOrder::with([
            'supplier',
            'items'
        ])->findOrFail($id);

        return view('purchase_orders.show', compact('po'));
    }



}
