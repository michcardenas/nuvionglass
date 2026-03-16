<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\PaymentIntent;
use Stripe\Stripe;

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

        $subtotal = $this->cart->getSubtotal();
        $shipping = $this->cart->getShipping();
        $discount = $this->getSessionDiscount($subtotal);

        return view('storefront.checkout', [
            'items' => $this->cart->getItems(),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => max(0, $subtotal - $discount['amount'] + $shipping),
            'appliedCoupon' => $discount['code'],
        ]);
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $code = strtoupper(trim($request->input('code')));
        $discountCode = DiscountCode::where('code', $code)->first();

        if (! $discountCode) {
            return response()->json(['message' => 'Código de descuento no encontrado.'], 422);
        }

        $subtotal = $this->cart->getSubtotal();

        if (! $discountCode->isValid($subtotal)) {
            $message = 'Código de descuento no válido.';

            if ($discountCode->expires_at?->isPast()) {
                $message = 'Este código ha expirado.';
            } elseif ($discountCode->max_uses !== null && $discountCode->times_used >= $discountCode->max_uses) {
                $message = 'Este código ha alcanzado su límite de usos.';
            } elseif ($discountCode->min_order_amount && $subtotal < (float) $discountCode->min_order_amount) {
                $message = 'Compra mínima de $' . number_format($discountCode->min_order_amount, 2) . ' requerida.';
            } elseif (! $discountCode->is_active) {
                $message = 'Este código no está activo.';
            }

            return response()->json(['message' => $message], 422);
        }

        $discountAmount = $discountCode->calculateDiscount($subtotal);
        $shipping = $this->cart->getShipping();
        $newTotal = max(0, $subtotal - $discountAmount + $shipping);

        session(['discount_code_id' => $discountCode->id]);

        return response()->json([
            'success' => true,
            'code' => $discountCode->code,
            'description' => $discountCode->type === 'percentage'
                ? $discountCode->value . '% de descuento'
                : '$' . number_format($discountCode->value, 2) . ' de descuento',
            'discount_amount' => $discountAmount,
            'new_total' => $newTotal,
        ]);
    }

    public function removeCoupon(): JsonResponse
    {
        session()->forget('discount_code_id');

        $subtotal = $this->cart->getSubtotal();
        $shipping = $this->cart->getShipping();

        return response()->json([
            'success' => true,
            'new_total' => $subtotal + $shipping,
        ]);
    }

    public function createPaymentIntent(): JsonResponse
    {
        if ($this->cart->isEmpty()) {
            return response()->json(['message' => 'El carrito está vacío.'], 422);
        }

        $subtotal = $this->cart->getSubtotal();
        $shipping = $this->cart->getShipping();
        $discount = $this->getSessionDiscount($subtotal);
        $total = max(0, $subtotal - $discount['amount'] + $shipping);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => (int) round($total * 100),
            'currency' => 'mxn',
            'automatic_payment_methods' => ['enabled' => true],
            'metadata' => [
                'cart_total' => $total,
                'discount_code' => $discount['code'] ?? '',
                'discount_amount' => $discount['amount'],
            ],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function process(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'payment_method' => 'required|in:transfer,cash_on_delivery,card',
            'stripe_payment_intent_id' => 'required_if:payment_method,card|nullable|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        $subtotal = $this->cart->getSubtotal();
        $discount = $this->getSessionDiscount($subtotal);

        $validated['discount_code'] = $discount['code'];
        $validated['discount_amount'] = $discount['amount'];

        // If card payment, verify with Stripe that payment succeeded
        if ($validated['payment_method'] === 'card' && !empty($validated['stripe_payment_intent_id'])) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = PaymentIntent::retrieve($validated['stripe_payment_intent_id']);

            if ($paymentIntent->status === 'succeeded') {
                $validated['payment_status'] = 'paid';
                $validated['order_status'] = 'confirmed';
            }
        }

        $order = $this->checkout->process($validated);

        if ($discount['model']) {
            $discount['model']->increment('times_used');
        }

        session()->forget('discount_code_id');

        if ($request->expectsJson()) {
            return response()->json([
                'redirect' => route('checkout.confirmation', $order->id),
            ]);
        }

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

    public function track(string $tracking_token): View
    {
        $order = Order::where('tracking_token', $tracking_token)
            ->with(['items.product', 'items.variant', 'customer'])
            ->firstOrFail();

        return view('storefront.order-tracking', [
            'order' => $order,
        ]);
    }

    private function getSessionDiscount(float $subtotal): array
    {
        $discountCodeId = session('discount_code_id');

        if (! $discountCodeId) {
            return ['code' => null, 'amount' => 0, 'model' => null];
        }

        $discountCode = DiscountCode::find($discountCodeId);

        if (! $discountCode || ! $discountCode->isValid($subtotal)) {
            session()->forget('discount_code_id');
            return ['code' => null, 'amount' => 0, 'model' => null];
        }

        return [
            'code' => $discountCode->code,
            'amount' => $discountCode->calculateDiscount($subtotal),
            'model' => $discountCode,
        ];
    }
}
