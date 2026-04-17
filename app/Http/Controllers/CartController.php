<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\ShippingSetting;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private CartService $cart,
    ) {}

    public function index(): View
    {
        $data = $this->cartData();

        return view('storefront.cart', $data);
    }

    public function add(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'qty' => 'integer|min:1|max:10',
        ]);

        $this->cart->add(
            $validated['product_id'],
            $validated['qty'] ?? 1,
            $validated['variant_id'] ?? null,
        );

        if ($request->expectsJson()) {
            return response()->json(array_merge(
                ['message' => 'Producto agregado al carrito.'],
                $this->cartData(),
            ));
        }

        return redirect()->route('cart.index')
            ->with('success', 'Producto agregado al carrito.');
    }

    public function update(Request $request, string $itemId): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:0|max:10',
        ]);

        $this->cart->update($itemId, $validated['qty']);

        if ($request->expectsJson()) {
            return response()->json($this->cartData());
        }

        return redirect()->route('cart.index');
    }

    public function remove(string $itemId): RedirectResponse|JsonResponse
    {
        $this->cart->remove($itemId);

        if (request()->expectsJson()) {
            return response()->json($this->cartData());
        }

        return redirect()->route('cart.index')
            ->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Build the full cart data array (used by JSON responses and the cart page view).
     */
    private function cartData(): array
    {
        $items = $this->cart->getItems();
        $promo = $this->cart->calculate2x1();
        $subtotal = $this->cart->getSubtotal();
        $discount = $promo['discount'];
        $subtotalConDescuento = $subtotal - $discount;

        $threshold = (float) ShippingSetting::get('free_shipping_threshold', 999);
        $defaultShipping = (float) ShippingSetting::get('default_price', 99.00);
        $shipping = ($threshold > 0 && $subtotalConDescuento >= $threshold) ? 0 : $defaultShipping;

        // Coupon discount from session
        $couponCode = null;
        $couponDescription = null;
        $couponDiscount = 0;
        $discountCodeId = session('discount_code_id');

        if ($discountCodeId) {
            $discountCode = DiscountCode::find($discountCodeId);
            if ($discountCode && $discountCode->isValid($subtotalConDescuento)) {
                $couponCode = $discountCode->code;
                $couponDiscount = $discountCode->calculateDiscount($subtotalConDescuento);
                $couponDescription = $discountCode->type === 'percentage'
                    ? $discountCode->value . '% de descuento'
                    : '$' . number_format($discountCode->value, 2) . ' de descuento';
            } else {
                session()->forget('discount_code_id');
            }
        }

        $total = $subtotalConDescuento - $couponDiscount + $shipping;

        return [
            'cart_count' => $this->cart->count(),
            'items' => $items->map(fn ($item) => [
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
            ])->values(),
            'subtotal' => $subtotal,
            'discount_2x1' => $discount,
            'free_items' => $promo['free_items'],
            'coupon_code' => $couponCode,
            'coupon_description' => $couponDescription,
            'coupon_discount' => $couponDiscount,
            'shipping' => $shipping,
            'free_threshold' => $threshold,
            'total' => max(0, $total),
        ];
    }
}
