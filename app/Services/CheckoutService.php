<?php

namespace App\Services;

use App\Mail\OrderConfirmation;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutService
{
    public function __construct(
        private CartService $cart,
    ) {}

    /**
     * Process checkout: create customer, order, order items, clear cart.
     *
     * @param  array{name: string, email: string, phone?: string, address: string, city: string, state: string, zip_code: string, payment_method: string, notes?: string}  $data
     */
    public function process(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $customer = $this->findOrCreateCustomer($data);
            $order = $this->createOrder($customer, $data);
            $this->createOrderItems($order);
            $this->cart->clear();

            $order->load('items.product', 'items.variant', 'customer');
            Mail::to($order->customer->email)->send(new OrderConfirmation($order));

            return $order;
        });
    }

    /**
     * Find existing customer by email or create a new one.
     */
    private function findOrCreateCustomer(array $data): Customer
    {
        return Customer::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip_code' => $data['zip_code'],
            ],
        );
    }

    /**
     * Create the order record.
     */
    private function createOrder(Customer $customer, array $data): Order
    {
        $shippingAddress = implode(', ', array_filter([
            $data['address'],
            $data['city'],
            $data['state'],
            $data['zip_code'],
        ]));

        $subtotal = $this->cart->getSubtotal();
        $shipping = $this->cart->getShipping();
        $discountAmount = (float) ($data['discount_amount'] ?? 0);
        $total = max(0, $subtotal - $discountAmount + $shipping);

        return Order::create([
            'customer_id' => $customer->id,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'discount_code' => $data['discount_code'] ?? null,
            'discount_amount' => $discountAmount,
            'total' => $total,
            'payment_method' => $data['payment_method'],
            'payment_status' => ($data['payment_method'] === 'card') ? 'processing' : 'pending',
            'stripe_payment_intent_id' => $data['stripe_payment_intent_id'] ?? null,
            'shipping_address' => $shippingAddress,
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * Create order items from cart contents.
     */
    private function createOrderItems(Order $order): void
    {
        foreach ($this->cart->getItems() as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total' => $item['total'],
            ]);
        }
    }
}
