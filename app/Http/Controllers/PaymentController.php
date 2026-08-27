<?php

namespace App\Http\Controllers;

use App\Models\PaymentOrder;
use App\Services\TranzilaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(string $token): JsonResponse
    {
        $order = PaymentOrder::where('token', $token)->first();

        if (! $order) {
            return response()->json(['error' => 'الرابط غير صالح أو منتهي الصلاحية']);
        }

        if ($order->paid) {
            return response()->json([
                'paid' => true,
                'order_number' => $order->order_number,
            ]);
        }

        $meta = $order->meta ?? [];

        return response()->json([
            'paid' => false,
            'error' => null,
            'order_number' => $order->order_number,
            'total_cost' => $order->total_cost,
            'remaining_amount' => $order->remaining_amount,
            'order_items' => $meta['items'] ?? [],
            'address' => $meta['address'] ?? [],
            'user' => $meta['user'] ?? [],
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        $result = app(TranzilaService::class)->handleWebhook($request->all());

        return response()->json($result);
    }
}
