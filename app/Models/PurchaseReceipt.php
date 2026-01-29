<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReceipt extends Model
{
    use HasFactory;

    protected $table = 'purchase_receipts';

    protected $casts = [
        'received_date' => 'date',
    ];

    protected $fillable = [
        'po_id', 'receipt_no', 'received_date', 'received_by', 
        'checked_by', 'branch', 'remarks', 'status'
    ];

    // Relation sa PO
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    // Relation sa receipt items
    public function items()
    {
        return $this->hasMany(PurchaseReceiptItem::class, 'receipt_id');
    }

    // **New relationship to bill**
    public function bill()
    {
        return $this->hasOne(PurchaseBill::class, 'receipt_id');
    }

}