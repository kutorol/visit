<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function find(): Collection
    {
        return Product::select(['id', 'name', 'type', 'days', 'created_at', 'updated_at'])->get();
    }

    public function findByID(int $id): ?Product
    {
        return Product::where('id', $id)->first();
    }

    public function delete(Product $product): bool
    {
        return (bool)$product->delete();
    }

    public function update(Product $product, array $data): bool
    {
        $product->name = $data['name'] ?? $product->name;
        $product->days = (int)($data['days'] ?? $product->days);

        if (Product::checkType($data['type'] ?? '')) {
            $product->type = $data['type'];
        }

        return (bool)$product->save();
    }

    public function create(array $data): Product
    {
        return Product::create([
            'name' => $data['name'],
            'days' => (int)$data['days'],
            'type' => $data['type'],
        ]);
    }
}
