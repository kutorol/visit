<?php

namespace App\Repositories;

use App\Models\UserPurchase;

class PurchaseRepository
{
    public function findByID(int $id): ?UserPurchase
    {
        return UserPurchase::withTrashed()->where('id', $id)->first();
    }

    public function delete(UserPurchase $purchase): bool
    {
        return (bool)$purchase->delete();
    }
}
