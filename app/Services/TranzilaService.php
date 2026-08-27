<?php

namespace App\Services;

use App\Models\PaymentOrder;
use App\Models\PaymentWebhookEvent;
use Illuminate\Support\Str;

class TranzilaService
{
    public const TERMINAL = 's1410596';

    public const SUCCESS_RESPONSE = '000';

    public function handleWebhook(array $data): array
    {
        $response = (string) ($data['Response'] ?? '');
        $transactionKey = (string) ($data['TranzilaTK'] ?? '');
        $remarks = (string) ($data['remarks'] ?? '');
        $sum = (float) ($data['sum'] ?? 0);

        if ($transactionKey !== '' && PaymentWebhookEvent::query()->whereKey($transactionKey)->exists()) {
            return ['received' => true, 'duplicate' => true];
        }

        $order = PaymentOrder::query()->where('order_number', $remarks)->first();

        if (! $order) {
            PaymentWebhookEvent::query()->create([
                'event_id' => $transactionKey !== '' ? $transactionKey : Str::uuid(),
                'event_type' => 'tranzila.unknown',
                'environment' => (string) config('app.env'),
                'registration_id' => null,
                'processed_at' => now(),
            ]);

            return ['received' => false, 'reason' => 'order_not_found'];
        }

        if ($response !== self::SUCCESS_RESPONSE) {
            PaymentWebhookEvent::query()->create([
                'event_id' => $transactionKey !== '' ? $transactionKey : Str::uuid(),
                'event_type' => 'tranzila.failed',
                'environment' => (string) config('app.env'),
                'registration_id' => $order->registration_id,
                'processed_at' => now(),
            ]);

            return ['received' => true, 'paid' => false];
        }

        $order->update([
            'paid' => true,
            'status' => 'paid',
            'remaining_amount' => 0,
            'paid_at' => now(),
        ]);

        $registration = $order->registration;

        if ($registration && $registration->payment_status !== 'paid') {
            $registration->update([
                'payment_status' => 'paid',
                'payment_reference' => $transactionKey !== '' ? $transactionKey : $order->order_number,
            ]);

            $registration->logs()->create([
                'event_type' => 'payment_confirmed',
                'metadata' => [
                    'payment_reference' => $transactionKey !== '' ? $transactionKey : $order->order_number,
                    'amount' => $sum,
                ],
                'created_at' => now(),
            ]);

            if (! $registration->invitation_sent_at) {
                app(InvitationService::class)->attempt($registration);
            }
        }

        PaymentWebhookEvent::query()->create([
            'event_id' => $transactionKey !== '' ? $transactionKey : Str::uuid(),
            'event_type' => 'tranzila.completed',
            'environment' => (string) config('app.env'),
            'registration_id' => $registration?->id,
            'processed_at' => now(),
        ]);

        return ['received' => true, 'paid' => true];
    }
}
