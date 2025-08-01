<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Services\Order\OrderServiceInterface;
use Illuminate\Http\JsonResponse;
use App\DTOs\Order\OrderStoreDTO;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Helpers\Helper;


class OrderController extends Controller
{
    public function __construct(protected OrderServiceInterface $orderService) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Order::class);

        if (auth()->user()->role === Helper::USER_ROLE_ADMIN) {
            $orders = $this->orderService->getAll();
        } else {
            $orders = $this->orderService->getByUserId(auth()->id());
        }

        return response()->json(
            Helper::gelfOutput(OrderResource::collection($orders), true, Helper::READ_SUCCESS_TEXT, Helper::R000)
        );

    }

    public function store(OrderStoreRequest $request): JsonResponse
    {    

        try {
            $dto = new OrderStoreDTO($request->validated());

            $order = $this->orderService->create($dto);

            return response()->json(
                Helper::gelfOutput(new OrderResource($order), true, Helper::CREATE_SUCCESS_TEXT, Helper::C000),
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::CREATE_FAILED_TEXT, Helper::C001)
            );
        }


    }

    public function show(int $id): JsonResponse
    {
        $order = $this->orderService->findById($id);
        if (!$order) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::READ_FAILED_TEXT, Helper::R001)
            );
        }

        $this->authorize('view', $order);

        return response()->json(   
            Helper::gelfOutput(new OrderResource($order), true, Helper::READ_SUCCESS_TEXT, Helper::R000)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {

        // TODO: Sipariş durumu update

        $validated = $request->validate([
            'status' => 'required|string|in:pending,approved,shipped,cancelled',
        ]);

        $order = $this->orderService->update($id, $validated);

        $this->authorize('update', $order);

        if (!$order) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::UPDATE_FAILED_TEXT, Helper::U002)
            );
        }

        return response()->json(
            Helper::gelfOutput(new OrderResource($updated), true, Helper::UPDATE_SUCCESS_TEXT, Helper::U000)
        );
    } 

    public function destroy(int $id): JsonResponse
    {
        // TODO: Sipariş silindiğinde stok kontrol edilmeli

        $order = $this->orderService->findById($id);

        if (!$order) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::DELETE_FAILED_TEXT, Helper::D002)
            );
        }

        $this->authorize('delete', $order);

        $deleted = $this->orderService->delete($id);

        return response()->json(
            Helper::gelfOutput(null, true, Helper::DELETE_SUCCESS_TEXT, Helper::D000)
        );    
    }
}
