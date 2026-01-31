@extends('layouts.app')

@section('title', 'Purchase Bill Details')

@section('content')

@push('styles')
<style>
    .info-label {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: .03em;
    }
    .info-value {
        font-weight: 600;
        font-size: 0.95rem;
    }
    .section-title {
        font-weight: 600;
        letter-spacing: .02em;
    }
</style>
@endpush

<div class="container py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Bill Details</h3>
        <a href="{{ route('purchase_bills.index') }}" class="btn btn-outline-primary btn-sm shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Bills
        </a>
    </div>

    <!-- Bill Information -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white fw-bold">Bill Information</div>
        <div class="card-body">
            @php
                $billDateFormatted = $bill->bill_date ? $bill->bill_date->format('M d, Y'): '-';
                $dueDateFormatted  = $bill->due_date ? $bill->due_date->format('M d, Y'): '-';
            @endphp

            <div class="row mb-2">
                <div class="col-md-4"><strong>Bill No:</strong> {{ $bill->bill_no }}</div>
                <div class="col-md-4"><strong>Receipt #:</strong> {{ $bill->receipt->receipt_no ?? '-' }}</div>
                <div class="col-md-4"><strong>PO #:</strong> {{ $bill->receipt->purchaseOrder->po_number ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><strong>Supplier:</strong> {{ $bill->receipt->purchaseOrder->supplier->name ?? '-' }}</div>
                <div class="col-md-4"><strong>Branch:</strong> {{ $bill->branch }}</div>
                <div class="col-md-4"><strong>Status:</strong>
                    <span class="badge 
                        @if($bill->status=='paid') bg-success 
                        @elseif($bill->status=='pending') bg-warning text-dark 
                        @else bg-secondary @endif">
                        {{ ucfirst($bill->status) }}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><strong>Bill Date:</strong> {{ $billDateFormatted }}</div>
                <div class="col-md-4"><strong>Due Date:</strong> {{ $dueDateFormatted }}</div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="border rounded bg-light px-3 py-2">
                        <div class="info-label mb-1">Remarks / Invoice No</div>
                        <div class="info-value">
                            {{ $bill->receipt->remarks ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            


        </div>
    </div>

    <!-- Bill Items -->
    <div class="card shadow-sm mb-4 border-0">
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
                            <td class="text-end fw-bold">{{ number_format($item->amount,2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No items found for this bill.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($bill->items->count())
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="text-end fw-bold">{{ number_format($bill->items->sum('amount'),2) }}</th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Tax & Total -->
    <div class="card-body">
        @php
            $total = $bill->items->sum('amount');
            $taxType = $bill->receipt->purchaseOrder->supplier->tax_type ?? 'Non-VAT';
            $vatrate = $bill->receipt->purchaseOrder->supplier->vat_rate ?? 0;
            $withholdingrate = $bill->receipt->purchaseOrder->supplier->withholding_rate ?? 0;

            $vatAmount = ($taxType=='VAT') ? $total * $vatrate : 0;
            $withholdingAmount = ($taxType=='Withholding') ? $total * $withholdingrate : 0;
            $grandTotal = $total - $vatAmount - $withholdingAmount;
        @endphp

        <div class="row g-3">
            <!-- TAX TYPE -->
            <div class="col-md-4">
                <div class="border rounded p-3 h-100">
                    <div class="info-label mb-1">Tax Type</div>
                    <div class="info-value">{{ $taxType }}</div>
                </div>
            </div>

            <!-- VAT -->
            <div class="col-md-4">
                <div class="border rounded p-3 h-100 {{ $vatAmount ? 'bg-warning bg-opacity-10' : 'bg-light' }}">
                    <div class="info-label mb-1">
                        VAT
                        @if($vatAmount)
                            ({{ number_format($vatrate * 100, 2) }}%)
                            <i class="bi bi-info-circle ms-1"
                            data-bs-toggle="tooltip"
                            title="VAT is computed based on supplier VAT rate"></i>
                        @endif
                    </div>

                    <div class="info-value text-warning">
                        {{ $vatAmount ? number_format($vatAmount,2) : '-' }}
                    </div>
                </div>
            </div>

            <!-- WITHHOLDING -->
            <div class="col-md-4">
                <div class="border rounded p-3 h-100 {{ $withholdingAmount ? 'bg-danger bg-opacity-10' : 'bg-light' }}">
                    <div class="info-label mb-1">
                        Withholding
                        @if($withholdingAmount)
                            ({{ number_format($withholdingrate * 100, 2) }}%)
                            <i class="bi bi-info-circle ms-1"
                            data-bs-toggle="tooltip"
                            title="Withholding tax deducted based on supplier rate"></i>
                        @endif
                    </div>

                    <div class="info-value text-danger">
                        {{ $withholdingAmount ? number_format($withholdingAmount,2) : '-' }}
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- GRAND TOTAL -->
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold fs-5">Grand Total</span>
            <span class="fw-bold text-success fs-4">
                {{ number_format($grandTotal,2) }}
            </span>
        </div>
    </div>


    <!-- Approval Button -->
    @if($bill->approval_status == 'pending')
    <div class="d-flex justify-content-end mb-4">
        <form action="{{ route('bill_approval.approve', $bill->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm fw-bold shadow-sm">
                <i class="bi bi-check-circle me-1"></i> Approve
            </button>
        </form>
    </div>
    @endif

</div>
@endsection
