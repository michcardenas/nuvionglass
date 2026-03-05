@extends('layouts.email')

@section('title', "Pedido #{$order->id} confirmado")

@section('content')
    {{-- Heading --}}
    <h1 style="margin:0 0 8px;font-size:24px;font-weight:700;color:#1A1A2E;">
        ¡Pedido confirmado!
    </h1>
    <p style="margin:0 0 24px;font-size:15px;color:#4B5563;line-height:1.6;">
        Hola {{ $order->customer->name }}, recibimos tu pedido <strong style="color:#002F6D;">#{{ $order->id }}</strong>.
        Te avisaremos cuando esté en camino.
    </p>

    {{-- Order items table --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin-bottom:24px;">
        <tr>
            <td style="padding:10px 0;border-bottom:2px solid #002F6D;font-size:13px;font-weight:700;color:#002F6D;text-transform:uppercase;letter-spacing:0.5px;">
                Producto
            </td>
            <td align="center" style="padding:10px 0;border-bottom:2px solid #002F6D;font-size:13px;font-weight:700;color:#002F6D;text-transform:uppercase;letter-spacing:0.5px;" width="60">
                Cant.
            </td>
            <td align="right" style="padding:10px 0;border-bottom:2px solid #002F6D;font-size:13px;font-weight:700;color:#002F6D;text-transform:uppercase;letter-spacing:0.5px;" width="100">
                Total
            </td>
        </tr>
        @foreach($order->items as $item)
        <tr>
            <td style="padding:12px 0;border-bottom:1px solid #E5E7EB;font-size:14px;color:#1A1A2E;">
                {{ $item->product->name ?? 'Producto' }}
                @if($item->variant)
                    <br><span style="font-size:12px;color:#6B7280;">{{ $item->variant->name }}</span>
                @endif
            </td>
            <td align="center" style="padding:12px 0;border-bottom:1px solid #E5E7EB;font-size:14px;color:#4B5563;">
                {{ $item->qty }}
            </td>
            <td align="right" style="padding:12px 0;border-bottom:1px solid #E5E7EB;font-size:14px;color:#1A1A2E;font-weight:600;">
                ${{ number_format($item->total, 2) }}
            </td>
        </tr>
        @endforeach
    </table>

    {{-- Totals --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:32px;">
        <tr>
            <td style="padding:6px 0;font-size:14px;color:#4B5563;">Subtotal</td>
            <td align="right" style="padding:6px 0;font-size:14px;color:#4B5563;">${{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td style="padding:6px 0;font-size:14px;color:#4B5563;">Envío</td>
            <td align="right" style="padding:6px 0;font-size:14px;color:#4B5563;">
                @if($order->shipping > 0)
                    ${{ number_format($order->shipping, 2) }}
                @else
                    <span style="color:#16A34A;">Gratis</span>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding:12px 0 0;font-size:18px;font-weight:700;color:#002F6D;border-top:2px solid #002F6D;">Total</td>
            <td align="right" style="padding:12px 0 0;font-size:18px;font-weight:700;color:#002F6D;border-top:2px solid #002F6D;">${{ number_format($order->total, 2) }}</td>
        </tr>
    </table>

    {{-- Shipping info --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F4F6F9;border-radius:8px;margin-bottom:32px;">
        <tr>
            <td style="padding:20px;">
                <p style="margin:0 0 4px;font-size:13px;font-weight:700;color:#002F6D;text-transform:uppercase;letter-spacing:0.5px;">Dirección de envío</p>
                <p style="margin:0;font-size:14px;color:#4B5563;line-height:1.6;">{{ $order->shipping_address }}</p>
                @if($order->notes)
                    <p style="margin:12px 0 0;font-size:13px;color:#6B7280;"><strong>Notas:</strong> {{ $order->notes }}</p>
                @endif
            </td>
        </tr>
    </table>

    {{-- CTA --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:8px 0;">
                <a href="{{ route('products.index') }}"
                   style="display:inline-block;background-color:#3A8DDE;color:#FFFFFF;font-size:15px;font-weight:600;text-decoration:none;padding:14px 32px;border-radius:8px;">
                    Seguir comprando
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0;font-size:13px;color:#9CA3AF;text-align:center;">
        ¿Tienes dudas? Responde a este correo y te ayudaremos.
    </p>
@endsection
