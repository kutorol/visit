<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\List;

use App\DTO\SearchUserDTO;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\SearchUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class ListController extends BaseController
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получаем список всех юзеров (без админов).
     * @param SearchUserRequest $request
     * @return JsonResponse
     */
    public function find(SearchUserRequest $request): JsonResponse
    {
        $dto = NULL;

        $validated = $request->validated();
        if (!empty($validated)) {
            $dto = (new SearchUserDTO())
                ->setIds($validated['ids'] ?? NULL)
                ->setName($validated['name'] ?? NULL)
                ->setEmail($validated['email'] ?? NULL)
                ->setRoles($validated['roles'] ?? NULL);
        }

        $users = $this->repository->find((bool)($validated['withDeleted'] ?? FALSE), $dto);

        return $this->sendResponse('', [
            'total' => $users->total(),
            'currentPage' => $users->currentPage(),
            'lastPage' => $users->lastPage(),
            'path' => $users->path(),
            'users' => $users->items(),
        ]);
    }

    public function search(SearchUserRequest $request): JsonResponse
    {
        return $this->find($request);
    }
}
