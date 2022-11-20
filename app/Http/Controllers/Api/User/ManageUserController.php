<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class ManageUserController extends BaseController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            return $this->sendResponse(__('user.created'), [
                'userID' => $this->userRepository->create($data)['ID'],
            ]);
        } catch (\Throwable $e) {
            \Log::error('Error manual register', array_merge(['error' => $e->getMessage()], $data));

            return $this->sendError($e->getMessage(), [], $e->getCode() ?: self::INTERNAL_ERROR_CODE);
        }
    }

    public function delete(DeleteUserRequest $request): JsonResponse
    {
        $id = (int)$request->get('id');
        $user = $this->userRepository->findByID($id);
        if (!$user) {
            return $this->sendError(__('user.not_found'));
        }

        // current user is not admin and user for delete is not user
        if ($user->role != User::ROLE_USER && !User::isAdmin()) {
            return $this->sendError(__('general.bad_role'), [], self::FORBIDDEN_CODE);
        }

        try {
            if (!$this->userRepository->delete($user)) {
                return $this->sendError(__('user.not_deleted'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error delete user', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        AuthController::removeOldTokens($user->id);

        return $this->sendResponse(__('user.deleted'));
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $data = (array)$request->validated();

        $user = $this->userRepository->findByID((int)$data['id']);
        if (!$user) {
            return $this->sendError(__('user.not_found'));
        }

        // current user is not admin and user for update is not user
        if ($user->role != User::ROLE_USER && !User::isAdmin()) {
            return $this->sendError(__('general.bad_role'), [], self::FORBIDDEN_CODE);
        }

        $changedEmail = isset($data['email']) && mb_strtolower($data['email']) !== mb_strtolower($user->email);

        try {
            if (!$this->userRepository->update($user, $data)) {
                return $this->sendError(__('user.not_updated'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error update user', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        if ($changedEmail) {
            return $this->sendResponse(__('user.updated_with_email'));
        }

        return $this->sendResponse(__('user.updated'));
    }
}
