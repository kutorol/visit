<?php

namespace App\Repositories;

use App\Models\UserPurchase;

class PurchaseRepository
{
    public function findByID(int $id): ?UserPurchase
    {
        return UserPurchase::withTrashed()
            ->select([
                'user_purchases.id', 'user_purchases.user_id', 'user_purchases.product_id', 'user_purchases.created_at',
                'user_purchases.deleted_at', 'products.name', 'products.type', 'products.days',
                \DB::raw('products.created_at AS product_created_at'),
                \DB::raw('products.updated_at AS product_updated_at'),
            ])
            ->where('user_purchases.id', $id)
            ->join('products', 'user_purchases.product_id', '=', 'products.id')
            ->first();
    }

    public function delete(UserPurchase $purchase): bool
    {
        return (bool)$purchase->delete();
    }

    public function create(array $data): UserPurchase
    {
        return UserPurchase::create([
            'user_id' => $data['user_id'],
            'product_id' => (int)$data['product_id']
        ]);
    }
}
