<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;

    protected $table = "user_accesses";

    protected $casts = [
        'ended_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'type',
        'ended_at'
    ];
}
