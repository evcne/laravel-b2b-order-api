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
use App\Helpers\Helper;


class OrderItemController extends Controller
{
    public function __construct(
        private OrderItemServiceInterface $orderItemService
    ) {}

    public function store(OrderItemStoreRequest $request, Order $order): JsonResponse
    {
        try{
            $dto = new OrderItemDTO($request->validated());
            $item = $this->orderItemService->store($dto, $order);

            $this->authorize('create', [OrderItem::class, $order]);

            //TODO: Stok kontrolü yapıldı fakat, Total price değişmesi, statusu e döre ekleme yapılabilmesi veya yapılamamsı durumları geliştirlmeli 
            return response()->json(
                Helper::gelfOutput(new OrderItemResource($item), true, Helper::CREATE_SUCCESS_TEXT, Helper::C000)
            );

        } catch (\Exception $e) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::CREATE_FAILED_TEXT, Helper::C001)
            );
        }
    }

    public function destroy(Order $order, OrderItem $item): JsonResponse
    {
        if ($item->order_id !== $order->id) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::DELETE_FAILED_TEXT, Helper::D002)
            );
        }

        $this->authorize('delete', $item);
        $item->delete();

        return response()->json(
            Helper::gelfOutput(null, true, Helper::DELETE_SUCCESS_TEXT, Helper::D000)
        );    
    
    }
}
