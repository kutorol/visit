<?php

namespace App\Http\Controllers\Api\Locker;

use App\Http\Controllers\Api\BaseController;
use App\Repositories\LockerRepository;
use Illuminate\Http\JsonResponse;

class ListLockerController extends BaseController
{
    private LockerRepository $lockerRepository;

    public function __construct(LockerRepository $productRepository)
    {
        $this->lockerRepository = $productRepository;
    }

    public function index(): JsonResponse
    {
        $lockers = $this->lockerRepository->find();
        return $this->sendResponse('', ['lockers' => $lockers]);
    }
}
