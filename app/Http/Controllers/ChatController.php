<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ChatController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth'); // فقط کاربران لاگین شده می‌توانند به این صفحات دسترسی داشته باشند
    }

    public function publicChat()
    {
        // گرفتن پیام‌های چت از دیتابیس
        $messages = Message::latest()->get();

        return view('chat.public', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $message = Message::create([
            'content' => $request->message,
            'user_id' => auth()->id(),
        ]);

        // Load the user relationship for the response
        $message->load('user');

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function getMessages(Request $request)
    {
        $query = Message::with('user')->latest();

        if ($request->has('after')) {
            $query->where('id', '>', $request->after);
        }

        $messages = $query->get();
        return response()->json($messages);
    }
}
