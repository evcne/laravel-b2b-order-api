<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductServiceInterface;
use App\Services\Product\ProductService;

use App\Services\Order\OrderService;
use App\Services\Order\OrderServiceInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;

use App\Services\OrderItem\OrderItemService;
use App\Services\OrderItem\OrderItemServiceInterface;
use App\Repositories\OrderItem\OrderItemRepository;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;

use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

        $this->app->bind(OrderItemServiceInterface::class, OrderItemService::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);

        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
