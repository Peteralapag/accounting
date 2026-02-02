<!-- Bill Details & Payment Modal -->
<div class="modal fade" id="billModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="billPaymentForm" method="POST" action="{{ route('pay_bills.storePayment') }}">
            @csrf
            <input type="hidden" name="bill_id" id="modalBillId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bill Details & Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Bill No:</strong> <span id="modalBillNo"></span></div>
                        <div class="col-md-4"><strong>Supplier:</strong> <span id="modalSupplier"></span></div>
                        <div class="col-md-4"><strong>Bill Date:</strong> <span id="modalBillDate"></span></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Due Date:</strong> <span id="modalDueDate"></span></div>
                        <div class="col-md-4"><strong>Balance:</strong> <span id="modalBalance"></span></div>
                        <div class="col-md-4"><strong>Approved At:</strong> <span id="modalApprovedAt"></span></div>
                    </div>

                    <!-- Payment input -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Payment Date</label>
                            <input type="date" name="payment_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" name="amount_paid" class="form-control" step="0.01" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-control">
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Reference No</label>
                            <input type="text" name="reference_no" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Post Payment</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
