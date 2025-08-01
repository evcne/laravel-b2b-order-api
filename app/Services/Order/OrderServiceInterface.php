<?php

namespace App\Services\Order;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Order;
use App\DTOs\Order\OrderStoreDTO;


interface OrderServiceInterface
{
    public function getAll(): Collection;
    public function getByUserId(int $userId): Collection;
    public function findById(int $id): ?Order;
    public function create(OrderStoreDTO $dto): Order;
    public function update(int $id, array $data): Order;
    public function delete(int $id): bool;
}
