@extends('layouts.app')

@section('title', 'Receive Inventory')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Purchase Orders</h4>
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- Filter / Search -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="po_number" class="form-control" placeholder="PO Number" value="{{ request('po_number') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="branch" class="form-control" placeholder="Branch" value="{{ request('branch') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="{{ route('purchase_receipts.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Receipt No</th>
                    <th>PO Number</th>
                    <th>Received Date</th>
                    <th>Branch</th>
                    <th>Received By</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receipts as $r)
                <tr>
                    <td>{{ $r->receipt_no }}</td>
                    <td>{{ $r->purchaseOrder->po_number ?? 'N/A' }}</td>
                    <td>{{ $r->received_date->format('Y-m-d') }}</td>
                    <td>{{ $r->branch }}</td>
                    <td>{{ $r->received_by }}</td>
                    <td>
                        <span class="badge bg-{{ $r->status == 'confirmed' ? 'success' : 'warning' }}">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('purchase_receipts.show', $r->id) }}" class="btn btn-sm btn-info">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No receipts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $receipts->withQueryString()->links() }}

    </div>
</div>
@endsection
