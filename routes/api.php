<?php

use App\Http\Controllers\Api\TicketApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());

    Route::get('/tickets/stats', [TicketApiController::class, 'stats']);
    Route::apiResource('tickets', TicketApiController::class)->only([
        'index', 'show', 'store', 'update',
    ]);
});
