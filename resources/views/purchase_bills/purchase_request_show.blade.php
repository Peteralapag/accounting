@extends('layouts.app')

@section('title', 'Receipt Details')

@section('content')

@push('styles')
<style>
    .info-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .info-value {
        font-weight: 600;
        font-size: 0.95rem;
    }
</style>
@endpush

@php
    $terms = $receipt->purchaseOrder->supplier->payment_terms ?? null;
    $dueDate = null;

    if($terms && isset($receipt->received_date)) {
        preg_match('/\d+/', $terms, $matches);
        if(!empty($matches)) {
            $days = (int) $matches[0];
            $dueDate = $receipt->received_date->copy()->addDays($days);
        }
    }
@endphp

{{-- Alerts --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Receipt Details</h3>
        <a href="{{ route('purchase_bills.create') }}" class="btn btn-outline-primary btn-sm shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Branch Received
        </a>
    </div>

    <div class="row g-4 mb-4">

        <!-- Receipt Information -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white fw-bold">
                    Receipt Information
                </div>
                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="info-label">Receipt No</div>
                            <div class="info-value">{{ $receipt->receipt_no }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">PO Number</div>
                            <div class="info-value">{{ $receipt->purchaseOrder->po_number ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="info-label">Received Date</div>
                            <div class="info-value">{{ $receipt->received_date->format('M d, Y') }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Due Date</div>
                            <div class="info-value">{{ $dueDate ? $dueDate->format('M d, Y') : '-' }}</div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="info-label">Branch</div>
                            <div class="info-value">{{ $receipt->branch }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Received By</div>
                            <div class="info-value">{{ $receipt->received_by }}</div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="info-label">Supplier</div>
                            <div class="info-value">{{ $receipt->purchaseOrder->supplier->name ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Payment Terms</div>
                            <div class="info-value">{{ $terms ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="mt-3 border rounded bg-light px-3 py-2">
                        <div class="info-label mb-1">Remarks / Invoice No</div>
                        <div class="info-value">
                            {{ $receipt->remarks ?? '-' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tax Summary -->
        <div class="col-lg-6">
            @php
                $total = $receipt->items->sum('amount');
                $taxType = $receipt->purchaseOrder->supplier->tax_type ?? 'Non-VAT';
                $vatRate = $receipt->purchaseOrder->supplier->vat_rate ?? 0;
                $withholdingRate = $receipt->purchaseOrder->supplier->withholding_rate ?? 0;

                $vatAmount = 0;
                $withholdingAmount = 0;
                $grandTotal = $total;

                if($taxType == 'VAT') {
                    $vatAmount = $total * $vatRate;
                    $grandTotal -= $vatAmount;
                }
                if($taxType == 'Withholding') {
                    $withholdingAmount = $total * $withholdingRate;
                    $grandTotal -= $withholdingAmount;
                }
            @endphp

            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-info text-white fw-bold">
                    Tax & Total
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <div class="info-label">Tax Type</div>
                        <span class="badge
                            @if($taxType=='VAT') bg-warning
                            @elseif($taxType=='Withholding') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ $taxType }}
                        </span>
                    </div>

                    <div class="border rounded p-3 mb-3 bg-warning bg-opacity-10">
                        <div class="info-label">VAT ({{ number_format($vatRate * 100,2) }}%)</div>
                        <div class="info-value text-warning">
                            {{ $vatAmount ? number_format($vatAmount,2) : '-' }}
                        </div>
                    </div>

                    <div class="border rounded p-3 mb-3 bg-danger bg-opacity-10">
                        <div class="info-label">Withholding ({{ number_format($withholdingRate * 100,2) }}%)</div>
                        <div class="info-value text-danger">
                            {{ $withholdingAmount ? number_format($withholdingAmount,2) : '-' }}
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">Total to Pay</span>
                        <span class="fw-bold fs-4 text-success">
                            {{ number_format($grandTotal,2) }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Items -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-secondary text-white fw-bold">
            Items Received
        </div>
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
                        @forelse($receipt->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->poItem->description ?? 'N/A' }}</td>
                            <td class="text-end">{{ $item->received_qty }}</td>
                            <td class="text-end">{{ number_format($item->unit_price,2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($item->amount,2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                No items found for this receipt.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($receipt->items->count())
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th class="text-end fw-bold">
                                {{ number_format($receipt->items->sum('amount'),2) }}
                            </th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Create Bill -->
    <div class="d-flex justify-content-end">
        <form id="create-bill-form" action="{{ route('purchase_bills.store') }}" method="POST">
            @csrf
            <input type="hidden" name="receipt_id" value="{{ $receipt->id }}">
            <button class="btn btn-success btn-sm fw-bold shadow-sm">
                <i class="bi bi-file-earmark-plus me-2"></i> Push to A/P
            </button>
        </form>
    </div>

</div>
@endsection


@push('scripts')
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
<script>



document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('create-bill-form');

    if(form){
        form.addEventListener('submit', function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Confirm Push to A/P?',
                text: "This will create a draft purchase bill.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, push it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if(result.isConfirmed){
                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async res => {
                        if(!res.ok){
                            const text = await res.text();
                            throw new Error(text || 'Server error');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if(data.success){
                            Swal.fire({
                                icon: 'success',
                                title: 'Bill Created!',
                                text: data.message || 'Successfully pushed to A/P',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('purchase_bills.index') }}";
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong!', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    });
                }
            });
        });
    }
});

</script>
@endpush
