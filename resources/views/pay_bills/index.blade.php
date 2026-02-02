@extends('layouts.app')

@section('title', 'Pay Bills')

@section('content')
<div class="container py-4">



    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-4">Pay Bills</h3>
        <a href="{{ route('pay_bills.schedules.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-calendar-plus me-1"></i> View / Create Payment Schedules
        </a>
    </div>




    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Bill No</th>
                            <th>Supplier</th>
                            <th>Bill Date</th>
                            <th>Due Date</th>
                            <th>Total Amount</th>
                            <th>Balance</th>
                            <th>Aging</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bills as $i => $bill)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $bill->bill_no }}</td>
                            <td>{{ $bill->receipt->purchaseOrder->supplier->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}</td>
                            <td class="text-end">{{ number_format($bill->total_amount,2) }}</td>
                            <td class="text-end">{{ number_format($bill->balance,2) }}</td>
                            <td class="text-center">{{ $bill->receipt->received_date ? intval($bill->receipt->received_date->diffInDays(now())) . ' days' : 'N/A' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary view-details-btn"
                                        data-bill='@json($bill)'>
                                    <i class="bi bi-eye me-1"></i> View
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No bills available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for viewing + paying bill -->
@include('pay_bills.partials.bill_modal')
@endsection
