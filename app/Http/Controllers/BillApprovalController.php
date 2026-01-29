<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseBill;
use Illuminate\Support\Facades\Auth;

class BillApprovalController extends Controller
{
   
    public function approve(PurchaseBill $bill)
    {
        if ($bill->approval_status != 'pending') {
            return back()->with('error', 'This bill cannot be approved.');
        }

        $bill->update([
            'status' => 'posted',
            'approval_status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->user()->name,
        ]);

        return back()->with('success', 'Bill approved successfully.');
    }



}