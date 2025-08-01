<?php

namespace App\DTOs\Order;

class OrderStoreDTO
{
    public int $user_id;
    public string $status;
    public array $order_items;

    public function __construct(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->status = $data['status'];
        $this->order_items = $data['order_items'];
    }
}
