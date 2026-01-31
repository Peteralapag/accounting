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
                                        <button type="button" class="btn btn-primary btn-sm pay-btn" 
                                                data-bill-id="{{ $bill->id }}" 
                                                data-balance="{{ $bill->balance }}">
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

<!-- Pay Modal -->
<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="payForm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pay Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="bill_id" id="modal_bill_id">
                
                <div class="mb-3">
                    <label for="amount_paid" class="form-label">Amount to Pay</label>
                    <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select id="payment_method" name="payment_method" class="form-select" required>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="PDC">PDC</option>
                    </select>
                </div>

                <div class="mb-3 pdc-field d-none">
                    <label for="pdc_number" class="form-label">PDC Number</label>
                    <input type="text" id="pdc_number" name="pdc_number" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" id="payment_date" name="payment_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="payment_account" class="form-label">Payment Account</label>
                    <input type="text" id="payment_account" name="payment_account" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="reference_no" class="form-label">Reference No</label>
                    <input type="text" id="reference_no" name="reference_no" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea id="remarks" name="remarks" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit Payment</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Show modal on Pay button click
    document.querySelectorAll('.pay-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const billId = this.dataset.billId;
            const balance = this.dataset.balance;

            document.getElementById('modal_bill_id').value = billId;
            document.getElementById('amount_paid').value = balance;
            document.getElementById('payModal').classList.add('show');
            document.getElementById('payModal').style.display = 'block';
        });
    });

    // Toggle PDC number input
    document.getElementById('payment_method').addEventListener('change', function(){
        const pdcField = document.querySelector('.pdc-field');
        pdcField.classList.toggle('d-none', this.value !== 'PDC');
    });

    // Handle submit via AJAX
    document.getElementById('payForm').addEventListener('submit', function(e){
        e.preventDefault();
        const formData = Object.fromEntries(new FormData(this).entries());

        fetch("{{ route('pay_bills.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                location.reload(); // reload to update table
            } else {
                alert(data.message || 'Error processing payment');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error processing payment');
        });
    });
});
</script>
@endpush