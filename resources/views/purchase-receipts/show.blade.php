@extends('layouts.app')

@section('title', 'Receipt Details')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Receipt Details</h4>

    </div>

    <!-- Receipt Info -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"><strong>Receipt No:</strong> {{ $receipt->receipt_no }}</div>
                <div class="col-md-4"><strong>PO Number:</strong> {{ $receipt->purchaseOrder->po_number ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Received Date:</strong> {{ $receipt->received_date->format('Y-m-d') }}</div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4"><strong>Branch:</strong> {{ $receipt->branch }}</div>
                <div class="col-md-4"><strong>Received By:</strong> {{ $receipt->received_by }}</div>
                <div class="col-md-4"><strong>Status:</strong> 
                    <span class="badge bg-{{ $receipt->status == 'confirmed' ? 'success' : 'warning' }}">
                        {{ ucfirst($receipt->status) }}
                    </span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12"><strong>Remarks:</strong> {{ $receipt->remarks ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Receipt Items -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Item Name / Description</th>
                    <th>Quantity Received</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receipt->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->poItem->description ?? 'N/A' }}</td>
                    <td>{{ $item->received_qty }}</td>
                    <td>{{ number_format($item->unit_price,2) }}</td>
                    <td>{{ number_format($item->amount,2) }}</td>
                    <td>{{ $item->remarks ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No items found for this receipt.</td>
                </tr>
                @endforelse
            </tbody>
            @if($receipt->items->count())
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total:</th>
                    <th colspan="2">
                        {{ number_format($receipt->items->sum('amount'),2) }}
                    </th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>


</div>
@endsection
