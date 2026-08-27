<?php

namespace App\Http\Controllers;

use App\Models\PaymentOrder;
use App\Models\Registration;
use App\Services\WorkshopService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function __construct(private readonly WorkshopService $workshop)
    {
    }

    public function seatsOverview(): JsonResponse
    {
        return response()->json(['rows' => $this->workshop->seatsOverview()]);
    }

    public function seatsLeft(Request $request): JsonResponse
    {
        $data = $request->validate([
            'workshop_date' => ['required', 'string'],
        ]);

        return response()->json(['seatsLeft' => $this->workshop->seatsLeft($data['workshop_date'])]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:60'],
            'last_name' => ['required', 'string', 'min:2', 'max:60'],
            'phone' => ['required', 'string', 'min:9', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'workshop_date' => ['required', 'string', 'in:'.implode(',', $this->workshop->dates())],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        if ($this->workshop->seatsLeft($data['workshop_date']) <= 0) {
            return response()->json(['message' => 'لا توجد أماكن متاحة لهذا التاريخ'], 422);
        }

        $registration = Registration::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'workshop_date' => $data['workshop_date'],
            'terms_accepted' => true,
            'terms_accepted_at' => now(),
            'payment_status' => 'pending',
            'deposit_amount' => $this->workshop->deposit(),
        ]);

        $order = PaymentOrder::create([
            'token' => Str::random(48),
            'order_number' => $this->generateOrderNumber(),
            'registration_id' => $registration->id,
            'total_cost' => $this->workshop->deposit(),
            'remaining_amount' => $this->workshop->deposit(),
            'paid' => false,
            'status' => 'pending',
            'meta' => [
                'items' => [
                    ['product_name' => 'عربون ورشة المكياج — '.$data['workshop_date']],
                ],
                'user' => [
                    'name' => trim($data['first_name'].' '.$data['last_name']),
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ],
                'address' => [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'address' => '',
                    'city' => '',
                ],
            ],
        ]);

        return response()->json([
            'registration_id' => $registration->id,
            'payment_token' => $order->token,
        ], 201);
    }

    public function status(Request $request): JsonResponse
    {
        $data = $request->validate([
            'registration_id' => ['required', 'uuid'],
            'email' => ['required', 'string', 'email'],
        ]);

        $registration = Registration::query()
            ->where('id', $data['registration_id'])
            ->whereRaw('lower(email) = ?', [strtolower(trim($data['email']))])
            ->first();

        if (! $registration) {
            return response()->json(['row' => null]);
        }

        return response()->json(['row' => $this->workshop->status($registration)]);
    }

    public function cancel(Request $request): JsonResponse
    {
        $data = $request->validate([
            'registration_id' => ['required', 'uuid'],
            'email' => ['required', 'string', 'email'],
        ]);

        $registration = Registration::query()
            ->where('id', $data['registration_id'])
            ->whereRaw('lower(email) = ?', [strtolower(trim($data['email']))])
            ->first();

        if (! $registration) {
            return response()->json(['row' => null]);
        }

        return response()->json(['row' => $this->workshop->cancel($registration)]);
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'WS-'.date('Ymd').'-'.strtoupper(Str::random(6));
        } while (PaymentOrder::where('order_number', $number)->exists());

        return $number;
    }
}
