<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseBill extends Model
{
    protected $table = 'purchase_bills';

    protected $fillable = [
        'receipt_id',
        'bill_no',
        'bill_date',
        'due_date',
        'balance',
        'branch',
        'remarks',
        'tax_type',
        'status',
        'total_amount',
        'vat_amount',
        'withholding_amount',
        'approval_status',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'bill_date' => 'datetime:Y-m-d',
        'due_date' => 'datetime:Y-m-d',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relation to receipt
    public function receipt()
    {
        return $this->belongsTo(PurchaseReceipt::class, 'receipt_id');
    }

    // Relation to bill items
    public function items()
    {
        return $this->hasMany(PurchaseBillItem::class, 'bill_id');
    }

    // Relation to payments
    public function payments()
    {
        return $this->hasMany(PurchaseBillPayment::class, 'bill_id');
    }
}