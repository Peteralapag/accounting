@extends('layouts.app')

@section('title', 'Bills Ready to Schedule')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">Bills Ready to Schedule</h3>

    @if($bills->count() > 0)
        <form method="POST" action="{{ route('pay_bills.schedules.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Schedule Date</label>
                    <input type="date" name="payment_date" class="form-control" required>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Select</th>
                                    <th>Bill No</th>
                                    <th>Supplier</th>
                                    <th>Bill Date</th>
                                    <th>Due Date</th>
                                    <th>Total Amount</th>
                                    <th>Aging</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $i => $bill)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td class="text-center">
                                            <input type="checkbox" name="bills[]" value="{{ $bill->id }}">
                                        </td>
                                        <td>{{ $bill->bill_no }}</td>
                                        <td>{{ $bill->receipt->purchaseOrder->supplier->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}</td>
                                        <td class="text-end">{{ number_format($bill->total_amount, 2) }}</td>
                                        <td class="text-center">{{ $bill->receipt->received_date ? intval($bill->receipt->received_date->diffInDays(now())) . ' days' : 'N/A' }}</td>
                                        <td class="text-end">{{ number_format($bill->balance, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-calendar-plus me-1"></i> Create Schedule
                </button>
            </div>
        </form>
    @else
        <div class="alert alert-info text-center">
            No bills ready to schedule.
        </div>
    @endif
</div>
@endsection
