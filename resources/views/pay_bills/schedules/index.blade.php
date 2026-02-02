@extends('layouts.app')
@section('title','Pay Bills')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">Pay Bills Module</h3>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#ready">Ready to Schedule</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#scheduled">Scheduled</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#paid">Paid</a>
        </li>
    </ul>

    <div class="tab-content">
        @foreach(['ready'=>'Ready to Schedule','scheduled'=>'Scheduled','approved'=>'Approved','paid'=>'Paid'] as $key => $label)
            <div class="tab-pane fade {{ $key=='ready'?'show active':'' }}" id="{{ $key }}">
                @include('pay_bills.partials.table', ['bills' => $$key])
            </div>
        @endforeach
    </div>
</div>
@endsection
