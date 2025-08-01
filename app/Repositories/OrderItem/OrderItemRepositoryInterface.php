<?php

namespace App\Repositories\OrderItem;

use App\Models\OrderItem;

interface OrderItemRepositoryInterface
{
    public function create(array $data): OrderItem;
}
