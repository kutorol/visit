<?php

namespace App\Http\Controllers\Api\Purchase;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;

class ManageProductController extends BaseController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function delete(int $id): JsonResponse
    {
        $product = $this->productRepository->findByID($id);
        if (!$product) {
            return $this->sendError(__('product.not_found'));
        }

        try {
            if (!$this->productRepository->delete($product)) {
                return $this->sendError(__('product.not_deleted'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error delete product', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        return $this->sendResponse(__('product.deleted'));
    }

    public function create(CreateProductRequest $request): JsonResponse
    {
        try {
            if (!$this->productRepository->create($request->validated())) {
                return $this->sendError(__('product.not_created'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error create product', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        return $this->sendResponse(__('product.created'));
    }

    public function update(UpdateProductRequest $request): JsonResponse
    {
        $data = (array)$request->validated();

        $product = $this->productRepository->findByID((int)$data['id']);
        if (!$product) {
            return $this->sendError(__('product.not_found'));
        }

        try {
            if (!$this->productRepository->update($product, $data)) {
                return $this->sendError(__('product.not_updated'), [], self::BAD_REQUEST_CODE);
            }
        } catch (\Throwable $e) {
            \Log::error('Error update product', ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), [], self::INTERNAL_ERROR_CODE);
        }

        return $this->sendResponse(__('product.updated'));
    }
}
