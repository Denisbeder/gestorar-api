<?php

namespace App\Models;

use App\Enums\WorkOrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrder extends Model
{
    /** @use HasFactory<\Database\Factories\WorkOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'code',
        'status',
        'date',
        'validity',
        'extra',
        'discount',
        'description',
        'extra_description',
        'discount_description',
        'services',
        'attachments',
        'sent_at',
        'read_at',
        'approved_at',
        'declined_at',
        'cancelled_at',
        'completed_at',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => WorkOrderStatusEnum::class,
            'date' => 'date',
            'validity' => 'date',
            'extra' => 'decimal',
            'discount' => 'decimal',
            'services' => 'collection',
            'attachments' => 'collection',
            'sent_at' => 'datetime',
            'read_at' => 'datetime',
            'approved_at' => 'datetime',
            'declined_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'completed_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
