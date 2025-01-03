<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/api/auth/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/invite/send', [PrivateChatController::class, 'apiSendInvite']);
    Route::post('/invite/accept', [PrivateChatController::class, 'apiHandleInvite']);
    Route::get('/invite/pending', [PrivateChatController::class, 'getPendingInvites']);
});
