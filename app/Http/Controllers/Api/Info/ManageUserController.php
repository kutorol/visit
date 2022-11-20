<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\RegisterRequest;
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
}
