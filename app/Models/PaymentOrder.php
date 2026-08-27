<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentOrder extends Model
{
    use HasUuids;

    protected $fillable = [
        'id',
        'token',
        'order_number',
        'registration_id',
        'total_cost',
        'remaining_amount',
        'paid',
        'status',
        'meta',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'total_cost' => 'integer',
            'remaining_amount' => 'integer',
            'paid' => 'boolean',
            'meta' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
