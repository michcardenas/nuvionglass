<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderShipped;
use App\Mail\OrderStatusUpdate;
use App\Mail\PaymentStatusUpdate;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['customer', 'items.product', 'items.variant']);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Orden actualizada.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            'notify_status' => 'nullable|boolean',
        ]);

        $notify = $validated['notify_status'] ?? false;
        unset($validated['notify_status']);

        // Si la orden avanza a confirmada/enviada/entregada, el pago debe estar
        // marcado como pagado — no tiene sentido tener una orden enviada con pago pendiente.
        if (
            in_array($validated['status'], ['confirmed', 'shipped', 'delivered'], true)
            && $order->payment_status !== 'paid'
        ) {
            $validated['payment_status'] = 'paid';
        }

        $order->update($validated);
        $order->load('items.product', 'items.variant', 'customer');

        // Cliente: solo si marcaron 'notificar'. Admin: siempre.
        if ($notify) {
            $this->sendToCustomer($order, new OrderStatusUpdate($order));
        }
        $this->sendToAdmin($order, new OrderStatusUpdate($order));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', $notify ? 'Estado actualizado y cliente notificado.' : 'Estado actualizado.');
    }

    public function verifyPayment(Order $order): RedirectResponse
    {
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);
        $order->load('items.product', 'items.variant', 'customer');

        $this->sendToCustomer($order, new PaymentStatusUpdate($order, 'approved'));
        $this->sendToAdmin($order, new PaymentStatusUpdate($order, 'approved'));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pago verificado y orden confirmada. Correo enviado al cliente y al admin.');
    }

    public function updatePaymentStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,processing,paid,failed,refunded',
        ]);

        $order->update($validated);
        $order->load('items.product', 'items.variant', 'customer');

        $event = match ($validated['payment_status']) {
            'paid' => 'approved',
            'failed' => 'rejected',
            default => 'updated',
        };

        $this->sendToCustomer($order, new PaymentStatusUpdate($order, $event));
        $this->sendToAdmin($order, new PaymentStatusUpdate($order, $event));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Estado del pago actualizado a "' . $validated['payment_status'] . '". Correo enviado.');
    }

    public function rejectPayment(Request $request, Order $order): RedirectResponse
    {
        // Delete the uploaded receipt
        if ($order->payment_receipt) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($order->payment_receipt);
        }

        $order->update([
            'payment_status' => 'pending',
            'payment_receipt' => null,
        ]);
        $order->load('items.product', 'items.variant', 'customer');

        $this->sendToCustomer($order, new PaymentStatusUpdate($order, 'rejected'));
        $this->sendToAdmin($order, new PaymentStatusUpdate($order, 'rejected'));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Comprobante rechazado. El cliente podrá subir uno nuevo. Correo enviado.');
    }

    public function updateTracking(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_carrier' => 'nullable|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
            'tracking_url' => 'nullable|url|max:500',
            'notify_customer' => 'nullable|boolean',
        ]);

        $notify = $validated['notify_customer'] ?? false;
        unset($validated['notify_customer']);

        $order->update($validated);

        // Auto-set status to shipped if tracking is added and status is pending/confirmed
        if ($validated['tracking_number'] && in_array($order->status, ['pending', 'confirmed'])) {
            $order->update(['status' => 'shipped']);
        }

        $order->load('items.product', 'items.variant', 'customer');

        if ($notify) {
            $this->sendToCustomer($order, new OrderShipped($order));
        }
        $this->sendToAdmin($order, new OrderShipped($order));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', $notify ? 'Guía actualizada y cliente notificado.' : 'Guía actualizada.');
    }

    /**
     * Envía un correo al cliente de la orden. Captura cualquier error para que el
     * flujo del admin no se rompa si el SMTP falla.
     */
    private function sendToCustomer(Order $order, Mailable $mailable): void
    {
        if (! $order->customer?->email) {
            return;
        }
        try {
            Mail::to($order->customer->email)->send($mailable);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Envía un correo al admin configurado (MAIL_ADMIN). Captura errores
     * para no romper el flujo del admin si el SMTP falla.
     */
    private function sendToAdmin(Order $order, Mailable $mailable): void
    {
        $adminEmail = config('mail.admin');
        if (! $adminEmail) {
            return;
        }
        try {
            Mail::to($adminEmail)->send($mailable);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Orden #' . $order->id . ' eliminada correctamente.');
    }

    public function exportCsv(): StreamedResponse
    {
        $orders = Order::with('customer')->latest()->get();

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Fecha', 'Cliente', 'Email', 'Total', 'Estado', 'Pago']);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->id,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->customer->name,
                    $order->customer->email,
                    $order->total,
                    $order->status,
                    $order->payment_status,
                ]);
            }

            fclose($handle);
        }, 'ordenes-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
