<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseBillPayment extends Model
{
    protected $table = 'purchase_bill_payments';

    protected $fillable = [
        'bill_id',
        'payment_date',
        'payment_account',
        'payment_method',
        'reference_no',
        'amount_paid',
        'balance_after_payment',
        'status',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'datetime:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function bill()
    {
        return $this->belongsTo(PurchaseBill::class, 'bill_id');
    }
}