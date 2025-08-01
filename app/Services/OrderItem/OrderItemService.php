<?php

namespace App\Services\OrderItem;

use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Models\Order;
use App\Repositories\OrderItemRepository;
use App\DTOs\Order\OrderItemDTO;

use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class OrderItemService implements OrderItemServiceInterface
{
    public function __construct(
        private OrderItemRepositoryInterface $orderItemRepository
    ) {}



    public function store(OrderItemDTO $dto, Order $order): \App\Models\OrderItem
    {
        DB::beginTransaction();

        try {

            //Stok kontrol
                $product = Product::findOrFail($dto->product_id);

                if ($product->stock < $dto->quantity) {
                    DB::rollBack();
                    throw new InsufficientStockException("Yetersiz stok. Kalan: {$product->stock}"
                    );
                }

                $product->stock -= $dto->quantity;
                $product->save();

                //end: stok kontrol
            DB::commit();
                return $this->orderItemRepository->create([
                    'order_id' => $order->id,
                    'product_id' => $dto->product_id,
                    'quantity'   => $dto->quantity,
                    'unit_price' => $dto->unit_price,
                ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

    }
}
