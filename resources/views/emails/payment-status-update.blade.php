@extends('layouts.email')

@section('title', "Pedido #{$order->id} — {$headline}")

@section('content')
    {{-- Icon --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:0 0 24px;">
                <div style="width:64px;height:64px;border-radius:50%;display:inline-block;line-height:64px;text-align:center;
                    {{ $isPositive ? 'background-color:#F0FDF4;' : 'background-color:#FEF2F2;' }}">
                    <span style="font-size:32px;line-height:64px;">{{ $isPositive ? '✓' : '✕' }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- Heading --}}
    <h1 style="margin:0 0 8px;font-size:26px;font-weight:700;color:#1A1A2E;text-align:center;">
        {{ $headline }}
    </h1>
    <p style="margin:0 0 32px;font-size:15px;color:#4B5563;line-height:1.6;text-align:center;">
        Hola <strong>{{ $order->customer->name ?? 'cliente' }}</strong>, sobre tu pedido
        <strong style="color:#002F6D;">#{{ $order->id }}</strong>: {{ $body }}
    </p>

    {{-- Payment status badge --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
        <tr>
            <td align="center">
                <span style="display:inline-block;padding:8px 24px;border-radius:20px;font-size:14px;font-weight:700;
                    {{ $isPositive ? 'background-color:#F0FDF4;color:#166534;' : 'background-color:#FEF2F2;color:#991B1B;' }}">
                    Estado del pago: {{ $statusLabel }}
                </span>
            </td>
        </tr>
    </table>

    {{-- Si fue rechazado, link para subir nuevo comprobante --}}
    @if($event === 'rejected' && $order->tracking_token)
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FEF9C3;border:1px solid #FDE68A;border-radius:12px;margin-bottom:28px;">
        <tr>
            <td style="padding:20px;text-align:center;">
                <p style="margin:0 0 12px;font-size:14px;color:#854D0E;font-weight:600;">Sube un nuevo comprobante</p>
                <a href="{{ route('order.track', $order->tracking_token) }}"
                   style="display:inline-block;background-color:#002F6D;color:#FFFFFF;font-size:14px;font-weight:600;text-decoration:none;padding:10px 24px;border-radius:8px;">
                    Subir comprobante →
                </a>
            </td>
        </tr>
    </table>
    @endif

    {{-- Order summary --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:4px;">
        <tr>
            <td style="padding:10px 16px;background-color:#002F6D;border-radius:8px 8px 0 0;font-size:13px;font-weight:700;color:#FFFFFF;text-transform:uppercase;letter-spacing:0.5px;">
                Resumen del pedido
            </td>
        </tr>
    </table>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #E5E7EB;border-top:none;border-radius:0 0 8px 8px;overflow:hidden;margin-bottom:24px;">
        @foreach($order->items as $item)
        <tr>
            <td style="padding:12px 16px;border-bottom:1px solid #F3F4F6;font-size:14px;color:#1A1A2E;">
                {{ $item->product->name ?? 'Producto' }}
                @if($item->variant)
                    <span style="font-size:12px;color:#6B7280;"> — {{ $item->variant->name ?? $item->variant->value ?? '' }}</span>
                @endif
            </td>
            <td align="center" style="padding:12px 4px;border-bottom:1px solid #F3F4F6;font-size:13px;color:#6B7280;" width="40">
                x{{ $item->qty }}
            </td>
            <td align="right" style="padding:12px 16px;border-bottom:1px solid #F3F4F6;font-size:14px;color:#1A1A2E;font-weight:600;" width="90">
                ${{ number_format($item->total, 2) }}
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" style="padding:12px 16px;font-size:15px;font-weight:700;color:#002F6D;background-color:#F9FAFB;">Total</td>
            <td align="right" style="padding:12px 16px;font-size:15px;font-weight:700;color:#002F6D;background-color:#F9FAFB;">${{ number_format($order->total, 2) }}</td>
        </tr>
    </table>

    {{-- CTA --}}
    @if($order->tracking_token)
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
        <tr>
            <td align="center">
                <a href="{{ route('order.track', $order->tracking_token) }}"
                   style="display:inline-block;background-color:#3A8DDE;color:#FFFFFF;font-size:15px;font-weight:600;text-decoration:none;padding:14px 36px;border-radius:8px;">
                    Ver estado de mi pedido
                </a>
            </td>
        </tr>
    </table>
    @endif

    {{-- Help --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="border-top:1px solid #E5E7EB;padding:20px 0 0;">
                <p style="margin:0 0 4px;font-size:13px;color:#9CA3AF;">¿Tienes dudas?</p>
                <p style="margin:0;font-size:13px;">
                    <a href="mailto:contacto@nuvionglass.com.mx" style="color:#3A8DDE;text-decoration:none;font-weight:600;">contacto@nuvionglass.com.mx</a>
                </p>
            </td>
        </tr>
    </table>
@endsection
