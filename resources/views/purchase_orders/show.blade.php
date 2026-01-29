@extends('layouts.app')

@section('title', 'Purchase Order')

<style>
.po-wrapper { font-size:13px; color:#000; }
.po-header { display:flex; justify-content:space-between; }
.po-box table,
.po-items { width:100%; border-collapse:collapse; }
.po-box td,
.po-items th,
.po-items td { border:1px solid #000; padding:5px; }
.po-items th { background:#f2f2f2; }

@media print {
    .no-print { display:none; }
    body { font-size:9px; }
}
</style>

@section('content')
<div class="po-wrapper" id="contents">

    {{-- ACTION BUTTONS --}}
    <div class="no-print d-flex justify-content-between mb-3">
        <div></div>
        <div>
            <a href="{{ route('purchase-orders.index') }}"
               class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- HEADER --}}
    <div class="po-header">
        <div>
            <strong>Jathnier Corporation</strong><br>
            Ruby St., RGA Village, Dacudao Ave,<br>
            Davao City, Philippines
        </div>
        <h3>Purchase Order</h3>
    </div>

    <br>

    {{-- PO INFO --}}
    <div class="po-box">
        <table>
            <tr>
                <td>Date</td>
                <td>{{ $po->order_date }}</td>
                <td>P.O. No.</td>
                <td>{{ $po->po_number }}</td>
                <td>P.R. No.</td>
                <td>{{ $po->pr_number }}</td>
                <td>Expected</td>
                <td>{{ $po->expected_delivery }}</td>
            </tr>
            <tr>
                <td colspan="4">
                    Vendor<br>
                    <strong>{{ $po->supplier->name ?? 'N/A' }}</strong>
                </td>
                <td colspan="4">
                    Ship To<br>
                    <strong>{{ $po->branch }}</strong>
                </td>
            </tr>
        </table>
    </div>

    <br>

    {{-- ITEMS --}}
    <table class="po-items">
        <thead>
            <tr>
                <th width="12%">Item</th>
                <th>Description</th>
                <th width="8%">Qty</th>
                <th width="8%">U/M</th>
                <th width="12%">Rate</th>
                <th width="14%">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($po->items as $item)
                <tr>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->description }}</td>
                    <td align="right">{{ number_format($item->qty,2) }}</td>
                    <td>{{ $item->uom }}</td>
                    <td align="right">{{ number_format($item->unit_price,2) }}</td>
                    <td align="right">{{ number_format($item->total_price,2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">No items found</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">{{ $po->remarks }}</td>
                <td colspan="2">
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>{{ number_format($po->total_amount,2) }}</strong>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>

    <br>

    {{-- SIGNATURES --}}
    <div style="display:flex; justify-content:space-between; margin-top:40px;">

        <div style="width:30%; text-align:center">
            @if($po->prepared_by)
                Prepared by<br>
                <strong>{{ $po->prepared_by }}</strong><br>
                <small>{{ $po->prepared_date }}</small>
            @endif
        </div>

        <div style="width:30%; text-align:center">
            @if($po->reviewed_by)
                Reviewed by<br>
                <strong>{{ $po->reviewed_by }}</strong><br>
                <small>{{ $po->reviewed_date }}</small>
            @endif
        </div>

        <div style="width:30%; text-align:center">
            @if($po->approved_by)
                Approved by<br>
                <strong>{{ $po->approved_by }}</strong><br>
                <small>{{ $po->approved_date }}</small>
            @endif
        </div>

    </div>

</div>
@endsection



@section('scripts')
<script>
function printContents() {

    var divContents = document.getElementById("contents").innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = divContents;
    window.print();
    document.body.innerHTML = originalContents;

}
</script>
@endsection
