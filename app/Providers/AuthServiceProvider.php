<?php

namespace App\Providers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Policies\OrderPolicy;
use App\Policies\OrderItemPolicy;
use App\Policies\ProductPolicy;


// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Order::class => OrderPolicy::class,
        Product::class => ProductPolicy::class,
        OrderItem::class => OrderItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
