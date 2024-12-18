<?php

use App\Http\Controllers\Api\V1\PersonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('/v1')->group(function () {
    Route::prefix('/persons')->group(function () {
        Route::get('/', [PersonController::class, 'index']);
        Route::post('/', [PersonController::class, 'store']);
        Route::get('/{id}', [PersonController::class, 'show']);
        Route::put('/{id}', [PersonController::class, 'update']);
        Route::delete('/{id}', [PersonController::class, 'destroy']);
    });
});