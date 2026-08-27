<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    use HasUuids;

    protected $table = 'waitlist';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'workshop_date',
        'notified_at',
    ];

    protected function casts(): array
    {
        return [
            'notified_at' => 'datetime',
        ];
    }
}
