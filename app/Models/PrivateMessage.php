<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    protected $fillable = [
        'content',
        'sender_id',
        'receiver_id',
        'room_id'
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
