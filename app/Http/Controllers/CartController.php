<?php

namespace App\Http\Controllers;

use App\Services\CartService;
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
        return view('storefront.cart', [
            'items' => $this->cart->getItems(),
            'subtotal' => $this->cart->getSubtotal(),
            'shipping' => $this->cart->getShipping(),
            'total' => $this->cart->getTotal(),
        ]);
    }

    public function add(Request $request): RedirectResponse
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

        return redirect()->route('cart.index')
            ->with('success', 'Producto agregado al carrito.');
    }

    public function update(Request $request, string $itemId): RedirectResponse
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:0|max:10',
        ]);

        $this->cart->update($itemId, $validated['qty']);

        return redirect()->route('cart.index');
    }

    public function remove(string $itemId): RedirectResponse
    {
        $this->cart->remove($itemId);

        return redirect()->route('cart.index')
            ->with('success', 'Producto eliminado del carrito.');
    }
}
