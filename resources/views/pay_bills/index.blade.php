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

    <!-- Bills Table -->
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bills as $index => $bill)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $bill['bill_no'] }}</td>
                                <td>{{ $bill['receipt']['purchaseOrder']['supplier']['name'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($bill['bill_date'])->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($bill['due_date'])->format('M d, Y') }}</td>
                                <td class="text-end">{{ number_format($bill['total_amount'],2) }}</td>
                                <td class="text-end">{{ number_format($bill['balance'],2) }}</td>
                                <td class="text-center">
                                    @if($bill['balance'] > 0)
                                        <button class="btn btn-primary btn-sm view-pay-btn" data-bill='@json($bill)'>
                                            <i class="bi bi-cash-stack me-1"></i> Pay / Details
                                        </button>
                                    @else
                                        <span class="badge bg-success">Paid</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No bills to pay.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pay + Details Modal -->
<div class="modal fade" id="payDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form id="payDetailForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bill Details & Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <input type="hidden" id="modal_bill_id" name="bill_id">

          <!-- Bill Summary -->
          <div class="row mb-3">
            <div class="col-md-3"><strong>Bill No:</strong> <span id="modalBillNo"></span></div>
            <div class="col-md-3"><strong>Supplier:</strong> <span id="modalSupplier"></span></div>
            <div class="col-md-3"><strong>Bill Date:</strong> <span id="modalBillDate"></span></div>
            <div class="col-md-3"><strong>Due Date:</strong> <span id="modalDueDate"></span></div>
          </div>
          <div class="row mb-3">
            <div class="col-md-3"><strong>Status:</strong> <span id="modalStatus"></span></div>
            <div class="col-md-3"><strong>Total Amount:</strong> <span id="modalTotalAmount"></span></div>
            <div class="col-md-3"><strong>Total Paid:</strong> <span id="modalTotalPaid"></span></div>
            <div class="col-md-3"><strong>Balance:</strong> <span id="modalBalance"></span></div>
          </div>

          <!-- Bill Items -->
          <h6>Items</h6>
          <div class="table-responsive mb-3">
            <table class="table table-bordered table-sm">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Description / Item</th>
                  <th class="text-end">Qty</th>
                  <th class="text-end">Unit Price</th>
                  <th class="text-end">Amount</th>
                </tr>
              </thead>
              <tbody id="modalItemsBody"></tbody>
            </table>
          </div>

          <!-- Payment History -->
          <h6>Payment History</h6>
          <div class="table-responsive mb-3">
            <table class="table table-bordered table-sm">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Payment Date</th>
                  <th>Method</th>
                  <th>Account</th>
                  <th>Reference</th>
                  <th class="text-end">Amount Paid</th>
                  <th class="text-end">Balance After Payment</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="modalPaymentsBody"></tbody>
            </table>
          </div>

          <!-- Payment Form -->
          <h6>Add Payment</h6>
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label">Amount</label>
              <input type="number" step="0.01" class="form-control" name="amount_paid" id="amount_paid" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Payment Method</label>
              <select class="form-select" name="payment_method" id="payment_method" required>
                <option value="Cash">Cash</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="PDC">PDC</option>
              </select>
            </div>
            <div class="col-md-3 pdc-field d-none">
              <label class="form-label">PDC Number</label>
              <input type="text" class="form-control" name="pdc_number" id="pdc_number">
            </div>
            <div class="col-md-3">
              <label class="form-label">Payment Date</label>
              <input type="date" class="form-control" name="payment_date" id="payment_date" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Payment Account</label>
              <input type="text" class="form-control" name="payment_account">
            </div>
            <div class="col-md-3">
              <label class="form-label">Reference No</label>
              <input type="text" class="form-control" name="reference_no">
            </div>
            <div class="col-md-6">
              <label class="form-label">Remarks</label>
              <textarea class="form-control" name="remarks"></textarea>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Submit Payment</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){

    const modalEl = document.getElementById('payDetailModal');
    const modal = new bootstrap.Modal(modalEl);

    function formatDate(dateStr){
        if(!dateStr) return '-';
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    }

    function formatNumber(num){
        return parseFloat(num ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Show modal and populate details
    document.querySelectorAll('.view-pay-btn').forEach(btn=>{
        btn.addEventListener('click', function(){
            const bill = JSON.parse(this.dataset.bill);

            document.getElementById('modal_bill_id').value = bill.id;
            document.getElementById('modalBillNo').textContent = bill.bill_no ?? '-';
            document.getElementById('modalSupplier').textContent = bill.receipt?.purchaseOrder?.supplier?.name ?? '-';
            document.getElementById('modalBillDate').textContent = formatDate(bill.bill_date);
            document.getElementById('modalDueDate').textContent = formatDate(bill.due_date);
            document.getElementById('modalStatus').textContent = bill.status ?? '-';
            document.getElementById('modalTotalAmount').textContent = formatNumber(bill.total_amount);
            document.getElementById('modalTotalPaid').textContent = formatNumber(bill.paid_amount ?? 0);
            document.getElementById('modalBalance').textContent = formatNumber(bill.balance ?? bill.total_amount);

            // Populate items
            const itemsBody = document.getElementById('modalItemsBody');
            itemsBody.innerHTML = '';
            (bill.items || []).forEach((item,i)=>{
                itemsBody.innerHTML += `<tr>
                    <td>${i+1}</td>
                    <td>${item.receipt_item_id ?? '-'}</td>
                    <td class="text-end">${formatNumber(item.qty)}</td>
                    <td class="text-end">${formatNumber(item.unit_price)}</td>
                    <td class="text-end">${formatNumber(item.amount)}</td>
                </tr>`;
            });

            // Populate payment history
            const paymentsBody = document.getElementById('modalPaymentsBody');
            paymentsBody.innerHTML = '';
            (bill.payments || []).forEach((p,i)=>{
                paymentsBody.innerHTML += `<tr>
                    <td>${i+1}</td>
                    <td>${formatDate(p.payment_date)}</td>
                    <td>${p.payment_method ?? '-'}</td>
                    <td>${p.payment_account ?? '-'}</td>
                    <td>${p.reference_no ?? '-'}</td>
                    <td class="text-end">${formatNumber(p.amount_paid)}</td>
                    <td class="text-end">${formatNumber(p.balance_after_payment)}</td>
                    <td>${p.status ?? '-'}</td>
                </tr>`;
            });

            // Reset pay form
            document.getElementById('amount_paid').value = bill.balance ?? bill.total_amount;
            document.getElementById('payment_method').value = 'Cash';
            document.querySelector('.pdc-field').classList.add('d-none');

            modal.show();
        });
    });

    // PDC toggle field
    document.getElementById('payment_method').addEventListener('change', function(){
        document.querySelector('.pdc-field').classList.toggle('d-none', this.value !== 'PDC');
    });

    // Submit payment via AJAX
    document.getElementById('payDetailForm').addEventListener('submit', function(e){
        e.preventDefault();
        const formData = Object.fromEntries(new FormData(this).entries());

        fetch("{{ route('pay_bills.store') }}", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                const bill = data.bill;

                // --- Update modal summary ---
                document.getElementById('modalTotalPaid').textContent = formatNumber(bill.paid_amount);
                document.getElementById('modalBalance').textContent = formatNumber(bill.balance);
                document.getElementById('modalStatus').textContent = bill.status;

                // --- Update payment history ---
                const paymentsBody = document.getElementById('modalPaymentsBody');
                paymentsBody.innerHTML = '';
                (bill.payments || []).forEach((p,i)=>{
                    paymentsBody.innerHTML += `<tr>
                        <td>${i+1}</td>
                        <td>${formatDate(p.payment_date)}</td>
                        <td>${p.payment_method ?? '-'}</td>
                        <td>${p.payment_account ?? '-'}</td>
                        <td>${p.reference_no ?? '-'}</td>
                        <td class="text-end">${formatNumber(p.amount_paid)}</td>
                        <td class="text-end">${formatNumber(p.balance_after_payment)}</td>
                        <td>${p.status ?? '-'}</td>
                    </tr>`;
                });

                // --- Update main table row dynamically ---
                document.querySelectorAll('.view-pay-btn').forEach(btn=>{
                    const btnBill = JSON.parse(btn.dataset.bill);
                    if(btnBill.id == bill.id){
                        btn.dataset.bill = JSON.stringify(bill);
                        const tr = btn.closest('tr');
                        tr.querySelector('td:nth-child(7)').textContent = formatNumber(bill.balance);
                        const actionCell = tr.querySelector('td:nth-child(8)');
                        if(bill.balance <= 0){
                            actionCell.innerHTML = `<span class="badge bg-success">Paid</span>`;
                        }
                    }
                });

                // --- Reset payment form ---
                document.getElementById('amount_paid').value = bill.balance;
                document.getElementById('payment_method').value = 'Cash';
                document.querySelector('.pdc-field').classList.add('d-none');

                // SweetAlert2 success
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Posted!',
                    text: data.message || 'Payment has been recorded successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });

            } else {
                // SweetAlert2 error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message || 'Error processing payment.',
                });
            }
        })
        .catch(err=>{
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong while posting the payment.'
            });
        });
    });

});
</script>
@endpush
