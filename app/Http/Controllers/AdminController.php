<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\InvitationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function access(Request $request): JsonResponse
    {
        return response()->json([
            'isAdmin' => $request->user()->isAdmin(),
            'email' => $request->user()->email,
        ]);
    }

    public function claim(Request $request): JsonResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $expected = config('workshop.admin_access_code');

        if (! $expected || trim($data['code']) !== $expected) {
            return response()->json(['message' => 'رمز المالك غير صحيح'], 403);
        }

        $request->user()->update(['role' => 'admin']);

        return response()->json(['isAdmin' => true]);
    }

    public function registrations(): JsonResponse
    {
        $rows = Registration::with('logs')
            ->orderByDesc('created_at')
            ->get()
            ->toArray();

        return response()->json(['rows' => $rows]);
    }

    public function resendInvitation(Request $request, string $id): JsonResponse
    {
        $registration = Registration::findOrFail($id);

        $result = app(InvitationService::class)->attempt($registration, true);

        $registration->refresh();

        return response()->json([
            'sent' => $result['sent'],
            'email' => $registration->email,
            'attempts' => $result['attempts'],
            'nextRetryAt' => $result['nextRetryAt'],
            'error' => $result['error'],
            'state' => [
                'invitation_sent_at' => $registration->invitation_sent_at?->toIso8601String(),
                'invitation_attempts' => $registration->invitation_attempts,
                'invitation_last_attempt_at' => $registration->invitation_last_attempt_at?->toIso8601String(),
                'invitation_next_retry_at' => $registration->invitation_next_retry_at?->toIso8601String(),
                'invitation_last_error' => $registration->invitation_last_error,
            ],
        ]);
    }
}
