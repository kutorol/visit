<?php

namespace App\Http\Controllers\Api\Locker;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Locker\CreateLockerRequest;
use App\Http\Requests\Locker\UpdateLockerRequest;
use App\Repositories\LockerRepository;
use Illuminate\Http\JsonResponse;

class ManageLockerController extends BaseController
{
    private LockerRepository $lockerRepository;

    public function __construct(LockerRepository $productRepository)
    {
        $this->lockerRepository = $productRepository;
    }

    public function delete(int $id): JsonResponse
    {
        $product = $this->lockerRepository->findByID($id);
        if (!$product) {
            return $this->sendError(__('locker.not_found'));
        }

        try {
            if (!$this->lockerRepository->delete($product)) {
                return $this->sendError(__('locker.not_deleted'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error delete locker', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        return $this->sendResponse(__('locker.deleted'));
    }

    public function create(CreateLockerRequest $request): JsonResponse
    {
        try {
            if (!$this->lockerRepository->create($request->validated())) {
                return $this->sendError(__('locker.not_created'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error create locker', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        return $this->sendResponse(__('locker.created'));
    }

    public function update(UpdateLockerRequest $request): JsonResponse
    {
        $data = (array)$request->validated();

        $product = $this->lockerRepository->findByID((int)$data['id']);
        if (!$product) {
            return $this->sendError(__('locker.not_found'));
        }

        try {
            if (!$this->lockerRepository->update($product, $data)) {
                return $this->sendError(__('locker.not_updated'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error update locker', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        return $this->sendResponse(__('locker.updated'));
    }
}
