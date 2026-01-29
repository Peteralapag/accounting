<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseBillItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id', 'receipt_item_id', 'qty', 'unit_price', 'amount', 'remarks'
    ];

    public function bill()
    {
        return $this->belongsTo(PurchaseBill::class);
    }

    public function receiptItem()
    {
        return $this->belongsTo(PurchaseReceiptItem::class, 'receipt_item_id');
    }

    /// app/Models/PurchaseBillItem.php
    public function purchaseOrderItem()
    {
        return $this->hasOneThrough(
            PurchaseOrderItem::class,      // Final model
            PurchaseReceiptItem::class,    // Intermediate model
            'id',                          // Foreign key on intermediate model? (receipt_item.id)
            'id',                          // Foreign key on final model? (purchase_order_items.id)
            'receipt_item_id',             // Local key on PurchaseBillItem
            'po_item_id'                   // Local key on PurchaseReceiptItem (this links to purchase_order_items.id)
        );
    }
}