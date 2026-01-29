@extends('layouts.app')

@section('title', 'Purchase Bill Details')

@section('content')
<div class="container">
    <h3 class="mb-4">Purchase Bill Details</h3>
    <a href="{{ route('purchase_bills.index') }}" class="btn btn-outline-primary mb-4 btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Bills
    </a>

    <!-- Bill Information -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">Bill Information</div>
        <div class="card-body">
            @php
                $billDateFormatted = $bill->bill_date ? $bill->bill_date->format('M d, Y'): '-';
                $dueDateFormatted  = $bill->due_date ? $bill->due_date->format('M d, Y'): '-';
            @endphp
            <p><strong>Bill No:</strong> {{ $bill->bill_no }}</p>
            <p><strong>Receipt #:</strong> {{ $bill->receipt->receipt_no ?? '-' }}</p>
            <p><strong>PO #:</strong> {{ $bill->receipt->purchaseOrder->po_number ?? '-' }}</p>
            <p><strong>Supplier:</strong> {{ $bill->receipt->purchaseOrder->supplier->name ?? '-' }}</p>
            <p><strong>Branch:</strong> {{ $bill->branch }}</p>
            <p><strong>Bill Date:</strong> {{ $billDateFormatted }}</p>
            <p><strong>Due Date:</strong> {{ $dueDateFormatted }}</p>
            <p><strong>Status:</strong> <span class="badge bg-{{ $bill->status == 'paid' ? 'success' : ($bill->status == 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($bill->status) }}</span></p>

        </div>
        
    </div>

    <!-- Bill Items -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white fw-bold">Bill Items</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Item Description</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bill->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->purchaseOrderItem->description ?? 'N/A' }}</td>
                            <td class="text-end">{{ $item->qty }}</td>
                            <td class="text-end">{{ number_format($item->unit_price,2) }}</td>
                            <td class="text-end">{{ number_format($item->amount,2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No items found for this bill.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($bill->items->count())
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="text-end">{{ number_format($bill->items->sum('amount'),2) }}</th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Tax & Total -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white fw-bold">Tax & Total</div>
        <div class="card-body">
            @php
                $total = $bill->items->sum('amount');
                $taxType = $bill->receipt->purchaseOrder->supplier->tax_type ?? 'Non-VAT';
                $vatrate = $bill->receipt->purchaseOrder->supplier->vat_rate ?? 0;
                $withholdingrate = $bill->receipt->purchaseOrder->supplier->withholding_rate ?? 0;

                $vatAmount = 0;
                $withholdingAmount = 0;
                $grandTotal = $total;

                if($taxType == 'VAT') {
                    $vatAmount = $total * $vatrate;
                    $grandTotal -= $vatAmount;
                }
                if($taxType == 'Withholding') {
                    $withholdingAmount = $total * $withholdingrate;
                    $grandTotal -= $withholdingAmount;
                }
            @endphp

            <div class="d-flex justify-content-between mb-2">
                <span>Tax Type:</span>
                <span class="fw-bold">{{ $taxType }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>VAT Amount:</span>
                <span class="fw-bold text-warning">{{ number_format($vatAmount,2) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Withholding Amount:</span>
                <span class="fw-bold text-danger">{{ number_format($withholdingAmount,2) }}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span class="fw-bold fs-5">Grand Total:</span>
                <span class="fw-bold text-success fs-5">{{ number_format($grandTotal,2) }}</span>
            </div>
        </div>
    </div>



    <!-- Approval Button -->
    @if($bill->approval_status == 'pending')
    <div class="card-footer d-flex justify-content-end">
        <form action="{{ route('bill_approval.approve', $bill->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm fw-bold">
                <i class="bi bi-check-circle me-1"></i> Approve
            </button>
        </form>
    </div>
    @endif

</div>
z

@endsection