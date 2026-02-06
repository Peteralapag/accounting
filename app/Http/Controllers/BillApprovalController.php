<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseBill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'remarks'             => 'nullable|string|max:255',
            'tax_type'            => 'required|string|in:Non-VAT,VAT,Withholding',
            'payment_terms'       => 'required|integer|min:0',
            'vat_rate'            => 'nullable|numeric|min:0|max:1',
            'withholding_rate'    => 'nullable|numeric|min:0|max:1',
            'supplier_invoice_no' => 'required|string|max:50',
            'payment_terms'       => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $bill->status = 'process';
            $bill->approval_status = 'pending';
            $bill->remarks = $request->input('remarks');
            $bill->supplier_invoice_no = $request->input('supplier_invoice_no');
            $bill->payment_terms = $request->input('payment_terms');
            $bill->tax_type = $request->input('tax_type');
            $bill->vat_rate = $request->input('vat_rate', 0);
            $bill->withholding_rate = $request->input('withholding_rate', 0);
            $bill->processed_by = auth()->user()->name;
            $bill->processed_at = now();

            // Calculate VAT and Withholding amounts
            $totalAmount = $bill->items->sum('amount');
            $bill->vat_amount = $bill->tax_type == 'VAT' ? $totalAmount * $bill->vat_rate : 0;
            $bill->withholding_amount = $bill->tax_type == 'Withholding' ? $totalAmount * $bill->withholding_rate : 0;

            $bill->save();

            return response()->json([
                'success' => true,
                'message' => 'Successfully sent to A/P approval.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error processing bill: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process the bill. Please try again.'
            ], 500);
        }
    }



}
