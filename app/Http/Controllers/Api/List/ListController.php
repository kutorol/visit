<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Api\BaseController;
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
     * Получаем список всех юзеров (без админов)
     * @return JsonResponse
     */
    public function find(): JsonResponse
    {
        $users = $this->repository->find();

        return $this->sendResponse("", [
            'total' => $users->total(),
            'currentPage' => $users->currentPage(),
            'lastPage' => $users->lastPage(),
            'path' => $users->path(),
            'users' => $users->items(),
        ]);
    }
}
