<?php

namespace App\Http\Controllers\Api\Purchase;

use App\Http\Controllers\Api\BaseController;
use App\Repositories\PurchaseRepository;
use Illuminate\Http\JsonResponse;

class ManagePurchaseController extends BaseController
{
    private PurchaseRepository $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function delete(int $id): JsonResponse
    {
        $purchase = $this->purchaseRepository->findByID($id);
        if (!$purchase) {
            return $this->sendError(__('purchase.not_found'));
        }

        try {
            if (!$this->purchaseRepository->delete($purchase)) {
                return $this->sendError(__('purchase.not_deleted'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error delete purchase', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        return $this->sendResponse(__('purchase.deleted'));
    }
}
