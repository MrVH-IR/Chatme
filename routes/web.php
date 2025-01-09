<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PrivateChatController;


Route::get('/register', function () {
    return view('auth.register');
});
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/chat/public', [ChatController::class, 'publicChat'])->name('chat.public');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

    Route::get('/chat/private', [PrivateChatController::class, 'privateChat'])->name('chat.private');
    Route::post('/chat/private/invite', [PrivateChatController::class, 'sendInvite']);
    Route::post('/chat/private/handle-invite', [PrivateChatController::class, 'handleInvite']);
    Route::post('/chat/private/send', [PrivateChatController::class, 'sendMessage']);
    Route::get('/chat/private/messages/{room}', [PrivateChatController::class, 'getMessages']);

    // Add route for status function
    Route::get('/chat/status', [ChatController::class, 'status'])->name('chat.status');
    Route::get('/chat/private/status', [PrivateChatController::class, 'status'])->name('chat.private.status');
});
