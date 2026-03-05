@extends('layouts.admin')

@section('title', 'Orden #' . $order->id)
@section('page_title', 'Orden #' . $order->id)

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Volver al listado</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Order info --}}
            <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Productos</h2>
                <table class="w-full">
                    <thead class="text-left text-xs font-medium text-gray-500 uppercase">
                        <tr>
                            <th class="pb-3">Producto</th>
                            <th class="pb-3">Variante</th>
                            <th class="pb-3 text-center">Cant.</th>
                            <th class="pb-3 text-right">Precio</th>
                            <th class="pb-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3 font-medium">{{ $item->product->name }}</td>
                                <td class="py-3 text-gray-500">{{ $item->variant?->value ?? '—' }}</td>
                                <td class="py-3 text-center">{{ $item->qty }}</td>
                                <td class="py-3 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="py-3 text-right font-medium">${{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="text-sm border-t border-gray-200">
                        <tr>
                            <td colspan="4" class="pt-3 text-right text-gray-500">Subtotal</td>
                            <td class="pt-3 text-right font-medium">${{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="py-1 text-right text-gray-500">Envío</td>
                            <td class="py-1 text-right">${{ number_format($order->shipping, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="pt-1 text-right font-semibold text-gray-900">Total</td>
                            <td class="pt-1 text-right font-bold text-lg">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>

                @if($order->notes)
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-800 mb-1">Notas</h3>
                        <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Status --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Estado</h2>
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                        @csrf @method('PATCH')
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                            @foreach(['pending' => 'Pendiente', 'confirmed' => 'Confirmada', 'shipped' => 'Enviada', 'delivered' => 'Entregada', 'cancelled' => 'Cancelada'] as $val => $label)
                                <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium transition-colors">
                            Actualizar estado
                        </button>
                    </form>
                    <div class="mt-4 text-xs text-gray-500 space-y-1">
                        <p>Pago: <span class="font-medium text-gray-700">{{ $order->payment_method ?? '—' }}</span></p>
                        <p>Estado pago: <span class="font-medium text-gray-700">{{ $order->payment_status }}</span></p>
                    </div>
                </div>

                {{-- Customer --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Cliente</h2>
                    <dl class="space-y-2 text-sm">
                        <div>
                            <dt class="text-gray-500">Nombre</dt>
                            <dd class="font-medium">{{ $order->customer->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Email</dt>
                            <dd>{{ $order->customer->email }}</dd>
                        </div>
                        @if($order->customer->phone)
                            <div>
                                <dt class="text-gray-500">Teléfono</dt>
                                <dd>{{ $order->customer->phone }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Shipping --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Envío</h2>
                    <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
