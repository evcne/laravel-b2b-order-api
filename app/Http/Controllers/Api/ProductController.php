<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Services\Product\ProductServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;



class ProductController extends Controller
{
    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->all();
        return response()->json([
        'message' => 'Ürünler başarıyla getirildi.',
        'data' => ProductResource::collection($products)
    ]);
    }

    public function show($id): JsonResponse
    {
        $product = $this->productService->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Ürün bulunamadı.'
            ], 404);
        }

        return response()->json([
            'message' => 'Ürün başarıyla getirildi.',
            'data' => new ProductResource($product)
        ]);
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        try {
            
            $product = $this->productService->create($request->validated());

            $this->authorize('create', $product);

            return response()->json([
                'message' => 'Ürün başarıyla eklendi.',
                'data' => new ProductResource($product)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Bir hata oluştu.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        $updated = $this->productService->update($id, $request->validated());
        $this->authorize('update', $updated);

        if (!$updated) {
            return response()->json(['message' => 'Ürün bulunamadı.'], 404);
        }

        return response()->json([
            'message' => 'Ürün başarıyla güncellendi.',
            'data' => new ProductResource($updated)
        ]);
    }

    public function destroy($id): JsonResponse
    {

        $product = $this->productService->find($id);

        if (!$product) {
            return response()->json(['message' => 'Ürün bulunamadı.'], 404);
        }

        $this->authorize('delete', $product); 

        $deleted = $this->productService->delete($id); 

        return response()->json(['message' => 'Ürün başarıyla silindi.']);
    }
}
