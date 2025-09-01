<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/auth')->group(function () {
    Route::post("/login", [AuthController::class, 'login']);
    Route::post("/password-reset", [PasswordResetLinkController::class, 'store']);

    Route::middleware("auth:sanctum")->group(function () {
        Route::post("/logout", [AuthController::class, 'logout']);
    });
});
