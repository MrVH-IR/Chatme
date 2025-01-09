<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PrivateMessage;
use App\Models\ChatInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PrivateChatController extends Controller
{
    public function status()
    {
        $user = Auth::user();
        $pageId = 3; // Specific page ID for private chat

        // Check if the user already has a status entry for any page
        $status = DB::table('pages_status')
            ->where('user_id', $user->id)
            ->first();

        if ($status) {
            // Update the status entry if it exists with a different page ID
            if ($status->page_id != $pageId) {
                DB::table('pages_status')
                    ->where('user_id', $user->id)
                    ->update([
                        'page_id' => $pageId,
                        'status' => 'active',
                        'updated_at' => now(),
                    ]);
            } else {
                // Update the status to active if the page ID is the same
                DB::table('pages_status')
                    ->where('user_id', $user->id)
                    ->update([
                        'status' => 'active',
                        'updated_at' => now(),
                    ]);
            }
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

    public function privateChat()
    {
        $pageId = 3; // Specific page ID for private chat

        // Fetch users who are active on the private chat page
        $activeUserIds = DB::table('pages_status')
            ->where('page_id', $pageId)
            ->where('status', 'active')
            ->pluck('user_id');

        $users = User::whereIn('id', $activeUserIds)->get();

        return view('chat.private', compact('users'));
    }

    public function sendInvite(Request $request)
    {
        $invitation = ChatInvitation::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $request->receiver_id,
            'room_id' => Str::random(16),
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'invitation' => $invitation
        ]);
    }

    public function handleInvite(Request $request)
    {
        $invitation = ChatInvitation::findOrFail($request->invitation_id);
        $invitation->status = $request->accept ? 'accepted' : 'rejected';
        $invitation->save();

        return response()->json([
            'success' => true,
            'room_id' => $invitation->room_id
        ]);
    }

    public function sendMessage(Request $request)
    {
        $message = PrivateMessage::create([
            'content' => $request->message,
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $request->receiver_id,
            'room_id' => $request->room_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function getMessages(Request $request)
    {
        $messages = PrivateMessage::where('room_id', $request->room_id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function apiSendInvite(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string'
        ]);

        $receiver = User::where('user_id', $request->identifier)
            ->orWhere('key', $request->identifier)
            ->first();

        if (!$receiver) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $invitation = ChatInvitation::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $receiver->user_id,
            'room_id' => Str::random(16),
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'invitation' => $invitation->load('receiver')
        ]);
    }
}
