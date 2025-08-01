<?php

namespace App\Services\OrderItem;
use App\Models\Order;
use App\DTOs\Order\OrderItemDTO;

interface OrderItemServiceInterface
{
    public function store(OrderItemDTO $dto, Order $order): \App\Models\OrderItem;
}
