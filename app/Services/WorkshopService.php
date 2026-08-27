<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\Waitlist;
use Carbon\Carbon;

class WorkshopService
{
    public function seats(): int
    {
        return (int) config('workshop.seats', 10);
    }

    public function deposit(): int
    {
        return (int) config('workshop.deposit', 200);
    }

    public function dates(): array
    {
        return config('workshop.dates', []);
    }

    public function cancellationDays(): int
    {
        return (int) config('workshop.cancellation_days', 3);
    }

    public function seatsLeft(string $workshopDate): int
    {
        $taken = Registration::query()
            ->where('workshop_date', $workshopDate)
            ->whereNull('cancelled_at')
            ->whereIn('payment_status', ['pending', 'paid'])
            ->count();

        return max(0, $this->seats() - $taken);
    }

    public function seatsOverview(): array
    {
        $rows = [];

        foreach ($this->dates() as $date) {
            $rows[] = [
                'workshop_date' => $date,
                'seats_left' => $this->seatsLeft($date),
                'waitlist_count' => Waitlist::query()->where('workshop_date', $date)->count(),
            ];
        }

        return $rows;
    }

    public function daysUntil(string $workshopDate): int
    {
        $today = Carbon::now('Asia/Jerusalem')->startOfDay();
        $date = Carbon::createFromFormat('Y-m-d', $workshopDate, 'Asia/Jerusalem')->startOfDay();

        return $today->diffInDays($date, false);
    }

    public function status(Registration $registration): array
    {
        $days = $this->daysUntil($registration->workshop_date);

        return [
            'first_name' => $registration->first_name,
            'workshop_date' => $registration->workshop_date,
            'payment_status' => $registration->payment_status,
            'deposit_amount' => $registration->deposit_amount,
            'cancelled_at' => $registration->cancelled_at?->toIso8601String(),
            'refund_eligible' => $registration->refund_eligible,
            'days_until_workshop' => $days,
            'refundable_now' => $days > $this->cancellationDays(),
        ];
    }

    public function cancel(Registration $registration): array
    {
        $days = $this->daysUntil($registration->workshop_date);

        if ($registration->cancelled_at !== null) {
            return [
                'cancelled' => true,
                'refund_eligible' => (bool) $registration->refund_eligible,
                'days_until_workshop' => $days,
                'message' => 'already_cancelled',
            ];
        }

        $previousStatus = $registration->payment_status;
        $refundable = $days > $this->cancellationDays() && $previousStatus === 'paid';

        $newStatus = match (true) {
            $previousStatus === 'paid' && $days > $this->cancellationDays() => 'cancelled_refund_due',
            $previousStatus === 'paid' => 'cancelled_no_refund',
            default => 'cancelled',
        };

        $registration->update([
            'cancelled_at' => now(),
            'refund_eligible' => $refundable,
            'payment_status' => $newStatus,
            'cancellation_note' => 'auto: '.$days.' days before workshop',
        ]);

        $registration->logs()->create([
            'event_type' => 'cancelled',
            'metadata' => [
                'days_until_workshop' => $days,
                'refund_eligible' => $refundable,
                'previous_payment_status' => $previousStatus,
            ],
            'created_at' => now(),
        ]);

        return [
            'cancelled' => true,
            'refund_eligible' => $refundable,
            'days_until_workshop' => $days,
            'message' => 'cancelled',
        ];
    }
}
