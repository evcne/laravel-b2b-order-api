<?php

namespace App\Repositories\OrderItem;

use App\Models\OrderItem;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function create(array $data): OrderItem
    {
        return OrderItem::create($data);
    }
}
