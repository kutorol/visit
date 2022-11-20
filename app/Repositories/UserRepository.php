<?php

namespace App\Repositories;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class UserRepository
{
    private const PER_PAGE = 1;

    public function find(): LengthAwarePaginator
    {
        return User::select(['id', 'name', 'email', 'email_verified_at', 'created_at'])
            ->where('role', '=', 'user')
            ->paginate(self::PER_PAGE);
    }

    public function create(array $data): array
    {
        $data['password'] = bcrypt($data['password']);
        $data['role'] = $data['role'] ?? User::ROLE_USER;
        $user = User::create($data);

        if (!$user->id) {
            throw new InvalidArgumentException(__('user.not_created'), BaseController::BAD_REQUEST_CODE);
        }

        $token = $user->createToken(AuthController::TOKEN_NAME)->accessToken;

        return [
            'ID' => $user->id,
            BaseController::TOKEN_PARAM => $token
        ];
    }

    public function findByID(int $id): ?User
    {
        return User::firstWhere("id", "=", $id);
    }

    public function delete(User $user): bool
    {
        return (bool)$user->delete();
    }
}
