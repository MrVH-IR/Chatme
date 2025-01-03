<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;


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


Route::middleware('auth')->group(function () {
    // صفحه چت عمومی
    Route::get('/chat/public', [ChatController::class, 'publicChat'])->name('chat.public');

    // ارسال پیام در چت
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
});
