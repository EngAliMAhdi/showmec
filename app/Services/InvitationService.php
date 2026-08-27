<?php

namespace App\Services;

use App\Mail\WorkshopInvitation;
use App\Models\Registration;
use Illuminate\Support\Facades\Mail;
use Throwable;

class InvitationService
{
    public const MAX_ATTEMPTS = 5;

    public function attempt(Registration $registration, bool $manual = false): array
    {
        $wasSent = $registration->invitation_sent_at !== null;

        try {
            Mail::to($registration->email)->send(new WorkshopInvitation($registration));

            $registration->update([
                'invitation_sent_at' => now(),
                'invitation_attempts' => $registration->invitation_attempts + 1,
                'invitation_last_attempt_at' => now(),
                'invitation_next_retry_at' => null,
                'invitation_last_error' => null,
            ]);

            $registration->logs()->create([
                'event_type' => $wasSent ? 'invitation_resent' : 'invitation_sent',
                'metadata' => ['manual' => $manual],
                'created_at' => now(),
            ]);

            return [
                'sent' => true,
                'attempts' => $registration->invitation_attempts,
                'nextRetryAt' => null,
                'error' => null,
            ];
        } catch (Throwable $e) {
            $attempts = $registration->invitation_attempts + 1;
            $final = $attempts >= self::MAX_ATTEMPTS;
            $nextRetryAt = $final ? null : now()->addMinutes(5 * (2 ** min($attempts, 6)));

            $registration->update([
                'invitation_attempts' => $attempts,
                'invitation_last_attempt_at' => now(),
                'invitation_next_retry_at' => $nextRetryAt,
                'invitation_last_error' => $e->getMessage(),
            ]);

            $registration->logs()->create([
                'event_type' => $final ? 'invitation_failed_final' : 'invitation_failed',
                'metadata' => [
                    'attempt' => $attempts,
                    'next_retry_at' => $nextRetryAt?->toIso8601String(),
                    'error' => $e->getMessage(),
                ],
                'created_at' => now(),
            ]);

            return [
                'sent' => false,
                'attempts' => $attempts,
                'nextRetryAt' => $nextRetryAt?->toIso8601String(),
                'error' => $e->getMessage(),
            ];
        }
    }
}
