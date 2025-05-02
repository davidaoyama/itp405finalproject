<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShowApiController;

Route::middleware('api')->group(function () {
    Route::get('/shows', [ShowApiController::class, 'index']);
    Route::get('/shows/{show}', [ShowApiController::class, 'show']);
    Route::post('/shows', [ShowApiController::class, 'store']);
    Route::put('/shows/{show}', [ShowApiController::class, 'update']);
    Route::delete('/shows/{show}', [ShowApiController::class, 'destroy']);
});
