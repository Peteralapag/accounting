@extends('layouts.app')

@section('title', 'Create Purchase Bill')

@section('content')

<div class="container-fluid mt-4">

    {{-- FILTER CARD --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Receipt No
                    </label>
                    <input type="text"
                           name="receipt_no"
                           class="form-control"
                           placeholder="Enter Receipt Number"
                           value="{{ request('receipt_no') }}">
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary me-2">
                        Filter
                    </button>

                    <a href="{{ route('purchase_bills.create') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-semibold">
                Select Receipt to Create Purchase Bill
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Receipt No</th>
                            <th>PO Number</th>
                            <th>Received Date</th>
                            <th>Branch</th>
                            <th>Aging</th>
                            
                            <th class="text-center" width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receipts as $r)
                        <tr>
                            <td class="fw-semibold">
                                {{ $r->receipt_no }}
                            </td>
                            <td>
                                {{ $r->purchaseOrder->po_number ?? 'N/A' }}
                            </td>
                            <td>
                                {{ optional($r->received_date)->format('Y-m-d') }}
                            </td>
                            <td>
                                {{ $r->branch }}
                            </td>
                            <td>
                                {{ $r->received_date ? intval($r->received_date->diffInDays(now())) . ' days' : 'N/A' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('purchase_bills.createFromReceipt', $r->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Select
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No confirmed receipts available for billing.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($receipts->hasPages())
        <div class="card-footer bg-white">
            {{ $receipts->links() }}
        </div>
        @endif
    </div>

</div>

@endsection
