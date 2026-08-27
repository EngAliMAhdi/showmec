<?php

use Illuminate\Support\Facades\Route;

Route::any('/', function () {
    $index = public_path('index.html');

    return file_exists($index)
        ? response()->file($index)
        : view('welcome');
});

// Serve the SPA for any non-API path and any HTTP method.
// Tranzila redirects back with a POST to /payment-success and /payment-fail.
Route::any('/{any}', function () {
    $index = public_path('index.html');

    if (file_exists($index)) {
        return response()->file($index);
    }

    abort(404);
})->where('any', '^(?!api/).*');

Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
