@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="row mb-3">
        <div class="col">
            <h4>Create Purchase Bill</h4>
        </div>
    </div>

    {{-- BILL & SUPPLIER INFO --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">

                {{-- LEFT: Supplier Info --}}
                <div class="col-md-6">
                    <div class="mb-2">
                        <label class="form-label">Supplier</label>
                        <input type="text" class="form-control" readonly
                               value="{{ $receipt->purchaseOrder->supplier->name }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="2" readonly>{{ $receipt->purchaseOrder->supplier->address ?? '-' }}</textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Terms</label>
                        <input type="text" class="form-control" readonly
                               value="{{ $receipt->purchaseOrder->supplier->terms ?? '-' }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Memo</label>
                        <input type="text" class="form-control" id="memo">
                    </div>
                </div>

                {{-- RIGHT: Bill Info --}}
                <div class="col-md-6">
                    <div class="mb-2">
                        <label class="form-label">Bill No</label>
                        <input type="text" id="bill_no" class="form-control" value="{{ $receipt->purchaseOrder->po_number }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Bill Date</label>
                        <input type="date" id="bill_date" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Due Date</label>
                        <input type="date" id="due_date" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Class / Branch</label>
                        <input type="text" class="form-control" readonly value="{{ $receipt->branch }}">
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ITEMS TABLE --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th width="120">Qty</th>
                        <th width="150">Rate</th>
                        <th width="150">Amount</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($receipt->items as $i => $item)
                    <tr data-id="{{ $item->id }}">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ optional($item->poItem)->description ?? 'Item' }}</td>
                        <td><input type="number" class="form-control qty" value="{{ $item->received_qty }}" step="0.01" min="0"></td>
                        <td><input type="number" class="form-control rate" value="{{ $item->unit_price }}" step="0.01" min="0"></td>
                        <td class="amount text-end">{{ number_format($item->received_qty * $item->unit_price, 2) }}</td>
                        <td><input type="text" class="form-control remarks"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- GRAND TOTAL --}}
    <div class="row mt-3">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class="table">
                <tr>
                    <th class="text-end">Grand Total</th>
                    <th class="text-end" id="grandTotal">0.00</th>
                </tr>
            </table>
        </div>
    </div>

    {{-- SAVE BUTTON --}}
    <div class="text-end">
        <button class="btn btn-primary" id="saveBill">Save Bill</button>
    </div>

</div>
@endsection

@section('scripts')
<script>
function recalc() {
    let total = 0;
    document.querySelectorAll('tbody tr').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const amount = qty * rate;
        row.querySelector('.amount').textContent = amount.toFixed(2);
        total += amount;
    });
    document.getElementById('grandTotal').textContent = total.toFixed(2);
}

// Bind input events
document.querySelectorAll('.qty, .rate').forEach(el => el.addEventListener('input', recalc));
recalc();

// Save Bill via AJAX
document.getElementById('saveBill').addEventListener('click', function() {
    const billNo = document.getElementById('bill_no').value.trim();
    const billDate = document.getElementById('bill_date').value;
    const dueDate = document.getElementById('due_date').value;
    const memo = document.getElementById('memo').value;

    if(!billNo || !billDate || !dueDate){
        alert("Please fill Bill No, Bill Date, and Due Date");
        return;
    }

    const items = Array.from(document.querySelectorAll('tbody tr')).map(row => ({
        receipt_item_id: row.dataset.id,
        qty: parseFloat(row.querySelector('.qty').value),
        unit_price: parseFloat(row.querySelector('.rate').value),
        remarks: row.querySelector('.remarks').value
    }));

    fetch("{{ route('purchase_bills.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            receipt_id: "{{ $receipt->id }}",
            bill_no: billNo,
            bill_date: billDate,
            due_date: dueDate,
            branch: "{{ $receipt->branch }}",
            memo: memo,
            items: items
        })
    })
    .then(res => res.json())
    .then(resp => {
        if(resp.status === 'success'){
            alert(resp.msg);
            window.location.href = "{{ route('purchase_bills.index') }}";
        } else {
            alert(resp.msg || 'Failed to save bill');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Unexpected error occurred');
    });
});
</script>
@endsection