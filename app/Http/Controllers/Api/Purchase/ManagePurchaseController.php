<?php

namespace App\Http\Controllers\Api\Purchase;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Product\CreatePurchaseRequest;
use App\Repositories\ProductRepository;
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

    public function create(CreatePurchaseRequest $request): JsonResponse
    {
        $data = $request->validated();
        $product = app(ProductRepository::class)->findByID((int)$data['product_id']);
        if (!$product) {
            return $this->sendError(__('product.not_found'));
        }

        try {
            if (!$this->purchaseRepository->create($data)) {
                return $this->sendError(__('purchase.not_created'), [], self::BAD_REQUEST_CODE);
            }

            // todo check product type and add user purchased days
        } catch (\Throwable $e) {
            \Log::error('Error create purchase', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        return $this->sendResponse(__('purchase.created'));
    }
}
