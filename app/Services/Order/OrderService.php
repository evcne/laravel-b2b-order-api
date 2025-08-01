<?php

namespace App\Services\Order;

use App\Services\Order\OrderServiceInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\DTOs\Order\OrderStoreDTO;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;

use App\Exceptions\InsufficientStockException;
use App\Models\Product;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected OrderItemRepositoryInterface $orderItemRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->orderRepository->all();
    }

    public function getByUserId(int $userId): Collection
    {
        return $this->orderRepository->getByUserId($userId);
    }

    public function findById(int $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    public function update(int $id, array $data): Order
    {
        return $this->orderRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->orderRepository->delete($id);
    }

    public function create(OrderStoreDTO $dto): Order
    {
        $orderItems = $dto->order_items ?? [];
        $data['total_price'] = $this->calculateTotalPrice($orderItems);

        // if ile kontrol ettir 


        DB::beginTransaction();

        try {
            
            $order = $this->orderRepository->create([
                'user_id' => $dto->user_id,
                'status' => $dto->status,
                'total_price' => $data['total_price'],
            ]);

            foreach ($dto->order_items as $item) {

                //Stok kontrol
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
                    throw new InsufficientStockException("Yetersiz stok. Kalan: {$product->stock}"
                    );
                }

                $product->stock -= $item['quantity'];
                $product->save();

                //end: stok kontrol

                $this->orderItemRepository->create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }

            DB::commit();
            return $order;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function calculateTotalPrice(array $orderItems): float
    {
        $total = 0;
        foreach ($orderItems as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }
        return $total;
    }

}
