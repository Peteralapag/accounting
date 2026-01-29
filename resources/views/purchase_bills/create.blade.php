@extends('layouts.app')

@section('title', 'Create Purchase Bill')

@section('content')


<form method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
        <input type="text"
               name="receipt_no"
               class="form-control"
               placeholder="Search Receipt No"
               value="{{ request('receipt_no') }}">
    </div>

    <div class="col-md-4">
        <button type="submit" class="btn btn-secondary">
            Filter
        </button>

        <a href="{{ route('purchase_bills.create') }}"
           class="btn btn-light">
            Reset
        </a>
    </div>
</form>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Select Receipt to Create Bill</h4>

    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Receipt No</th>
                    <th>PO Number</th>
                    <th>Received Date</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receipts as $r)
                <tr>
                    <td>{{ $r->receipt_no }}</td>
                    <td>{{ $r->purchaseOrder->po_number ?? 'N/A' }}</td>
                    <td>{{ $r->received_date->format('Y-m-d') }}</td>
                    <td>{{ $r->branch }}</td>
                    <td>
                        <span class="badge bg-success">Confirmed</span>
                    </td>
                    <td>
                        <a href="{{ route('purchase_bills.createFromReceipt', $r->id) }}"
                           class="btn btn-sm btn-info">
                            View
                        </a>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No confirmed receipts without bills.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $receipts->links() }}
    </div>
</div>
@endsection