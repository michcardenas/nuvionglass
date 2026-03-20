<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\ShippingSetting;
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
            $items = $cart->getItems();
            $promo = $cart->calculate2x1();
            $subtotal = $cart->getSubtotal();
            $discount = $promo['discount'];
            $subtotalConDescuento = $subtotal - $discount;

            $threshold = (float) ShippingSetting::get('free_shipping_threshold', 999);
            $defaultShipping = (float) ShippingSetting::get('default_price', 99.00);
            $shipping = ($threshold > 0 && $subtotalConDescuento >= $threshold) ? 0 : $defaultShipping;

            $itemsJson = $items->map(fn ($item) => [
                'key' => $item['key'],
                'name' => $item['product']->name,
                'slug' => $item['product']->slug,
                'image' => $item['product']->images[0] ?? null,
                'variant' => $item['variant']
                    ? trim(($item['variant']->color ?? $item['variant']->value) . ' ' . ($item['variant']->graduation ?? ''))
                    : null,
                'type' => $item['product']->type,
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total' => $item['total'],
            ])->values();

            // Toallitas for cart suggestion
            $toallitas = Product::active()->where('type', 'toallitas')->get();

            $view->with('cartCount', $cart->count());
            $view->with('cartItemsJson', $itemsJson);
            $view->with('cartSubtotal', $subtotal);
            $view->with('cartDiscount2x1', $discount);
            $view->with('cartFreeItems', $promo['free_items']);
            $view->with('cartShipping', $shipping);
            $view->with('cartTotal', $subtotalConDescuento + $shipping);
            $view->with('toallitasCarrito', $toallitas);
        });
    }
}
