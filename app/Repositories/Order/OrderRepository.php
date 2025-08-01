<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NotFoundException;


class OrderRepository implements OrderRepositoryInterface
{
    public function all(): Collection
    {
        return Order::with('items')->get();
    }

    public function getByUserId(int $userId): Collection
    {
        return Order::where('user_id', $userId)->get();
    }


    public function find(int $id): ?Order
    {
        return Order::with('items')->find($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(int $id, array $data): Order
    {
        $order = $this->find($id);

        if (!$order) {
            throw new NotFoundException("Order with ID $id not found.");
        }
        $order->update($data);

        return $order->fresh();
    }

    public function delete(int $id): bool
    {
        $order = $this->find($id);

        if (!$order) {
            return false;
        }

        // Transaction ile güvenli silme
        DB::transaction(function () use ($order) {
            $order->items()->delete(); // Önce ilişkili item'ları sil
            $order->delete();
        });

        return true;
    }
}
