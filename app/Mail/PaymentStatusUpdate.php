<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Correo enviado cuando cambia el estado del pago de una orden.
 * Se usa al aprobar / rechazar / cambiar manualmente desde admin.
 */
class PaymentStatusUpdate extends Mailable
{
    public string $statusLabel;
    public string $headline;
    public string $body;
    public bool $isPositive;

    public function __construct(
        public Order $order,
        public string $event = 'updated', // 'approved' | 'rejected' | 'updated'
    ) {
        $this->statusLabel = match ($order->payment_status) {
            'paid' => 'Pagado',
            'pending' => 'Pendiente',
            'processing' => 'Procesando',
            'failed' => 'Fallido',
            'refunded' => 'Reembolsado',
            default => $order->payment_status,
        };

        [$this->headline, $this->body, $this->isPositive] = match ($event) {
            'approved' => [
                '¡Pago aprobado!',
                'Hemos verificado tu pago y tu pedido está confirmado. Te avisaremos cuando se envíe.',
                true,
            ],
            'rejected' => [
                'Comprobante rechazado',
                'No pudimos verificar tu comprobante de pago. Por favor sube uno nuevo o contáctanos para ayudarte.',
                false,
            ],
            default => [
                "Estado del pago: {$this->statusLabel}",
                "El estado de pago de tu pedido cambió a \"{$this->statusLabel}\".",
                in_array($order->payment_status, ['paid', 'refunded'], true),
            ],
        };
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Pedido #{$this->order->id} — {$this->headline} — nuvion glass",
            replyTo: [
                new Address(config('mail.contacto'), 'Nuvion Glass'),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-status-update',
        );
    }
}
