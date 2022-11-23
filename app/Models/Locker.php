<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    protected $casts = [
        'released_at' => 'datetime',
    ];

    protected $fillable = [
        'number',
        'is_active',
        'is_woman',
        'released_at',
    ];

    public function scopeSelectFields(Builder $query): Builder
    {
        return $query->select(['id', 'number', 'is_active', 'is_woman', 'released_at', 'created_at', 'updated_at']);
    }
}
