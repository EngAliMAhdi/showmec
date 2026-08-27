<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    use HasUuids;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'workshop_date',
        'terms_accepted',
        'terms_accepted_at',
        'payment_status',
        'deposit_amount',
        'payment_reference',
        'invitation_sent_at',
        'cancelled_at',
        'refund_eligible',
        'cancellation_note',
        'reminder_sent_at',
        'invitation_attempts',
        'invitation_last_attempt_at',
        'invitation_next_retry_at',
        'invitation_last_error',
    ];

    protected function casts(): array
    {
        return [
            'terms_accepted' => 'boolean',
            'refund_eligible' => 'boolean',
            'deposit_amount' => 'integer',
            'invitation_attempts' => 'integer',
            'terms_accepted_at' => 'datetime',
            'invitation_sent_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'reminder_sent_at' => 'datetime',
            'invitation_last_attempt_at' => 'datetime',
            'invitation_next_retry_at' => 'datetime',
        ];
    }

    public function logs(): HasMany
    {
        return $this->hasMany(RegistrationLog::class);
    }

    public function paymentOrder(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PaymentOrder::class);
    }
}
