<?php

namespace App\DTOs\Order;

class OrderItemDTO
{
    public int $product_id;
    public int $quantity;
    public float $unit_price;

    public function __construct(array $data)
    {
        $this->product_id = $data['product_id'];
        $this->quantity = $data['quantity'];
        $this->unit_price = $data['unit_price'];
    }

    public static function fromArray(array $items): array
    {
        return array_map(fn($item) => new self($item), $items);
    }
}
