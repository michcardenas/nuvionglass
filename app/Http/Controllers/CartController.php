<?php

namespace App\Http\Controllers;

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
        $items = $this->cart->getItems();
        $itemsJson = $items->map(fn ($item) => [
            'key' => $item['key'],
            'name' => $item['product']->name,
            'slug' => $item['product']->slug,
            'image' => $item['product']->images[0] ?? null,
            'variant' => $item['variant']?->value,
            'qty' => $item['qty'],
            'unit_price' => $item['unit_price'],
            'total' => $item['total'],
        ])->values();

        return view('storefront.cart', [
            'itemsJson' => $itemsJson,
            'subtotal' => $this->cart->getSubtotal(),
            'shipping' => $this->cart->getShipping(),
            'total' => $this->cart->getTotal(),
        ]);
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
            $items = $this->cart->getItems();

            return response()->json([
                'message' => 'Producto agregado al carrito.',
                'cart_count' => $this->cart->count(),
                'items' => $items->map(fn ($item) => [
                    'key' => $item['key'],
                    'name' => $item['product']->name,
                    'slug' => $item['product']->slug,
                    'image' => $item['product']->images[0] ?? null,
                    'variant' => $item['variant']?->value,
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['total'],
                ]),
                'subtotal' => $this->cart->getSubtotal(),
                'shipping' => $this->cart->getShipping(),
                'total' => $this->cart->getTotal(),
            ]);
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
            $items = $this->cart->getItems();

            return response()->json([
                'cart_count' => $this->cart->count(),
                'items' => $items->map(fn ($item) => [
                    'key' => $item['key'],
                    'name' => $item['product']->name,
                    'slug' => $item['product']->slug,
                    'image' => $item['product']->images[0] ?? null,
                    'variant' => $item['variant']?->value,
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['total'],
                ]),
                'subtotal' => $this->cart->getSubtotal(),
                'shipping' => $this->cart->getShipping(),
                'total' => $this->cart->getTotal(),
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function remove(string $itemId): RedirectResponse|JsonResponse
    {
        $this->cart->remove($itemId);

        if (request()->expectsJson()) {
            $items = $this->cart->getItems();

            return response()->json([
                'cart_count' => $this->cart->count(),
                'items' => $items->map(fn ($item) => [
                    'key' => $item['key'],
                    'name' => $item['product']->name,
                    'slug' => $item['product']->slug,
                    'image' => $item['product']->images[0] ?? null,
                    'variant' => $item['variant']?->value,
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['total'],
                ]),
                'subtotal' => $this->cart->getSubtotal(),
                'shipping' => $this->cart->getShipping(),
                'total' => $this->cart->getTotal(),
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Producto eliminado del carrito.');
    }
}
