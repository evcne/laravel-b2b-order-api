<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function all(): Collection;
    public function getByUserId(int $userId): Collection;
    public function find(int $id): ?Order;
    public function create(array $data): Order;
    public function update(int $id, array $data): Order;
    public function delete(int $id): bool;
}
