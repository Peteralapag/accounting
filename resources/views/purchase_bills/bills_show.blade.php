@extends('layouts.app')

@section('title', 'Purchase Bill Details')

@section('content')

@push('styles')
<style>
    .info-label {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: .03em;
    }
    .info-value {
        font-weight: 600;
        font-size: 0.95rem;
    }
    .section-title {
        font-weight: 600;
        letter-spacing: .02em;
    }

    /* Read-only fields have a subtle gray background */
    textarea[readonly] {
        background-color: #f8f9fa; /* light gray */
        border-color: #ced4da;     /* softer border */
        color: #495057;            /* slightly muted text */
        resize: none;              /* prevent resizing */
    }

    /* Editable fields stay white and more prominent */
    textarea:not([readonly]) {
        background-color: #ffffff; /* white */
        border-color: #0d6efd;     /* primary blue border */
        color: #212529;            /* normal text color */
        transition: background-color 0.2s, border-color 0.2s;
    }

    /* Optional: subtle hover/focus effect for editable fields */
    textarea:not([readonly]):focus {
        background-color: #e7f1ff; /* very light blue on focus */
        border-color: #0a58ca;     /* darker blue border on focus */
        outline: none;
    }


</style>
@endpush

<div class="container py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Bill Details</h3>
        <a href="{{ route('purchase_bills.index') }}" class="btn btn-outline-primary btn-sm shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Bills
        </a>
    </div>

    
    
    <!-- Bill Information -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white fw-bold">Bill Information</div>
        <div class="card-body">

            @php
                $billDateFormatted = $bill->bill_date ? $bill->bill_date->format('M d, Y') : '-';
                $dueDateFormatted  = $bill->due_date ? $bill->due_date->format('M d, Y') : '-';
                $canEditInvoice = ($bill->status == 'draft' && $bill->approval_status == 'pending');
            @endphp

            <!-- Top Info Row -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="info-label">Bill No</div>
                        <div class="info-value">{{ $bill->bill_no }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="info-label">Receipt #</div>
                        <div class="info-value">{{ $bill->receipt->receipt_no ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="info-label">PO #</div>
                        <div class="info-value">{{ $bill->receipt->purchaseOrder->po_number ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Supplier / Branch / Status Row -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="info-label">Supplier</div>
                        <div class="info-value">{{ $bill->receipt->purchaseOrder->supplier->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="info-label">Branch</div>
                        <div class="info-value">{{ $bill->branch }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="info-label">Status</div>
                        <div>
                            <span class="badge 
                                @if($bill->status=='paid') bg-success 
                                @elseif($bill->status=='pending') bg-warning text-dark 
                                @else bg-secondary @endif">
                                {{ ucfirst($bill->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3 align-items-center">

            <!-- Bill Date -->
            <div class="col-md-3">
                <div class="border rounded p-3 h-100">
                    <div class="info-label">Bill Date</div>
                    <div class="info-value">{{ $billDateFormatted }}</div>
                </div>
            </div>

            <!-- TERMS -->
            <div class="col-md-3">
                <div class="border rounded p-3 h-100">
                    <div class="info-label mb-1">Terms</div>

                    @if($canEditInvoice)
                        <select id="terms" class="form-select form-select-sm border border-primary">
                            <option value="">Select Terms</option>
                            <option value="0" {{ $bill->payment_terms == 0 ? 'selected' : '' }}>COD</option>
                            <option value="7" {{ $bill->payment_terms == 7 ? 'selected' : '' }}>7 Days</option>
                            <option value="15" {{ $bill->payment_terms == 15 ? 'selected' : '' }}>15 Days</option>
                            <option value="30" {{ $bill->payment_terms == 30 ? 'selected' : '' }}>30 Days</option>
                            <option value="60" {{ $bill->payment_terms == 60 ? 'selected' : '' }}>60 Days</option>
                        </select>
                    @else
                        <div class="info-value">
                            {{ $bill->payment_terms ?? '-' }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Due Date -->
            <div class="col-md-3">
                <div class="border rounded p-3 h-100">
                    <div class="info-label">Due Date</div>
                    <div class="info-value" id="due_date_display">
                        {{ $dueDateFormatted }}
                    </div>
                </div>
            </div>

            <!-- Invoice No -->
            <div class="col-md-3">
                <div class="border rounded p-3 h-100">
                    <div class="info-label mb-1">Invoice No</div>

                    @if($canEditInvoice)
                        <input type="text"
                            class="form-control form-control-sm border border-primary"
                            id="invoice_no"
                            value="{{ $bill->supplier_invoice_no ?? '' }}"
                            placeholder="Enter Invoice No">
                    @else
                        <div class="info-value">
                            {{ $bill->supplier_invoice_no ?? '-' }}
                        </div>
                    @endif
                </div>
            </div>

        </div>


            <!-- Remarks Row (Branch + General) -->
            <div class="row g-3">
                <!-- Branch Remarks (Read-only) -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-primary bg-opacity-10 fw-bold text-primary">
                            Branch Remarks
                        </div>
                        <div class="card-body p-2">
                            <textarea id="branch_remarks" class="form-control form-control-sm" rows="3" readonly>{{ $bill->branch_remarks ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- General Remarks (Editable) -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-secondary bg-opacity-10 fw-bold text-secondary">
                            Remarks
                        </div>
                        <div class="card-body p-2">
                            <textarea id="remarks" class="form-control form-control-sm" rows="3" placeholder="{{ $canEditInvoice ? 'Add general remarks...' : '' }}" {{ $canEditInvoice ? '' : 'readonly' }}>{{ $bill->remarks ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <!-- Bill Items -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-secondary text-white fw-bold">Bill Items</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Item Description</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bill->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->purchaseOrderItem->description ?? 'N/A' }}</td>
                            <td class="text-end">{{ $item->qty }}</td>
                            <td class="text-end">{{ number_format($item->unit_price,2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($item->amount,2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No items found for this bill.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($bill->items->count())
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="text-end fw-bold">{{ number_format($bill->items->sum('amount'),2) }}</th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Tax & Total -->
    <div class="card-body">
        @php
            $total = $bill->items->sum('amount');
            $taxType = $bill->tax_type ?? 'Non-VAT';
            $vatrate = $bill->vat_rate ?? 0;
            $withholdingrate = $bill->withholding_rate ?? 0;

            $vatAmount = ($taxType=='VAT') ? $total * $vatrate : 0;
            $withholdingAmount = ($taxType=='Withholding') ? $total * $withholdingrate : 0;
            $grandTotal = $total - $vatAmount - $withholdingAmount;
        @endphp

        <div class="row g-3">

            <!-- TAX TYPE -->
            <div class="col-md-4">
                <div class="border rounded p-3 h-100">
                    <div class="info-label mb-1">Tax Type</div>
                    
                    @if($bill->status == 'draft' && $bill->approval_status == 'pending')
                        <select class="form-select form-select-sm info-value" id="tax_type" style="width: 100%;">
                            @php $taxOptions = ['Non-VAT', 'VAT', 'Withholding']; @endphp
                            @foreach($taxOptions as $option)
                                <option value="{{ $option }}" {{ $taxType == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <div class="info-value">{{ $taxType }}</div>
                    @endif
                </div>
            </div>

            <!-- VAT -->
            <div class="col-md-4">
                <div class="border rounded p-3 h-100 {{ $vatAmount ? 'bg-warning bg-opacity-10' : 'bg-light' }}">
                    <div class="info-label mb-1">
                        VAT
                        <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" title="VAT is computed based on supplier VAT rate"></i>
                    </div>
                    @if($bill->status == 'draft' && $bill->approval_status == 'pending')
                        <input type="number" step="0.01" min="0" max="1"
                            class="form-control form-control-sm info-value text-warning"
                            id="vat_rate"
                            value="{{ $vatrate }}">
                    @else
                        <div class="info-value text-warning">{{ $vatrate }}</div>
                    @endif
                </div>
            </div>

            <!-- WITHHOLDING -->
            <div class="col-md-4">
                <div class="border rounded p-3 h-100 {{ $withholdingAmount ? 'bg-danger bg-opacity-10' : 'bg-light' }}">
                    <div class="info-label mb-1">
                        Withholding
                        <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip" title="Withholding tax deducted based on supplier rate"></i>
                    </div>
                    @if($bill->status == 'draft' && $bill->approval_status == 'pending')
                        <input type="number" step="0.01" min="0" max="1"
                            class="form-control form-control-sm info-value text-danger"
                            id="withholding_rate"
                            value="{{ $withholdingrate }}">
                    @else
                        <div class="info-value text-danger">{{ $withholdingrate }}</div>
                    @endif
                </div>
            </div>

        </div>


        <hr class="my-4">

        <!-- GRAND TOTAL -->
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold fs-5">Grand Total</span>
            <span class="fw-bold text-success fs-4">
                {{ number_format($grandTotal,2) }}
            </span>
        </div>
    </div>


    <!-- AProcess A/P Button -->
    @if($bill->approval_status == 'pending' && $bill->status == 'draft')
    <div class="d-flex justify-content-end mb-4 mt-4">
        <form id="processApForm" action="{{ route('bill_approval.process', $bill->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm fw-bold shadow-sm">
                <i class="bi bi-gear"></i> Process A/P
            </button>
        </form>
    </div>
    @endif
    <!-- Approve A/P Button -->
    @if($bill->approval_status == 'pending' && $bill->status == 'process')
    <div class="d-flex justify-content-end mb-4 mt-4">
        <form id="approveApForm" action="{{ route('bill_approval.approve', $bill->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm fw-bold shadow-sm">
                <i class="bi bi-check-circle me-1"></i> Approve A/P
            </button>
        </form>
    </div>
    @endif

</div>
@endsection


@push('scripts')
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const processForm = document.getElementById('processApForm');
    if (processForm) {
        
        processForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const invoiceNo = document.getElementById('invoice_no')?.value.trim();
        if (!invoiceNo) {
            Swal.fire({
                icon: 'warning',
                title: 'Invoice No is required!',
                text: 'Please enter the Invoice Number before processing.',
            }).then(() => document.getElementById('invoice_no').focus());
            return;
        }

        const taxType = document.querySelector('#tax_type')?.value || 'Non-VAT';
        let vatRate = parseFloat(document.querySelector('#vat_rate')?.value || 0);
        let withholdingRate = parseFloat(document.querySelector('#withholding_rate')?.value || 0);
        

        vatRate = isNaN(vatRate) ? 0 : vatRate;
        withholdingRate = isNaN(withholdingRate) ? 0 : withholdingRate;

        Swal.fire({
            title: 'Process Accounts Payable?',
            text: 'This bill will be sent to A/P approval.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, process it',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (!result.isConfirmed) return;

            const data = {
                _token: processForm.querySelector('[name="_token"]').value,
                remarks: document.getElementById('remarks')?.value.trim() || '',
                payment_terms: document.getElementById('terms')?.value || 0,
                supplier_invoice_no: invoiceNo,
                tax_type: taxType,
                vat_rate: vatRate,
                withholding_rate: withholdingRate
            };

            fetch(processForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': processForm.querySelector('[name="_token"]').value
                },
                body: JSON.stringify({
                    remarks: document.getElementById('remarks')?.value.trim() || '',
                    payment_terms: document.getElementById('terms')?.value || 0,
                    supplier_invoice_no: document.getElementById('invoice_no')?.value.trim(),
                    tax_type: document.querySelector('#tax_type')?.value || 'Non-VAT',
                    vat_rate: parseFloat(document.querySelector('#vat_rate')?.value || 0),
                    withholding_rate: parseFloat(document.querySelector('#withholding_rate')?.value || 0)
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Processed!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => window.location.href = "{{ route('purchase_bills.index') }}");
                } else {
                    Swal.fire('Error', data.message || 'Validation failed!', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Server or network error occurred. Check console for details.', 'error');
            });

        });
    });

    
    }


    // Approve
    const approveForm = document.getElementById('approveApForm');
    if (approveForm) {
        approveForm.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Approve this bill?',
                text: 'This action will mark the bill as approved.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#198754'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(approveForm);
                    fetch(approveForm.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async res => {
                        if (!res.ok) {
                            const text = await res.text();
                            throw new Error(text || 'Server error');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if(data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('purchase_bills.index') }}";
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong!', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    });
                }
            });
        });
    }

});

// Dynamic Tax Type behavior
const taxTypeSelect = document.querySelector('#tax_type');
const vatInput = document.querySelector('#vat_rate');
const withholdingInput = document.querySelector('#withholding_rate');

if (taxTypeSelect && vatInput && withholdingInput) {
    const updateTaxFields = () => {
        const value = taxTypeSelect.value;
        if (value === 'VAT') {
            vatInput.disabled = false;
            vatInput.classList.remove('bg-light');
            vatInput.classList.add('text-warning');
            
            withholdingInput.disabled = true;
            withholdingInput.value = 0;
            withholdingInput.classList.remove('text-danger');
            withholdingInput.classList.add('bg-light');
        } else if (value === 'Withholding') {
            withholdingInput.disabled = false;
            withholdingInput.classList.remove('bg-light');
            withholdingInput.classList.add('text-danger');
            
            vatInput.disabled = true;
            vatInput.value = 0;
            vatInput.classList.remove('text-warning');
            vatInput.classList.add('bg-light');
        } else { // Non-VAT
            vatInput.disabled = true;
            vatInput.value = 0;
            vatInput.classList.remove('text-warning');
            vatInput.classList.add('bg-light');

            withholdingInput.disabled = true;
            withholdingInput.value = 0;
            withholdingInput.classList.remove('text-danger');
            withholdingInput.classList.add('bg-light');
        }
    };

    // Initial call
    updateTaxFields();

    // Listen for changes
    taxTypeSelect.addEventListener('change', updateTaxFields);
}



</script>
@endpush
