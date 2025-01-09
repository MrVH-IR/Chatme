<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function status()
    {
        $user = Auth::user();
        $pageId = 2; // Specific page ID for page number 2

        // Check if the user already has a status entry for any page
        $status = DB::table('pages_status')
            ->where('user_id', $user->id)
            ->first();

        if ($status) {
            // Update the status entry if it exists with a different page ID
            DB::table('pages_status')
                ->where('user_id', $user->id)
                ->update([
                    'page_id' => $pageId,
                    'status' => 'active',
                    'updated_at' => now(),
                ]);
        } else {
            // Insert a new status entry if not exists
            DB::table('pages_status')->insert([
                'user_id' => $user->id,
                'page_id' => $pageId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Return some response or view
        return response()->json(['status' => 'active']);
    }

    public function publicChat()
    {
        $messages = Message::latest()->get();

        // Fetch users who are active on the public chat page
        $activeUserIds = DB::table('pages_status')
            ->where('page_id', 2)
            ->where('status', 'active')
            ->pluck('user_id');

        $users = User::whereIn('id', $activeUserIds)->get();

        return view('chat.public', compact('messages', 'users'));
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
