<?php

namespace App\Repositories;

use App\Models\Locker;
use Illuminate\Support\Collection;

class LockerRepository
{
    public function find(): Collection
    {
        return Locker::selectFields()->get();
    }

    public function findByID(int $id): ?Locker
    {
        return Locker::selectFields()->where('id', $id)->first();
    }

    public function delete(Locker $locker): bool
    {
        return (bool)$locker->delete();
    }

    public function update(Locker $locker, array $data): bool
    {
        $locker->number = (int)($data['number'] ?? $locker->number);
        $locker->is_active = (bool)($data['is_active'] ?? $locker->is_active);
        $locker->is_woman = (bool)($data['is_woman'] ?? $locker->is_woman);
        $locker->released_at = $data['released_at'] ?? $locker->released_at;

        return (bool)$locker->save();
    }

    public function create(array $data): Locker
    {
        return Locker::create([
            'number' => (int)$data['number'],
            'is_active' => (bool)$data['is_active'],
            'is_woman' => (bool)$data['is_woman']
        ]);
    }
}
