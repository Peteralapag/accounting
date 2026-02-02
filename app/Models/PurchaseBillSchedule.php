<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseBillSchedule extends Model
{
    protected $table = 'purchase_bill_schedules';

    protected $fillable = [
        'bill_id',
        'scheduled_date',
        'scheduled_amount',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date:Y-m-d',
        'scheduled_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relation back to bill
    public function bill()
    {
        return $this->belongsTo(PurchaseBill::class, 'bill_id');
    }
}
