<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'last_activity'
    ];

    protected $casts = [
        'last_activity' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 