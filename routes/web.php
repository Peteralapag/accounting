<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PurchaseBillsController;
use App\Http\Controllers\PayBillsController;
use App\Http\Controllers\BillApprovalController;



Route::get('/login', function() {
    return view('auth.login'); // imong existing login.blade.php
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function() {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Purchase Orders
Route::middleware(['auth'])->group(function () {
    Route::get('/purchase-orders', [App\Http\Controllers\PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
    Route::post('/purchase-orders', [App\Http\Controllers\PurchaseOrderController::class, 'store'])->name('purchase-orders.store');
    Route::get('/purchase-orders/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'show'])->name('purchase-orders.show');
});

// Received
Route::middleware(['auth'])->group(function () {
    Route::get('/purchase_receipts', [App\Http\Controllers\PurchaseReceiptsController::class, 'index'])->name('purchase_receipts.index');
    Route::post('/purchase_receipts', [App\Http\Controllers\PurchaseReceiptsController::class, 'store'])->name('purchase_receipts.store');
    Route::get('/purchase_receipts/{id}', [App\Http\Controllers\PurchaseReceiptsController::class, 'show'])->name('purchase_receipts.show');
});

// Purchase Bills
Route::middleware(['auth'])->prefix('purchase_bills')->group(function() {
    Route::get('/create', [PurchaseBillsController::class,'create'])->name('purchase_bills.create');
    Route::get('/from-receipt/{receipt}', [PurchaseBillsController::class,'createFromReceipt'])->name('purchase_bills.createFromReceipt');
    Route::get('/', [PurchaseBillsController::class, 'index'])->name('purchase_bills.index');
    Route::post('/', [PurchaseBillsController::class, 'store'])->name('purchase_bills.store');
    Route::get('/view/{bill}', [PurchaseBillsController::class, 'show'])->name('purchase_bills.show');
    Route::get('/showpb/{id}', [PurchaseBillsController::class, 'showpb'])->name('purchase_bills.showpb');
    Route::post('/approve/{bill}', [BillApprovalController::class, 'approve'])->name('bill_approval.approve');

    Route::get('/datatable', [PurchaseBillsController::class, 'datatable'])->name('purchase_bills.datatable');
});

// Pay Bills
Route::middleware(['auth'])->prefix('pay_bills')->group(function () {
    Route::get('/', [App\Http\Controllers\PayBillsController::class, 'index'])->name('pay_bills.index');
    Route::post('/store', [App\Http\Controllers\PayBillsController::class, 'store'])->name('pay_bills.store');
});