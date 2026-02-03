@extends('layouts.app')

@section('title', 'Purchase Bills')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Purchase Bills</h3>
        <a href="{{ route('purchase_bills.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="bi bi-file-earmark-plus me-1"></i> View Branch Received
        </a>
    </div>

    {{-- KPI CARDS --}}
    <div class="row mb-4">
        @php
            $draftCount = $bills->where('status','draft')->count();
            $pendingCount = $bills->where('status','process')->count();
            $overdueCount = $bills->where('status','overdue')->count();
            $totalPayable = $bills->sum('balance');
        @endphp

        <div class="col-md-3 mb-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Draft Bills</h6>
                    <h4 class="fw-bold text-warning">{{ $draftCount }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Pending Approval</h6>
                    <h4 class="fw-bold text-primary">{{ $pendingCount }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Overdue</h6>
                    <h4 class="fw-bold text-danger">{{ $overdueCount }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Payable</h6>
                    <h4 class="fw-bold text-success">₱{{ number_format($totalPayable,2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">All Purchase Bills</span>

            {{-- SEARCH + FILTER --}}
            <form action="{{ route('purchase_bills.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search bills...">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="overdue" {{ request('status')=='overdue' ? 'selected' : '' }}>Overdue</option>
                    <option value="paid" {{ request('status')=='paid' ? 'selected' : '' }}>Paid</option>
                </select>
                <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
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
                            <th>Due Date</th>
                            <th class="text-end">Total</th>
                            <th>Aging</th>
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
                            <td class="text-center">{{ optional($b->due_date)->format('Y-m-d') }}</td>
                            <td class="text-end fw-semibold">{{ number_format($b->total_amount, 2) }}</td>
                            <td class="text-center">
                                {{ $b->receipt->received_date ? intval($b->receipt->received_date->diffInDays(now())) . ' days' : 'N/A' }}
                            </td>
                            <td class="text-center">
                                @php
                                    $statusColor = match($b->status) {
                                        'paid' => 'success',
                                        'pending' => 'warning text-dark',
                                        'overdue' => 'danger',
                                        'draft' => 'secondary',
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
