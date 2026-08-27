<?php

namespace App\Http\Controllers;

use App\Models\Waitlist;
use App\Services\WorkshopService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WaitlistController extends Controller
{
    public function __construct(private readonly WorkshopService $workshop)
    {
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:60'],
            'last_name' => ['required', 'string', 'min:2', 'max:60'],
            'phone' => ['required', 'string', 'min:9', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'workshop_date' => ['required', 'string', 'in:'.implode(',', $this->workshop->dates())],
        ]);

        try {
            $entry = Waitlist::create($data);
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'UNIQUE constraint failed') || ($e->errorInfo[1] ?? null) === 19) {
                return response()->json(['message' => 'already_waitlisted'], 409);
            }

            throw $e;
        }

        return response()->json(['row' => $entry->toArray()], 201);
    }
}
