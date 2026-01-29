@extends('layouts.app')

@section('content')



<div class="container">
    <h3>Purchase Bills</h3>
    <a href="{{ route('purchase_bills.create') }}" class="btn btn-primary mb-3 btn-sm">
        <i class="bi bi-file-earmark-plus me-2"></i> Create Purchase Bill
    </a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Bill No</th>
                <th>Receipt #</th>
                <th>PO #</th>
                <th>Supplier</th>
                <th>Branch</th>
                <th>Bill Date</th>
                <th>Due Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bills as $b)
            <tr>
                <td>{{ $b->bill_no }}</td>
                <td>{{ $b->receipt->receipt_no ?? '-' }}</td>
                <td>{{ $b->receipt->purchaseOrder->po_number ?? '-' }}</td>
                <td>{{ $b->receipt->purchaseOrder->supplier->name ?? '-' }}</td>
                <td>{{ $b->branch }}</td>
                <td>{{ $b->bill_date->format('Y-m-d') }}</td>
                <td>{{ $b->due_date->format('Y-m-d') }}</td>
                <td class="text-end">{{ number_format($b->total_amount, 2) }}</td>
                <td>{{ ucfirst($b->status) }}</td>
                
                <td>
                    <a href="{{ route('purchase_bills.showpb', ['id' => $b->id]) }}" class="btn btn-sm btn-primary mb-1">View</a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection