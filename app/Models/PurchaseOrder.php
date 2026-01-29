<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    
    protected $table = 'purchase_orders';

    protected $fillable = [
        'po_number', 'pr_number', 'supplier_id', 'source', 'branch',
        'order_date', 'expected_delivery', 'status', 'subtotal', 'vat', 'total_amount',
        'vat_type', 'vat_rate', 'remarks', 'created_by', 'prepared_by', 'prepared_date',
        'reviewed_by', 'reviewed_date', 'approved_by', 'approved_date', 'updated_by',
        'closed_po', 'closed_by', 'closed_date'
    ];

    // Relationship sa items
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'po_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
