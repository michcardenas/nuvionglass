<header class="sticky top-0 z-50 bg-bg/95 backdrop-blur-sm border-b border-border">
    <nav x-data="{ mobileMenuOpen: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <span class="font-brand text-2xl text-secondary tracking-wide">nuvion</span>
                <span class="font-brand text-xs text-muted uppercase tracking-[0.3em]">glass</span>
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
                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative text-muted hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    @if(session('cart_count', 0) > 0)
                        <span class="absolute -top-2 -right-2 bg-secondary text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{ session('cart_count', 0) }}
                        </span>
                    @endif
                </a>

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
                <a href="{{ route('cart.index') }}" class="block text-muted hover:text-white transition-colors">Carrito</a>
            </div>
        </div>
    </nav>
</header>
