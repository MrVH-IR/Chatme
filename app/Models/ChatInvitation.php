<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatInvitation extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'room_id',
        'status'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'user_id');
    }
}