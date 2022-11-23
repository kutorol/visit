<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocker extends Model
{
    use HasFactory;

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    protected $fillable = [
        'locker_id',
        'user_id',
        'expired_at'
    ];
}
