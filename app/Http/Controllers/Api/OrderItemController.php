<?php 

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderItem\OrderItemStoreRequest;
use App\Http\Controllers\Controller;
use App\Services\OrderItem\OrderItemServiceInterface;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use App\Services\OrderItemService;
use App\DTOs\Order\OrderItemDTO;
use Illuminate\Http\Request;
use App\Http\Resources\OrderItemResource;


class OrderItemController extends Controller
{
    public function __construct(
        private OrderItemServiceInterface $orderItemService
    ) {}

    public function store(OrderItemStoreRequest $request, Order $order): JsonResponse
    {
        $dto = new OrderItemDTO($request->validated());
        $item = $this->orderItemService->store($dto, $order);

        $this->authorize('create', [OrderItem::class, $order]);

        return response()->json([
            'message' => 'Sipariş kalemi eklendi. Stok kontrolü yapıldı fakat, Total price değişmesi, statusu e döre ekleme yapılabilmesi veya yapılamamsı durumları geliştirlmeli.',
            'data' =>new OrderItemResource($item)
        ], 201);
    }

    public function destroy(Order $order, OrderItem $item): JsonResponse
    {
        if ($item->order_id !== $order->id) {
            return response()->json(['message' => 'Sipariş kalemi bu siparişe ait değil.'], 403);
        }

        $this->authorize('delete', $item);
        $item->delete();

        return response()->json(['message' => 'Sipariş kalemi başarıyla silindi.']);
    }
}
