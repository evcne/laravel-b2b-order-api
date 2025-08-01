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



class OrderController extends Controller
{
    public function __construct(protected OrderServiceInterface $orderService) {}

    public function index(): JsonResponse
    {
        //$orders = $this->orderService->getAll();
        //return response()->json(['data' => $orders]);

        $this->authorize('viewAny', Order::class);

        if (auth()->user()->role === 'admin') {
            $orders = $this->orderService->getAll();
        } else {
            $orders = $this->orderService->getByUserId(auth()->id());
        }

        return response()->json(['message' => 'Siparişler başarıyla getirildi.',
        'data' => OrderResource::collection($orders)]);

    }

    public function store(OrderStoreRequest $request): JsonResponse
    {    

        $dto = new OrderStoreDTO($request->validated());

        $order = $this->orderService->create($dto);

        return response()->json([
            'message' => 'Sipariş oluşturuldu. Stok kontrolü yapıldı. Müşteri yeni sipariş oluşturmalı denildiği için sadece ibaresi olmadığı için herkes yapabiliyor.',
            'data' => new OrderResource($order),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->orderService->findById($id);
        if (!$order) {
            return response()->json(['message' => 'Sipariş bulunamadı.'], 404);
        }

        $this->authorize('view', $order);

        return response()->json(['message' => 'Sipariş başarıyla getirildi.',
        'data' => new OrderResource($order)]);
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
            return response()->json(['message' => 'Sipariş bulunamadı.'], 404);
        }
        return response()->json(['message' => 'Sipariş başarı ile güncellendi.',
         'data' => new OrderResource($order)
        ]);
    } 

    public function destroy(int $id): JsonResponse
    {
        // TODO: Sipariş silindiğinde stok kontrol edilmeli

        $order = $this->orderService->findById($id);

        if (!$order) {
            return response()->json(['message' => 'Silmek istediğiniz sipariş bulunamadı'], 404);
        }

        $this->authorize('delete', $order);

        $deleted = $this->orderService->delete($id);

        return response()->json(['message' => 'Sipariş başarı ile silindi.'], 200);
        }
}
