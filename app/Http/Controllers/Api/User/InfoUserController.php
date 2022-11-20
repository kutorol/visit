<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class InfoUserController extends BaseController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Only user info
     * @param int $id
     * @return JsonResponse
     */
    public function info(int $id): JsonResponse
    {
        $user = $this->userRepository->findByID($id);
        if (!$user) {
            return $this->sendError(__('user.not_found'));
        }

        return $this->sendResponse("", [
            'uid' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'emailConfirmedAt' => $user->email_verified_at,
            'role' => $user->role,
            'createdAt' => $user->created_at,
            'updatedAt' => $user->updated_at,
            'deletedAt' => $user->deleted_at,
        ]);
    }
}
