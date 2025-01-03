<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PrivateMessage;
use App\Models\ChatInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PrivateChatController extends Controller
{
    public function privateChat()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('chat.private', compact('users'));
    }

    public function sendInvite(Request $request)
    {
        $invitation = ChatInvitation::create([
            'sender_id' => auth()->user()->user_id,
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
            'sender_id' => auth()->user()->user_id,
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
            'sender_id' => auth()->user()->user_id,
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
