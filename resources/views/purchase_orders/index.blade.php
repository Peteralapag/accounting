@extends('layouts.app')

@section('title', 'Purchase Orders')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Purchase Orders</h4>
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Search Form --}}
    <form method="GET" action="{{ route('purchase-orders.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Search PO number or Supplier">
        </div>

        <div class="col-md-3">
            @php
            $statuses = ['PENDING','APPROVED','PARTIAL_RECEIVED','RECEIVED','CANCELLED'];
            @endphp

            <select name="status" class="form-select">
                <option value="">-- Select Status --</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') == $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Search</button>
        </div>
    </form>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>PO Number</th>
                <th>PR Number</th>
                <th>Supplier Name</th>
                <th>Branch</th>
                <th>Order Date</th>
                <th>Status</th>
                <th class="text-end">Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchaseOrders as $po)
                <tr>
                    <td>{{ $po->po_number }}</td>
                    <td>{{ $po->pr_number }}</td>
                    <td>{{ $po->supplier->name ?? 'N/A' }}</td>
                    <td>{{ $po->branch }}</td>
                    <td>{{ \Carbon\Carbon::parse($po->order_date)->format('M d, Y') }}</td>
                    <td>
                        @php
                            $statusClass = match($po->status) {
                                'PENDING' => 'secondary',
                                'APPROVED' => 'success',
                                'PARTIAL_RECEIVED' => 'info',
                                'RECEIVED' => 'primary',
                                'CANCELLED' => 'danger',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $statusClass }}">{{ $po->status }}</span>
                    </td>
                    <td class="text-end">{{ number_format($po->total_amount, 2) }}</td>
                    <td>
                        <a href="{{ route('purchase-orders.show', $po->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No purchase orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $purchaseOrders->links() }}
    </div>

</div>
@endsection
