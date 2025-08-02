<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Services\Product\ProductServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Cache;


class ProductController extends Controller
{
    protected ProductServiceInterface $productService;
    protected Helper $helper;

    public function __construct(ProductServiceInterface $productService, Helper $helper)
    {
        $this->productService = $productService;
        $this->helper = $helper;
    }

    public function index(): JsonResponse
    {
        //$cacheKey = 'product-list';
        //$ttlMinutes = 2;

        /*$products = Cache::remember($cacheKey, $ttlMinutes, function () {
            return $this->productService->all();
        });*/

        $products = $this->productService->all();
        
        
        return response()->json(
            Helper::gelfOutput(ProductResource::collection($products), true, Helper::READ_SUCCESS_TEXT, Helper::R000)
        );

    }

    public function show($id): JsonResponse
    {
        $product = $this->productService->find($id);

        if (!$product) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::READ_FAILED_TEXT, Helper::R002)
            );
        }

        return response()->json(
            Helper::gelfOutput(new ProductResource($product), true, Helper::READ_SUCCESS_TEXT, Helper::R000)
        );
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        try {

            if(auth()->user()->role !== Helper::USER_ROLE_ADMIN) {
                return response()->json(
                    Helper::gelfOutput(null, true, Helper::USER_DOES_NOT_AUTHORIZED, Helper::C001)
                );
            }
            
            $product = $this->productService->create($request->validated());

            $this->authorize('create', $product);

            return response()->json(
                Helper::gelfOutput(new ProductResource($product), true, Helper::CREATE_SUCCESS_TEXT, Helper::C000)
            );

        } catch (\Exception $e) {
        
            return response()->json(
                Helper::gelfOutput($e->getMessage(), true, Helper::CREATE_FAILED_TEXT, Helper::C001)
            );
        }
    }

    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        if(auth()->user()->role !== Helper::USER_ROLE_ADMIN) {
            return response()->json(
                Helper::gelfOutput(null, true, Helper::USER_DOES_NOT_AUTHORIZED, Helper::C001)
            );
        }
        
        $updated = $this->productService->update($id, $request->validated());
        $this->authorize('update', $updated);

        if (!$updated) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::UPDATE_FAILED_TEXT, Helper::U002)
            );
        }

        return response()->json(
            Helper::gelfOutput(new ProductResource($updated), true, Helper::UPDATE_SUCCESS_TEXT, Helper::U000)
        );
    }

    public function destroy($id): JsonResponse
    {

        if(auth()->user()->role !== Helper::USER_ROLE_ADMIN) {
            return response()->json(
                Helper::gelfOutput(null, true, Helper::USER_DOES_NOT_AUTHORIZED, Helper::C001)
            );
        }

        $product = $this->productService->find($id);

        if (!$product) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::DELETE_FAILED_TEXT, Helper::D002)
            );
        }

        $this->authorize('delete', $product); 

        $deleted = $this->productService->delete($id); 

        return response()->json(
            Helper::gelfOutput(null, true, Helper::DELETE_SUCCESS_TEXT, Helper::D000)
        );
    }
}
