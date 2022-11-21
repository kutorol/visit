<?php

namespace App\Http\Controllers\Api\Purchase;

use App\Http\Controllers\Api\BaseController;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;

class ListProductController extends BaseController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(): JsonResponse
    {
        $products = $this->productRepository->find();
        return $this->sendResponse('', ['products' => $products]);
    }
}
