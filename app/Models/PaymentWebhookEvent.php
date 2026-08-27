<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentWebhookEvent extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'event_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'event_id',
        'event_type',
        'environment',
        'registration_id',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'processed_at' => 'datetime',
        ];
    }
}
