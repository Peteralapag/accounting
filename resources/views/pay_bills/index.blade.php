@extends('layouts.app')

@section('title', 'Pay Bills')

@section('content')
<div class="container">
    <h3 class="mb-4">Pay Bills</h3>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('pay_bills.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <label for="date_from" class="form-label">Date From</label>
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="form-control">
        </div>
        <div class="col-auto">
            <label for="date_to" class="form-label">Date To</label>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="form-control">
        </div>
        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Bill No</th>
                            <th>Supplier</th>
                            <th>Terms (days)</th>
                            <th>Bill Date</th>
                            <th>Due Date</th>
                            <th>Total Amount</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bills as $index => $bill)
                            @php
                                $termsDays = (int) ($bill->receipt->purchaseOrder->supplier->payment_terms ?? 0);
                                $billDate = \Carbon\Carbon::parse($bill->bill_date);
                                $dueDate = $termsDays ? $billDate->copy()->addDays($termsDays) : $billDate;
                                $supplierName = $bill->receipt->purchaseOrder->supplier->name ?? '-';
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $bill->bill_no }}</td>
                                <td>{{ $supplierName }}</td>
                                <td class="text-center">{{ $termsDays }}</td>
                                <td>{{ $billDate->format('M d, Y') }}</td>
                                <td>{{ $dueDate->format('M d, Y') }}</td>
                                <td class="text-end">{{ number_format($bill->total_amount,2) }}</td>
                                <td class="text-end">{{ number_format($bill->balance,2) }}</td>
                                <td class="text-center">
                                    @if($bill->balance > 0)
                                        <button type="button" class="btn btn-primary btn-sm pay-btn" data-bill-id="{{ $bill->id }}">
                                            <i class="bi bi-cash-stack me-1"></i> Pay
                                        </button>
                                    @else
                                        <span class="badge bg-success">Paid</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No bills to pay.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection





@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pay-btn').forEach(button => {
        button.addEventListener('click', function() {
            let billId = this.dataset.billId;
            let btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing';

            fetch("{{ route('pay_bills.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ bill_id: billId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    btn.closest('td').innerHTML = '<span class="badge bg-success">Paid</span>';
                } else {
                    alert(data.message || 'Error processing payment');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-cash-stack me-1"></i> Pay';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error processing payment');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-cash-stack me-1"></i> Pay';
            });
        });
    });
});
</script>
@endpush