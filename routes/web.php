<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $index = public_path('index.html');

    if (file_exists($index)) {
        return response()->file($index);
    }

    return view('welcome');
});

Route::fallback(function (Request $request) {
    if ($request->is('api/*')) {
        return response()->json(['message' => 'Not Found'], 404);
    }

    $index = public_path('index.html');

    if ($request->isMethod('GET') && file_exists($index)) {
        return response()->file($index);
    }

    abort(404);
});
