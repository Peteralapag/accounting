<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseBill;
use Illuminate\Support\Facades\Auth;

class BillApprovalController extends Controller
{
    public function approve(PurchaseBill $bill)
    {
        if ($bill->status != 'process') {
            return response()->json([
                'success' => false,
                'message' => 'This bill cannot be approved.'
            ]);
        }

        $bill->update([
            'status' => 'posted',
            'approval_status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->user()->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Approved.'
        ]);
    }



    public function process(Request $request, PurchaseBill $bill)
    {
        $bill->status = 'process';
        $bill->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully sent to A/P approval.'
        ]);
    }
}
