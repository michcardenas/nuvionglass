<header class="sticky top-0 z-50 bg-bg/95 backdrop-blur-sm border-b border-border">
    <nav x-data="{ mobileMenuOpen: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5">
                <img src="{{ asset('img/isotipo.png') }}" alt="nuvion - glass" class="h-9 w-9 object-contain">
                <div class="flex items-baseline space-x-1.5">
                    <span class="font-brand text-2xl text-secondary tracking-wide">nuvion</span>
                    <span class="font-brand text-xs text-muted uppercase tracking-[0.3em]">glass</span>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-sm text-muted hover:text-white transition-colors {{ request()->routeIs('home') ? '!text-white' : '' }}">Inicio</a>
                <a href="{{ route('products.index') }}" class="text-sm text-muted hover:text-white transition-colors {{ request()->routeIs('products.*') ? '!text-white' : '' }}">Lentes</a>
                <a href="{{ route('blue-light') }}" class="text-sm text-muted hover:text-white transition-colors {{ request()->routeIs('blue-light') ? '!text-white' : '' }}">Luz Azul</a>
                <a href="{{ route('blog.index') }}" class="text-sm text-muted hover:text-white transition-colors {{ request()->routeIs('blog.*') ? '!text-white' : '' }}">Blog</a>
            </div>

            {{-- Cart + Mobile toggle --}}
            <div class="flex items-center space-x-4">
                {{-- Cart button --}}
                <button @click="$dispatch('toggle-cart-drawer')" class="relative text-muted hover:text-white transition-colors" id="cart-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <span id="cart-count"
                          class="absolute -top-2 -right-2 bg-secondary text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center transition-transform {{ $cartCount > 0 ? 'scale-100' : 'scale-0' }}">
                        {{ $cartCount }}
                    </span>
                </button>

                {{-- Mobile menu button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-muted hover:text-white">
                    <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-border">
            <div class="py-4 space-y-3">
                <a href="{{ route('home') }}" class="block text-muted hover:text-white transition-colors">Inicio</a>
                <a href="{{ route('products.index') }}" class="block text-muted hover:text-white transition-colors">Lentes</a>
                <a href="{{ route('blue-light') }}" class="block text-muted hover:text-white transition-colors">Luz Azul</a>
                <a href="{{ route('blog.index') }}" class="block text-muted hover:text-white transition-colors">Blog</a>
                <button @click="$dispatch('toggle-cart-drawer'); mobileMenuOpen = false" class="block text-muted hover:text-white transition-colors">Carrito</button>
            </div>
        </div>
    </nav>
</header>

{{-- Cart Drawer --}}
<div x-data="cartDrawer()" x-cloak
     @toggle-cart-drawer.window="toggle()"
     @open-cart-drawer.window="open($event.detail)"
     class="fixed inset-0 z-[60]"
     x-show="isOpen">

    {{-- Backdrop --}}
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="close()"
         class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    {{-- Drawer Panel --}}
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="absolute top-0 right-0 h-full w-full max-w-md bg-bg border-l border-border shadow-2xl flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-border">
            <h2 class="font-brand text-lg font-semibold text-white">Tu carrito</h2>
            <button @click="close()" class="text-muted hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Items --}}
        <div class="flex-1 overflow-y-auto px-6 py-4">
            {{-- Empty state --}}
            <template x-if="items.length === 0">
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-muted/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <p class="text-muted/50 text-sm">Tu carrito está vacío</p>
                    <a href="{{ route('products.index') }}" class="mt-4 text-secondary hover:text-secondary/80 text-sm font-medium transition-colors">
                        Explorar lentes →
                    </a>
                </div>
            </template>

            {{-- Cart items --}}
            <template x-for="item in items" :key="item.key">
                <div class="flex gap-4 py-4 border-b border-border/50 last:border-0">
                    {{-- Image --}}
                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-card flex-shrink-0">
                        <template x-if="item.image">
                            <img :src="'/storage/' + item.image" :alt="item.name" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!item.image">
                            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                                </svg>
                            </div>
                        </template>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <a :href="'/lentes/' + item.slug" class="text-sm font-medium text-white hover:text-secondary transition-colors line-clamp-1" x-text="item.name"></a>
                        <p x-show="item.variant" class="text-xs text-muted mt-0.5" x-text="item.variant"></p>
                        <p class="text-sm text-secondary font-semibold mt-1" x-text="'$' + Number(item.unit_price).toLocaleString('es-MX', {minimumFractionDigits: 2})"></p>

                        {{-- Qty controls --}}
                        <div class="flex items-center gap-2 mt-2">
                            <button @click="updateQty(item.key, item.qty - 1)"
                                    class="w-7 h-7 rounded-md bg-card border border-border text-muted hover:text-white hover:border-secondary/50 transition-all flex items-center justify-center text-sm">
                                −
                            </button>
                            <span class="text-sm text-white w-6 text-center" x-text="item.qty"></span>
                            <button @click="updateQty(item.key, item.qty + 1)"
                                    class="w-7 h-7 rounded-md bg-card border border-border text-muted hover:text-white hover:border-secondary/50 transition-all flex items-center justify-center text-sm">
                                +
                            </button>
                            <button @click="removeItem(item.key)"
                                    class="ml-auto text-muted/50 hover:text-red-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Footer: Totals + CTA --}}
        <template x-if="items.length > 0">
            <div class="border-t border-border px-6 py-4 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-muted">Subtotal</span>
                    <span class="text-white" x-text="'$' + Number(subtotal).toLocaleString('es-MX', {minimumFractionDigits: 2})"></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-muted">Envío</span>
                    <span class="text-white" x-text="shipping === 0 ? 'Gratis' : '$' + Number(shipping).toLocaleString('es-MX', {minimumFractionDigits: 2})"></span>
                </div>
                <div class="flex justify-between text-base font-semibold pt-2 border-t border-border/50">
                    <span class="text-white">Total</span>
                    <span class="text-secondary" x-text="'$' + Number(total).toLocaleString('es-MX', {minimumFractionDigits: 2})"></span>
                </div>

                <a href="{{ route('checkout.index') }}"
                   class="block w-full bg-secondary hover:bg-secondary/90 text-white text-center py-3 rounded-lg font-medium transition-colors mt-2">
                    Finalizar compra
                </a>
                <a href="{{ route('cart.index') }}"
                   class="block w-full text-center text-sm text-muted hover:text-white transition-colors py-2">
                    Ver carrito completo
                </a>
            </div>
        </template>
    </div>
</div>

<script>
function cartDrawer() {
    return {
        isOpen: false,
        items: @json($cartItemsJson),
        subtotal: {{ $cartSubtotal }},
        shipping: {{ $cartShipping }},
        total: {{ $cartTotal }},

        open(data) {
            if (data) this.syncFromResponse(data);
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },

        close() {
            this.isOpen = false;
            document.body.style.overflow = '';
        },

        toggle() {
            this.isOpen ? this.close() : this.open();
        },

        syncFromResponse(data) {
            if (data.items) this.items = data.items;
            if (data.subtotal !== undefined) this.subtotal = data.subtotal;
            if (data.shipping !== undefined) this.shipping = data.shipping;
            if (data.total !== undefined) this.total = data.total;
            this.updateBadge(data.cart_count ?? this.items.reduce((s, i) => s + i.qty, 0));
        },

        updateBadge(count) {
            const badge = document.getElementById('cart-count');
            if (badge) {
                badge.textContent = count;
                badge.classList.toggle('scale-0', count === 0);
                badge.classList.toggle('scale-100', count > 0);
            }
        },

        async updateQty(key, qty) {
            if (qty < 0) return;
            if (qty === 0) return this.removeItem(key);

            try {
                const res = await fetch(`/carrito/actualizar/${key}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ qty }),
                });
                const data = await res.json();
                if (res.ok) this.syncFromResponse(data);
            } catch (e) {
                console.error('Error updating cart:', e);
            }
        },

        async removeItem(key) {
            try {
                const res = await fetch(`/carrito/eliminar/${key}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });
                const data = await res.json();
                if (res.ok) this.syncFromResponse(data);
            } catch (e) {
                console.error('Error removing item:', e);
            }
        },
    };
}
</script>
