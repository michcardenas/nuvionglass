<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private CheckoutService $checkout,
    ) {}

    public function index(): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        return view('storefront.checkout', [
            'items' => $this->cart->getItems(),
            'subtotal' => $this->cart->getSubtotal(),
            'shipping' => $this->cart->getShipping(),
            'total' => $this->cart->getTotal(),
        ]);
    }

    public function process(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'payment_method' => 'required|in:transfer,cash_on_delivery',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order = $this->checkout->process($validated);

        return redirect()->route('checkout.confirmation', $order->id)
            ->with('success', '¡Pedido realizado con éxito!');
    }

    public function confirmation(Order $order): View
    {
        $order->load(['items.product', 'items.variant', 'customer']);

        return view('storefront.checkout-confirmation', [
            'order' => $order,
        ]);
    }
}
