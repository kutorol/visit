<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    private const PER_PAGE = 1;

    public function find(): LengthAwarePaginator
    {
        return User::select(['id', 'name', 'email', 'email_verified_at', 'created_at'])
            ->where('role', '=', 'user')
            ->paginate(self::PER_PAGE);
    }
}
