<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json([
        'user' => $request->user()
    ]);
});

Route::middleware(['auth:sanctum', 'role:admin, customer'])->group(function () {
    Route::apiResource('orders', OrderController::class);
    Route::delete('/orders/{order}/items/{item}', [OrderItemController::class, 'destroy']);
    Route::post('/orders/{order}/items', [OrderItemController::class, 'store']);
    Route::apiResource('products', ProductController::class);

});

Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    //Eğer sadece müşteri için bir route belirlemek istersek burayı kullanabilirzz.
});