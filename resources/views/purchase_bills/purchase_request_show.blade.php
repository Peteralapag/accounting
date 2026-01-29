@extends('layouts.app')

@section('title', 'Receipt Details')

@section('content')

@php
    $terms = $receipt->purchaseOrder->supplier->payment_terms ?? null;
    $dueDate = null;

    if($terms && isset($receipt->received_date)) {
        // Extract number from terms like NET30, NET15
        preg_match('/\d+/', $terms, $matches);
        if(!empty($matches)) {
            $days = (int) $matches[0];
            $dueDate = $receipt->received_date->copy()->addDays($days);
        }
    }
@endphp

{{-- Bootstrap Alerts --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('success') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
{{ session('error') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif



<div class="container-fluid mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Receipt Details</h4>
        <a href="{{ route('purchase_bills.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Receipts
        </a>
    </div>

    <!-- Receipt Info -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white fw-bold">Receipt Information</div>
                <div class="card-body">
                    <p><strong>Receipt No:</strong> {{ $receipt->receipt_no }}</p>
                    <p><strong>PO Number:</strong> {{ $receipt->purchaseOrder->po_number ?? 'N/A' }}</p>
                    <p><strong>Received Date:</strong> {{ $receipt->received_date->format('Y-m-d') }}</p>
                    <p><strong>Branch:</strong> {{ $receipt->branch }}</p>
                    <p><strong>Received By:</strong> {{ $receipt->received_by }}</p>
                    <p><strong>Supplier:</strong> {{ $receipt->purchaseOrder->supplier->name ?? 'N/A' }}</p>
                    <p><strong>Terms:</strong> {{ $terms ?? '-' }}</p>
                    <p><strong>Due Date:</strong> {{ $dueDate ? $dueDate->format('M j, Y') : '-' }}</p>
                    <p><strong>Remarks:</strong> {{ $receipt->purchaseOrder->remarks ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Tax Summary -->
        <div class="col-lg-6">
            @php
                $total = $receipt->items->sum('amount');
                $taxType = $receipt->purchaseOrder->supplier->tax_type ?? 'Non-VAT';
                $vatrate = $receipt->purchaseOrder->supplier->vat_rate ?? 0;
                $withholdingrate = $receipt->purchaseOrder->supplier->withholding_rate ?? 0;

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
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white fw-bold">Tax & Total</div>
                <div class="card-body">
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
                        <span class="fw-bold">Total to Pay:</span>
                        <span class="fw-bold text-success fs-5">{{ number_format($grandTotal,2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white fw-bold">Items Received</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item Description</th>
                            <th class="text-end">Qty Received</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receipt->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->poItem->description ?? 'N/A' }}</td>
                            <td class="text-end">{{ $item->received_qty }}</td>
                            <td class="text-end">{{ number_format($item->unit_price,2) }}</td>
                            <td class="text-end">{{ number_format($item->amount,2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No items found for this receipt.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($receipt->items->count())
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="text-end">{{ number_format($receipt->items->sum('amount'),2) }}</th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Create Bill Button -->
    <div class="d-flex justify-content-end mb-4">
        <form id="create-bill-form" action="{{ route('purchase_bills.store') }}" method="POST">
            @csrf
            <input type="hidden" name="receipt_id" value="{{ $receipt->id }}">
            <button type="submit" class="btn btn-success btn-sm fw-bold">
                <i class="bi bi-file-earmark-plus me-2"></i> Create Bill
            </button>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('create-bill-form').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Create Bill?',
            text: "Are you sure you want to create a bill for this receipt?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Create',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endsection