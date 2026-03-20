@extends('layouts.app')

@section('title', 'Carrito de compras | nuvion - glass')

@section('content')
<section class="py-12" x-data="cartPage()">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-brand text-3xl font-bold text-white">Tu carrito</h1>
            <a href="{{ route('products.index') }}" class="text-sm text-secondary hover:text-secondary/80 transition-colors">
                ← Seguir comprando
            </a>
        </div>

        {{-- Empty state --}}
        <template x-if="items.length === 0">
            <div class="text-center py-24">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-muted/20 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <h2 class="text-xl font-semibold text-white mb-2">Tu carrito está vacío</h2>
                <p class="text-muted/60 mb-6">Agrega productos para comenzar tu compra</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-secondary hover:bg-secondary/90 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                    Explorar lentes
                </a>
            </div>
        </template>

        {{-- Cart with items --}}
        <template x-if="items.length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Items list (2/3) --}}
                <div class="lg:col-span-2 space-y-1">
                    {{-- Table header (desktop) --}}
                    <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs uppercase tracking-wider text-muted/60 border-b border-border">
                        <div class="col-span-6">Producto</div>
                        <div class="col-span-2 text-center">Precio</div>
                        <div class="col-span-2 text-center">Cantidad</div>
                        <div class="col-span-2 text-right">Total</div>
                    </div>

                    {{-- Items --}}
                    <template x-for="item in items" :key="item.key">
                        <div class="grid grid-cols-12 gap-4 items-center px-4 py-5 border-b border-border/40 group hover:bg-card/30 transition-colors rounded-lg">
                            <div class="col-span-12 md:col-span-6 flex gap-4">
                                <div class="w-20 h-20 md:w-24 md:h-24 rounded-xl overflow-hidden bg-card flex-shrink-0">
                                    <template x-if="item.image">
                                        <img :src="'/storage/' + item.image" :alt="item.name" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.image">
                                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-secondary/25" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                                            </svg>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex flex-col justify-center min-w-0">
                                    <a :href="'/lentes/' + item.slug" class="text-sm font-medium text-white hover:text-secondary transition-colors line-clamp-2" x-text="item.name"></a>
                                    <p x-show="item.variant" class="text-xs text-muted mt-1" x-text="item.variant"></p>
                                    <p class="md:hidden text-sm text-secondary font-semibold mt-1" x-text="'$' + fmt(item.unit_price)"></p>
                                </div>
                            </div>
                            <div class="hidden md:flex col-span-2 justify-center">
                                <span class="text-sm text-white" x-text="'$' + fmt(item.unit_price)"></span>
                            </div>
                            <div class="col-span-8 md:col-span-2 flex justify-start md:justify-center">
                                <div class="flex items-center border border-border rounded-lg overflow-hidden">
                                    <button @click="updateQty(item.key, item.qty - 1)" class="w-9 h-9 flex items-center justify-center text-muted hover:text-white hover:bg-card transition-all text-sm">−</button>
                                    <span class="w-10 h-9 flex items-center justify-center text-sm text-white border-x border-border bg-card/30" x-text="item.qty"></span>
                                    <button @click="updateQty(item.key, item.qty + 1)" class="w-9 h-9 flex items-center justify-center text-muted hover:text-white hover:bg-card transition-all text-sm">+</button>
                                </div>
                            </div>
                            <div class="col-span-4 md:col-span-2 flex items-center justify-end gap-3">
                                <span class="text-sm font-semibold text-white" x-text="'$' + fmt(item.total)"></span>
                                <button @click="removeItem(item.key)" class="text-muted/40 hover:text-red-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    {{-- 2x1 Banner --}}
                    <template x-if="free_items.length > 0">
                        <div style="border:1px dashed #B5D4F4;border-radius:8px;padding:12px 16px;background:#EBF4FF;margin:12px 4px;display:flex;align-items:center;gap:10px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;">
                                <path d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" stroke="#185FA5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div>
                                <p style="font-size:13px;font-weight:600;color:#185FA5;margin:0;">¡2×1 aplicado!</p>
                                <p style="font-size:12px;color:#378ADD;margin:0;" x-text="free_items.join(', ') + ' — va sin costo'"></p>
                            </div>
                        </div>
                    </template>

                    {{-- Toallitas suggestion --}}
                    <template x-if="!items.some(i => i.type === 'toallitas') && toallitasData.length > 0">
                        <div style="border-top:1px solid rgba(255,255,255,0.08);padding:16px 4px 0;margin-top:8px;">
                            <p style="font-size:12px;font-weight:500;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;">
                                Complementa tu compra
                            </p>
                            <template x-for="t in toallitasData" :key="t.id">
                                <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:0.5px solid rgba(255,255,255,0.06);">
                                    <div style="width:48px;height:48px;flex-shrink:0;border-radius:8px;background:linear-gradient(135deg,#2d1a0d,#6e3d1a);display:flex;align-items:center;justify-content:center;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <rect x="4" y="7" width="16" height="12" rx="2" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                                            <path d="M8 11h8M8 14h5" stroke="rgba(255,255,255,0.5)" stroke-width="1.2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <p style="font-size:13px;font-weight:500;color:#fff;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" x-text="t.name"></p>
                                        <p style="font-size:12px;color:rgba(255,255,255,0.5);margin:0;" x-text="'$' + fmt(t.price)"></p>
                                    </div>
                                    <button @click="addToallita(t.id)"
                                            style="flex-shrink:0;padding:6px 12px;background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.15);border-radius:6px;font-size:12px;cursor:pointer;transition:all .2s;font-family:inherit;"
                                            onmouseover="this.style.background='#378ADD';this.style.borderColor='#378ADD'"
                                            onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.15)'">
                                        + Agregar
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                {{-- Summary sidebar (1/3) --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 bg-card/50 border border-border rounded-2xl p-6 space-y-4">
                        <h2 class="font-brand text-lg font-semibold text-white">Resumen del pedido</h2>

                        <div class="space-y-3 text-sm">
                            {{-- Subtotal --}}
                            <div class="flex justify-between">
                                <span class="text-muted">Subtotal</span>
                                <span class="text-white" x-text="'$' + fmt(subtotal)"></span>
                            </div>

                            {{-- 2x1 discount --}}
                            <template x-if="discount_2x1 > 0">
                                <div class="flex justify-between">
                                    <span style="color:#4ade80;">Descuento 2×1</span>
                                    <span style="color:#4ade80;" x-text="'-$' + fmt(discount_2x1)"></span>
                                </div>
                            </template>

                            {{-- Shipping --}}
                            <div class="flex justify-between">
                                <span class="text-muted">Envío</span>
                                <span x-text="shipping === 0 ? '¡GRATIS!' : '$' + fmt(shipping)"
                                      :style="shipping === 0 ? 'color:#4ade80;font-weight:600;' : 'color:#fff;'"></span>
                            </div>

                            {{-- Shipping progress bar --}}
                            <template x-if="(subtotal - discount_2x1) < 999 && (subtotal - discount_2x1) > 0">
                                <div style="padding:10px 14px;background:rgba(255,255,255,0.05);border-radius:8px;">
                                    <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px;">
                                        <span style="color:rgba(255,255,255,0.5);">Envío gratis</span>
                                        <span style="color:#378ADD;font-weight:500;" x-text="'$' + fmt(999 - (subtotal - discount_2x1)) + ' más'"></span>
                                    </div>
                                    <div style="background:rgba(255,255,255,0.1);border-radius:2px;height:4px;overflow:hidden;">
                                        <div style="background:#378ADD;height:100%;border-radius:2px;transition:width .3s ease;"
                                             :style="'width:' + Math.min(((subtotal - discount_2x1) / 999) * 100, 100) + '%'"></div>
                                    </div>
                                </div>
                            </template>

                            {{-- Free shipping achieved --}}
                            <template x-if="(subtotal - discount_2x1) >= 999">
                                <div style="text-align:center;font-size:13px;color:#4ade80;background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.2);border-radius:8px;padding:8px 14px;">
                                    ✓ ¡Envío gratis aplicado!
                                </div>
                            </template>
                        </div>

                        {{-- Total --}}
                        <div class="border-t border-border pt-4 flex justify-between items-center">
                            <span class="text-base font-semibold text-white">Total</span>
                            <span class="text-xl font-bold text-secondary" x-text="'$' + fmt(total)"></span>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                           class="block w-full bg-secondary hover:bg-secondary/90 text-white text-center py-3.5 rounded-xl font-medium transition-colors">
                            Finalizar compra
                        </a>

                        {{-- Trust badges --}}
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div class="flex items-center gap-2 text-xs text-muted/60">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary/60 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                                Pago seguro
                            </div>
                            <div class="flex items-center gap-2 text-xs text-muted/60">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary/60 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0H6.375c-.621 0-1.125-.504-1.125-1.125V11.25m16.5 0c0-.621-.504-1.125-1.125-1.125h-2.25c-.621 0-1.125.504-1.125 1.125m3.375 0V7.5a.75.75 0 0 0-.75-.75H17.25a.75.75 0 0 0-.75.75v3.75" />
                                </svg>
                                Envío rápido
                            </div>
                            <div class="flex items-center gap-2 text-xs text-muted/60">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary/60 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                                </svg>
                                Devolución fácil
                            </div>
                            <div class="flex items-center gap-2 text-xs text-muted/60">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary/60 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456Z" />
                                </svg>
                                Garantía 6 meses
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</section>
@endsection

@push('scripts')
@php
    $toallitasJson = \App\Models\Product::active()->where('type', 'toallitas')->get()->map(function($t) {
        return ['id' => $t->id, 'name' => $t->name, 'slug' => $t->slug, 'price' => $t->price, 'image' => $t->images[0] ?? null];
    })->values();
@endphp

<script>
function cartPage() {
    return {
        items: @json($items),
        subtotal: {{ $subtotal }},
        discount_2x1: {{ $discount_2x1 }},
        free_items: @json($free_items),
        shipping: {{ $shipping }},
        total: {{ $total }},
        toallitasData: @json($toallitasJson),

        fmt(n) {
            return Number(n).toLocaleString('es-MX', { minimumFractionDigits: 2 });
        },

        updateBadge(count) {
            const badge = document.getElementById('cart-count');
            if (badge) {
                badge.textContent = count;
                badge.classList.toggle('scale-0', count === 0);
                badge.classList.toggle('scale-100', count > 0);
            }
        },

        syncFromResponse(data) {
            if (data.items) this.items = data.items;
            if (data.subtotal !== undefined) this.subtotal = data.subtotal;
            if (data.discount_2x1 !== undefined) this.discount_2x1 = data.discount_2x1;
            if (data.free_items !== undefined) this.free_items = data.free_items;
            if (data.shipping !== undefined) this.shipping = data.shipping;
            if (data.total !== undefined) this.total = data.total;
            this.updateBadge(data.cart_count ?? this.items.reduce((s, i) => s + i.qty, 0));
        },

        async updateQty(key, qty) {
            if (qty < 0) return;
            if (qty === 0) return this.removeItem(key);
            try {
                const res = await fetch(`/carrito/actualizar/${key}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ qty }),
                });
                const data = await res.json();
                if (res.ok) this.syncFromResponse(data);
            } catch (e) { console.error('Error updating cart:', e); }
        },

        async removeItem(key) {
            try {
                const res = await fetch(`/carrito/eliminar/${key}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                });
                const data = await res.json();
                if (res.ok) this.syncFromResponse(data);
            } catch (e) { console.error('Error removing item:', e); }
        },

        async addToallita(id) {
            try {
                const res = await fetch('/carrito/agregar', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ product_id: id, qty: 1 }),
                });
                const data = await res.json();
                if (res.ok) this.syncFromResponse(data);
            } catch (e) { console.error('Error adding toallita:', e); }
        },
    };
}
</script>
@endpush
