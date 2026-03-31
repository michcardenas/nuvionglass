@extends('layouts.app')

@section('title', "Pedido #{$order->id} | nuvion - glass")

@section('content')
<section class="py-12 md:py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="font-brand text-3xl md:text-4xl font-bold text-text-dark">
                Pedido <span class="text-primary">#{{ $order->id }}</span>
            </h1>
            <p class="mt-2 text-text-muted">
                Realizado el {{ $order->created_at->format('d/m/Y') }} a las {{ $order->created_at->format('H:i') }}
            </p>
        </div>

        {{-- Status Timeline --}}
        @php
            $statuses = [
                'pending'   => ['label' => 'Pendiente',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                'confirmed' => ['label' => 'Confirmado',  'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                'shipped'   => ['label' => 'Enviado',     'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12'],
                'delivered' => ['label' => 'Entregado',   'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
            ];

            $statusKeys = array_keys($statuses);
            $currentIndex = $order->status === 'cancelled' ? -1 : array_search($order->status, $statusKeys);
        @endphp

        @if($order->status === 'cancelled')
            <div class="bg-danger/10 border border-danger/20 rounded-xl p-6 text-center mb-8">
                <svg class="w-12 h-12 mx-auto text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="mt-3 text-lg font-semibold text-danger">Pedido cancelado</p>
            </div>
        @else
            <div class="bg-white border border-border-light rounded-xl p-6 md:p-8 mb-8">
                <div class="flex items-center justify-between relative">
                    {{-- Progress line --}}
                    <div class="absolute top-5 left-0 right-0 h-0.5 bg-muted mx-10 md:mx-16"></div>
                    <div class="absolute top-5 left-0 h-0.5 bg-primary mx-10 md:mx-16 transition-all duration-500"
                         style="width: {{ $currentIndex > 0 ? ($currentIndex / (count($statuses) - 1)) * (100 - 15) : 0 }}%"></div>

                    @foreach($statuses as $key => $info)
                        @php
                            $index = array_search($key, $statusKeys);
                            $isActive = $index <= $currentIndex;
                            $isCurrent = $index === $currentIndex;
                        @endphp
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300
                                {{ $isCurrent ? 'bg-primary text-white ring-4 ring-primary/20 scale-110' : ($isActive ? 'bg-primary text-white' : 'bg-muted text-text-muted') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $info['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs md:text-sm font-medium {{ $isActive ? 'text-primary' : 'text-text-muted' }}">
                                {{ $info['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Tracking info (when shipped) --}}
        @if($order->tracking_number)
            <div class="bg-white border border-primary/20 rounded-xl p-6 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                            </svg>
                        </div>
                        <div>
                            @if($order->shipping_carrier)
                                <p class="text-xs text-text-muted uppercase tracking-wide font-semibold">Paquetería</p>
                                <p class="font-semibold text-text-dark">{{ $order->shipping_carrier }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-text-muted uppercase tracking-wide font-semibold">No. de guía</p>
                        <p class="font-bold text-primary text-lg font-mono tracking-wider">{{ $order->tracking_number }}</p>
                    </div>
                    @if($order->tracking_url)
                        <a href="{{ $order->tracking_url }}" target="_blank"
                           class="inline-flex items-center gap-2 bg-primary hover:bg-primary-light text-white px-6 py-3 rounded-lg font-semibold text-sm transition-colors flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                            </svg>
                            Rastrear envío
                        </a>
                    @endif
                </div>
            </div>
        @endif

        {{-- Order Details --}}
        <div class="grid md:grid-cols-3 gap-6">

            {{-- Items (2 cols) --}}
            <div class="md:col-span-2 bg-white border border-border-light rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-border-light">
                    <h2 class="font-brand text-lg font-bold text-text-dark">Productos</h2>
                </div>
                <div class="divide-y divide-border-light">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 px-6 py-4">
                        @if($item->product && $item->product->images)
                            <img src="{{ asset('storage/' . ($item->product->images[0] ?? '')) }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-16 h-16 object-cover rounded-lg bg-bg-light">
                        @else
                            <div class="w-16 h-16 bg-bg-light rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-text-dark truncate">{{ $item->product->name ?? 'Producto' }}</p>
                            @if($item->variant)
                                <p class="text-sm text-text-muted">{{ $item->variant->name ?? $item->variant->value ?? '' }}</p>
                            @endif
                            <p class="text-sm text-text-muted">Cant: {{ $item->qty }}</p>
                        </div>
                        <p class="font-semibold text-text-dark">${{ number_format($item->total, 2) }}</p>
                    </div>
                    @endforeach
                </div>
                {{-- Totals --}}
                <div class="px-6 py-4 bg-bg-light space-y-2">
                    <div class="flex justify-between text-sm text-text-muted">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between text-sm text-success">
                        <span>Descuento {{ $order->discount_code ? "({$order->discount_code})" : '' }}</span>
                        <span>-${{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-sm text-text-muted">
                        <span>Envío</span>
                        <span>{{ $order->shipping > 0 ? '$' . number_format($order->shipping, 2) : 'Gratis' }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-primary pt-2 border-t border-border-light">
                        <span>Total</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">

                {{-- Payment --}}
                <div class="bg-white border border-border-light rounded-xl p-6">
                    <h3 class="font-brand font-bold text-text-dark mb-3">Pago</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-text-muted">Método</span>
                            <span class="font-medium text-text-dark">
                                @switch($order->payment_method)
                                    @case('card') Tarjeta @break
                                    @case('transfer') Transferencia @break
                                    @case('cash_on_delivery') Contra entrega @break
                                    @default {{ $order->payment_method }}
                                @endswitch
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-muted">Estado</span>
                            <span class="inline-flex items-center gap-1 font-medium
                                {{ $order->payment_status === 'paid' ? 'text-success' : ($order->payment_status === 'failed' ? 'text-danger' : 'text-warning') }}">
                                <span class="w-2 h-2 rounded-full
                                    {{ $order->payment_status === 'paid' ? 'bg-success' : ($order->payment_status === 'failed' ? 'bg-danger' : 'bg-warning') }}"></span>
                                @switch($order->payment_status)
                                    @case('paid') Pagado @break
                                    @case('pending') Pendiente @break
                                    @case('processing') Procesando @break
                                    @case('failed') Fallido @break
                                    @default {{ $order->payment_status }}
                                @endswitch
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Shipping address --}}
                <div class="bg-white border border-border-light rounded-xl p-6">
                    <h3 class="font-brand font-bold text-text-dark mb-3">Dirección de envío</h3>
                    <p class="text-sm text-text-muted leading-relaxed">{{ $order->shipping_address }}</p>
                </div>

                {{-- Customer --}}
                <div class="bg-white border border-border-light rounded-xl p-6">
                    <h3 class="font-brand font-bold text-text-dark mb-3">Datos del cliente</h3>
                    <div class="space-y-1 text-sm">
                        <p class="font-medium text-text-dark">{{ $order->customer->name }}</p>
                        <p class="text-text-muted">{{ $order->customer->email }}</p>
                        @if($order->customer->phone)
                            <p class="text-text-muted">{{ $order->customer->phone }}</p>
                        @endif
                    </div>
                </div>

                {{-- Help --}}
                <div class="bg-primary/5 border border-primary/10 rounded-xl p-6 text-center">
                    <p class="text-sm text-text-muted">¿Necesitas ayuda?</p>
                    <a href="mailto:contacto@nuvionglass.com.mx" class="text-sm font-semibold text-primary hover:underline">
                        contacto@nuvionglass.com.mx
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
