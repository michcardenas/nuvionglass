<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.navbar', function ($view) {
            $cart = app(CartService::class);
            $items = $cart->getItems()->map(fn ($item) => [
                'key' => $item['key'],
                'name' => $item['product']->name,
                'slug' => $item['product']->slug,
                'image' => $item['product']->images[0] ?? null,
                'variant' => $item['variant']?->value,
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total' => $item['total'],
            ])->values();

            $view->with('cartCount', $cart->count());
            $view->with('cartItemsJson', $items);
            $view->with('cartSubtotal', $cart->getSubtotal());
            $view->with('cartShipping', $cart->getShipping());
            $view->with('cartTotal', $cart->getTotal());
        });
    }
}
