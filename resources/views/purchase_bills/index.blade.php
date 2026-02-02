@extends('layouts.app')

@section('title', 'Purchase Bills')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Enter Bills</h3>
        <a href="{{ route('purchase_bills.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="bi bi-file-earmark-plus me-1"></i> Create A/P Invoice
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">All Purchase Bills</span>

            {{-- SEARCH FORM --}}
            <form action="{{ route('purchase_bills.index') }}" method="GET" class="d-flex" style="gap:0.5rem;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search bills...">
                <button class="btn btn-primary btn-sm" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-primary text-dark text-center">
                        <tr>
                            <th>Bill No</th>
                            <th>Receipt #</th>
                            <th>PO #</th>
                            <th>Supplier</th>
                            <th>Branch</th>
                            <th>Bill Date</th>
                            <th>Due Date</th>
                            <th class="text-end">Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bills as $b)
                        <tr>
                            <td class="fw-semibold text-center">{{ $b->bill_no }}</td>
                            <td class="text-center">{{ $b->receipt->receipt_no ?? '-' }}</td>
                            <td class="text-center">{{ $b->receipt->purchaseOrder->po_number ?? '-' }}</td>
                            <td>{{ $b->receipt->purchaseOrder->supplier->name ?? '-' }}</td>
                            <td>{{ $b->branch }}</td>
                            <td class="text-center">{{ optional($b->bill_date)->format('Y-m-d') }}</td>
                            <td class="text-center">{{ optional($b->due_date)->format('Y-m-d') }}</td>
                            <td class="text-end fw-semibold">{{ number_format($b->total_amount, 2) }}</td>
                            <td class="text-center">
                                @php
                                    $statusColor = match($b->status) {
                                        'paid' => 'success',
                                        'pending' => 'warning text-dark',
                                        'overdue' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }}">{{ ucfirst($b->status) }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('purchase_bills.showpb', ['id' => $b->id]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                No purchase bills found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($bills->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $bills->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

</div>
@endsection
