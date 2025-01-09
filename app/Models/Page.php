<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages_status';

    protected $fillable = [
        'page_id',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
