<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class ManageUserController extends BaseController
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            return $this->sendResponse(__("user.created"), [
                'userID' => $this->repository->create($data)['ID']
            ]);
        } catch (\Throwable $e) {
            \Log::error("Error manual register", array_merge(['error' => $e->getMessage()], $data));
            return $this->sendError($e->getMessage(), [], $e->getCode() ?: self::INTERNAL_ERROR_CODE);
        }
    }

    public function delete(DeleteUserRequest $request): JsonResponse
    {
        $id = (int)$request->get("id");
        $user = $this->repository->findByID($id);
        if (!$user) {
            return $this->sendError(__("user.not_found"));
        }

        // current user is not admin and user for delete is not user
        if ($user->role != User::ROLE_USER && !User::isAdmin()) {
            return $this->sendError(__("general.bad_role"), [], self::FORBIDDEN_CODE);
        }

        try {
            if (!$this->repository->delete($user)) {
                return $this->sendError(__("user.not_deleted"), [], self::BAD_REQUEST_CODE);
            }

            AuthController::removeOldTokens($user->id);

            return $this->sendResponse(__("user.deleted"));
        } catch (\Throwable $e) {
            \Log::error("Error delete user", ['error' => $e->getMessage()]);
            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }
    }
}
