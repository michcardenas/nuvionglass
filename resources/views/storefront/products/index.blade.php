@extends('layouts.app')

@section('title', 'Lentes con protección de luz azul | nuvion - glass')
@section('meta_description', 'Catálogo completo de lentes nuvion glass con protección de luz azul. Con y sin graduación. Envío gratis.')
@section('canonical', route('products.index'))
@section('og_title', 'Lentes con protección de luz azul | nuvion - glass')
@section('og_description', 'Catálogo completo de lentes nuvion glass con protección de luz azul. Con y sin graduación.')
@section('twitter_title', 'Lentes con protección de luz azul | nuvion - glass')
@section('twitter_description', 'Catálogo completo de lentes nuvion glass con protección de luz azul. Con y sin graduación.')

@push('schema')
    {!! $breadcrumbs !!}
@endpush

@section('content')

    {{-- ============================================================
         Page header — dark banner
         ============================================================ --}}
    <section class="relative bg-bg overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-secondary/5 to-transparent pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-12 md:pt-14 md:pb-16">
            <nav class="flex items-center gap-2 text-sm text-muted/50 mb-6 anim-fade-up">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Inicio</a>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                <span class="text-white/80">Lentes</span>
            </nav>
            <h1 class="font-brand text-3xl md:text-4xl lg:text-5xl font-bold text-white anim-fade-up delay-100">
                Nuestros lentes
            </h1>
            <p class="mt-3 text-base md:text-lg text-muted/70 max-w-xl anim-fade-up delay-200">
                Encuentra el nuvion perfecto para ti. Todos con protección de luz azul certificada.
            </p>
        </div>
    </section>

    {{-- ============================================================
         Sidebar filters + product grid
         ============================================================ --}}
    <section class="py-10 md:py-14 bg-bg-light" x-data="productFilters()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-8">

                {{-- ======================== LEFT SIDEBAR ======================== --}}
                <aside class="hidden lg:block w-72 shrink-0">
                    <div class="sticky top-24 space-y-6">

                        {{-- Categories --}}
                        <div class="bg-white rounded-2xl border border-border-light p-5 shadow-sm">
                            <h3 class="text-xs font-bold text-text-dark uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6h.008v.008H6V6Z"/></svg>
                                Categorías
                            </h3>
                            <div class="space-y-1">
                                <a href="{{ route('products.index', request()->except(['categoria', 'page'])) }}"
                                   class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                                          {{ !$currentCategory ? 'bg-secondary/10 text-secondary font-semibold' : 'text-text-muted hover:bg-bg-light hover:text-text-dark' }}">
                                    <span>Todos los lentes</span>
                                </a>
                                @foreach($categories as $category)
                                <a href="{{ route('products.index', array_merge(request()->except(['page']), ['categoria' => $category->slug])) }}"
                                   class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                                          {{ $currentCategory === $category->slug ? 'bg-secondary/10 text-secondary font-semibold' : 'text-text-muted hover:bg-bg-light hover:text-text-dark' }}">
                                    <span>{{ $category->name }}</span>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price range --}}
                        <div class="bg-white rounded-2xl border border-border-light p-5 shadow-sm">
                            <h3 class="text-xs font-bold text-text-dark uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                Precio
                            </h3>
                            <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
                                @if($currentCategory)
                                <input type="hidden" name="categoria" value="{{ $currentCategory }}">
                                @endif
                                @if($currentSort !== 'destacados')
                                <input type="hidden" name="orden" value="{{ $currentSort }}">
                                @endif
                                @if(request('disponible'))
                                <input type="hidden" name="disponible" value="1">
                                @endif
                                @if(request('oferta'))
                                <input type="hidden" name="oferta" value="1">
                                @endif

                                <div class="flex items-center gap-3">
                                    <div class="relative flex-1">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted/40 text-xs font-medium">$</span>
                                        <input type="number" name="precio_min" step="1" min="0"
                                               value="{{ request('precio_min') }}"
                                               placeholder="{{ number_format($priceRange->min_price ?? 0, 0) }}"
                                               class="w-full pl-6 pr-2 py-2 rounded-lg border border-border-light text-sm text-text-dark text-center
                                                      focus:outline-none focus:border-secondary/50 focus:ring-1 focus:ring-secondary/20 transition-colors">
                                    </div>
                                    <span class="text-text-muted/30 text-xs font-bold">—</span>
                                    <div class="relative flex-1">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted/40 text-xs font-medium">$</span>
                                        <input type="number" name="precio_max" step="1" min="0"
                                               value="{{ request('precio_max') }}"
                                               placeholder="{{ number_format($priceRange->max_price ?? 9999, 0) }}"
                                               class="w-full pl-6 pr-2 py-2 rounded-lg border border-border-light text-sm text-text-dark text-center
                                                      focus:outline-none focus:border-secondary/50 focus:ring-1 focus:ring-secondary/20 transition-colors">
                                    </div>
                                </div>

                                <button type="submit"
                                        class="w-full bg-secondary/10 hover:bg-secondary/20 text-secondary px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors">
                                    Aplicar precio
                                </button>
                            </form>
                        </div>

                        {{-- Availability --}}
                        <div class="bg-white rounded-2xl border border-border-light p-5 shadow-sm">
                            <h3 class="text-xs font-bold text-text-dark uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/></svg>
                                Filtros
                            </h3>
                            <div class="space-y-3">
                                <a href="{{ route('products.index', array_merge(request()->except(['disponible', 'page']), request('disponible') ? [] : ['disponible' => 1])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 group
                                          {{ request('disponible') ? 'bg-success/10 text-success font-semibold' : 'text-text-muted hover:bg-bg-light' }}">
                                    <span class="w-5 h-5 rounded-md border-2 flex items-center justify-center transition-colors
                                                {{ request('disponible') ? 'border-success bg-success' : 'border-border-light group-hover:border-text-muted/30' }}">
                                        @if(request('disponible'))
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                        @endif
                                    </span>
                                    En stock
                                </a>
                                <a href="{{ route('products.index', array_merge(request()->except(['oferta', 'page']), request('oferta') ? [] : ['oferta' => 1])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 group
                                          {{ request('oferta') ? 'bg-danger/10 text-danger font-semibold' : 'text-text-muted hover:bg-bg-light' }}">
                                    <span class="w-5 h-5 rounded-md border-2 flex items-center justify-center transition-colors
                                                {{ request('oferta') ? 'border-danger bg-danger' : 'border-border-light group-hover:border-text-muted/30' }}">
                                        @if(request('oferta'))
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                        @endif
                                    </span>
                                    En oferta
                                </a>
                            </div>
                        </div>

                        {{-- Clear all --}}
                        @if(request('precio_min') || request('precio_max') || request('disponible') || request('oferta') || $currentCategory)
                        <a href="{{ route('products.index') }}"
                           class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-semibold text-text-muted border border-border-light hover:border-danger/30 hover:text-danger hover:bg-danger/5 transition-all duration-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
                            Limpiar filtros
                        </a>
                        @endif

                    </div>
                </aside>

                {{-- ======================== MAIN CONTENT ======================== --}}
                <div class="flex-1 min-w-0">

                    {{-- Top bar --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                        <div class="flex items-center gap-3">
                            {{-- Mobile filter button --}}
                            <button @click="mobileOpen = true"
                                    class="lg:hidden flex items-center gap-2 bg-white border border-border-light rounded-xl px-4 py-2.5 text-sm text-text-muted hover:border-secondary/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/></svg>
                                Filtros
                                @if(request('precio_min') || request('precio_max') || request('disponible') || request('oferta'))
                                <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                @endif
                            </button>

                            <p class="text-sm text-text-muted">
                                <span class="font-semibold text-text-dark">{{ $products->total() }}</span>
                                {{ $products->total() === 1 ? 'producto' : 'productos' }}
                            </p>
                        </div>

                        {{-- Sort dropdown --}}
                        <div class="relative" x-data="{ sortOpen: false }">
                            <button @click="sortOpen = !sortOpen" @click.outside="sortOpen = false"
                                    class="flex items-center gap-2 bg-white border border-border-light rounded-xl px-4 py-2.5 text-sm text-text-muted hover:border-secondary/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/></svg>
                                <span>
                                    @switch($currentSort)
                                        @case('precio_asc') Menor precio @break
                                        @case('precio_desc') Mayor precio @break
                                        @case('recientes') Más recientes @break
                                        @case('nombre') Nombre A-Z @break
                                        @default Destacados
                                    @endswitch
                                </span>
                                <svg class="w-3.5 h-3.5 transition-transform" :class="sortOpen && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                            </button>
                            <div x-show="sortOpen" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl border border-border-light shadow-lg overflow-hidden z-20">
                                @php
                                $sortOptions = [
                                    'destacados'  => 'Destacados',
                                    'precio_asc'  => 'Menor precio',
                                    'precio_desc' => 'Mayor precio',
                                    'recientes'   => 'Más recientes',
                                    'nombre'      => 'Nombre A-Z',
                                ];
                                @endphp
                                @foreach($sortOptions as $value => $label)
                                <a href="{{ route('products.index', array_merge(request()->except(['page']), ['orden' => $value])) }}"
                                   class="block px-4 py-2.5 text-sm transition-colors
                                          {{ $currentSort === $value ? 'bg-secondary/10 text-secondary font-semibold' : 'text-text-muted hover:bg-bg-light' }}">
                                    {{ $label }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Active filter chips --}}
                    @if(request('precio_min') || request('precio_max') || request('disponible') || request('oferta'))
                    <div class="flex flex-wrap items-center gap-2 mb-6">
                        @if(request('precio_min'))
                        <a href="{{ route('products.index', request()->except(['precio_min', 'page'])) }}"
                           class="inline-flex items-center gap-1.5 bg-white border border-secondary/20 text-secondary text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-secondary/10 transition-colors">
                            Desde ${{ number_format(request('precio_min'), 0) }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
                        </a>
                        @endif
                        @if(request('precio_max'))
                        <a href="{{ route('products.index', request()->except(['precio_max', 'page'])) }}"
                           class="inline-flex items-center gap-1.5 bg-white border border-secondary/20 text-secondary text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-secondary/10 transition-colors">
                            Hasta ${{ number_format(request('precio_max'), 0) }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
                        </a>
                        @endif
                        @if(request('disponible'))
                        <a href="{{ route('products.index', request()->except(['disponible', 'page'])) }}"
                           class="inline-flex items-center gap-1.5 bg-white border border-success/20 text-success text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-success/10 transition-colors">
                            En stock
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
                        </a>
                        @endif
                        @if(request('oferta'))
                        <a href="{{ route('products.index', request()->except(['oferta', 'page'])) }}"
                           class="inline-flex items-center gap-1.5 bg-white border border-danger/20 text-danger text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-danger/10 transition-colors">
                            En oferta
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
                        </a>
                        @endif
                    </div>
                    @endif

                    {{-- Product grid --}}
                    @if($products->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-6">
                        @foreach($products as $index => $product)
                        @php
                            $firstImage = $product->images[0] ?? null;
                            $discount = $product->compare_price
                                ? round((1 - $product->price / $product->compare_price) * 100)
                                : null;
                        @endphp
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="reveal group bg-white rounded-2xl overflow-hidden border border-border-light
                                  hover:shadow-xl hover:shadow-secondary/10 hover:-translate-y-1.5 hover:border-secondary/30
                                  transition-all duration-300 block"
                           style="transition-delay: {{ $index * 80 }}ms">

                            {{-- Image --}}
                            <div class="relative aspect-[4/3] bg-bg-light overflow-hidden">
                                @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                                     loading="lazy">
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/5 to-secondary/10">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 mx-auto text-secondary/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                        <p class="mt-2 text-xs font-medium text-secondary/30">{{ $product->name }}</p>
                                    </div>
                                </div>
                                @endif

                                {{-- Badges --}}
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    @if($product->is_featured)
                                    <span class="bg-secondary text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">Destacado</span>
                                    @endif
                                    @if($discount)
                                    <span class="bg-danger text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">-{{ $discount }}%</span>
                                    @endif
                                </div>

                                @if($product->stock <= 0)
                                <div class="absolute inset-0 bg-white/70 flex items-center justify-center">
                                    <span class="bg-text-dark text-white text-sm font-semibold px-4 py-2 rounded-full">Agotado</span>
                                </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="p-5">
                                @if($product->category)
                                <span class="text-xs font-medium text-secondary uppercase tracking-wider">{{ $product->category->name }}</span>
                                @endif
                                <h3 class="mt-1 font-brand text-lg font-semibold text-text-dark group-hover:text-secondary transition-colors duration-200">
                                    {{ $product->name }}
                                </h3>
                                <p class="mt-1 text-sm text-text-muted leading-relaxed line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-xl font-bold text-primary">${{ number_format($product->price, 0, '.', ',') }}</span>
                                        @if($product->compare_price)
                                        <span class="text-sm text-text-muted/50 line-through">${{ number_format($product->compare_price, 0, '.', ',') }}</span>
                                        @endif
                                    </div>
                                    <span class="bg-primary group-hover:bg-primary-light text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider
                                                 transition-all duration-200 group-hover:-translate-y-0.5 group-hover:shadow-md group-hover:shadow-primary/20">
                                        Ver detalle
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    @if($products->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                    @endif

                    @else
                    <div class="text-center py-20">
                        <div class="w-16 h-16 mx-auto bg-secondary/10 rounded-2xl flex items-center justify-center mb-5">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                        </div>
                        <h3 class="font-brand text-xl font-semibold text-text-dark">No encontramos productos</h3>
                        <p class="mt-2 text-text-muted">Intenta cambiar los filtros o explora todas las categorías.</p>
                        <a href="{{ route('products.index') }}"
                           class="mt-6 inline-flex items-center gap-2 bg-secondary hover:bg-secondary/90 text-white px-6 py-3 rounded-xl font-semibold text-sm transition-colors">
                            Ver todos los lentes
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ======================== MOBILE FILTER DRAWER ======================== --}}
        <div x-show="mobileOpen" x-cloak class="fixed inset-0 z-50 lg:hidden">
            <div class="absolute inset-0 bg-black/50" @click="mobileOpen = false"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="absolute inset-y-0 left-0 w-80 max-w-[85vw] bg-white shadow-2xl overflow-y-auto"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

                <div class="sticky top-0 bg-white border-b border-border-light px-5 py-4 flex items-center justify-between z-10">
                    <h2 class="font-brand text-lg font-bold text-text-dark">Filtros</h2>
                    <button @click="mobileOpen = false" class="w-8 h-8 rounded-lg hover:bg-bg-light flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-5 space-y-6">
                    {{-- Categories --}}
                    <div>
                        <h3 class="text-xs font-bold text-text-dark uppercase tracking-wider mb-3">Categorías</h3>
                        <div class="space-y-1">
                            <a href="{{ route('products.index', request()->except(['categoria', 'page'])) }}"
                               class="flex items-center px-3 py-2.5 rounded-xl text-sm transition-all
                                      {{ !$currentCategory ? 'bg-secondary/10 text-secondary font-semibold' : 'text-text-muted hover:bg-bg-light' }}">
                                Todos los lentes
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('products.index', array_merge(request()->except(['page']), ['categoria' => $category->slug])) }}"
                               class="flex items-center px-3 py-2.5 rounded-xl text-sm transition-all
                                      {{ $currentCategory === $category->slug ? 'bg-secondary/10 text-secondary font-semibold' : 'text-text-muted hover:bg-bg-light' }}">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price --}}
                    <div>
                        <h3 class="text-xs font-bold text-text-dark uppercase tracking-wider mb-3">Precio</h3>
                        <form action="{{ route('products.index') }}" method="GET" class="space-y-3">
                            @if($currentCategory)<input type="hidden" name="categoria" value="{{ $currentCategory }}">@endif
                            @if($currentSort !== 'destacados')<input type="hidden" name="orden" value="{{ $currentSort }}">@endif
                            @if(request('disponible'))<input type="hidden" name="disponible" value="1">@endif
                            @if(request('oferta'))<input type="hidden" name="oferta" value="1">@endif
                            <div class="flex items-center gap-3">
                                <div class="relative flex-1">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted/40 text-xs">$</span>
                                    <input type="number" name="precio_min" value="{{ request('precio_min') }}" placeholder="Mín"
                                           class="w-full pl-6 pr-2 py-2 rounded-lg border border-border-light text-sm text-center focus:outline-none focus:border-secondary/50">
                                </div>
                                <span class="text-text-muted/30 text-xs">—</span>
                                <div class="relative flex-1">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted/40 text-xs">$</span>
                                    <input type="number" name="precio_max" value="{{ request('precio_max') }}" placeholder="Máx"
                                           class="w-full pl-6 pr-2 py-2 rounded-lg border border-border-light text-sm text-center focus:outline-none focus:border-secondary/50">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-secondary/10 hover:bg-secondary/20 text-secondary py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors">Aplicar</button>
                        </form>
                    </div>

                    {{-- Toggles --}}
                    <div>
                        <h3 class="text-xs font-bold text-text-dark uppercase tracking-wider mb-3">Disponibilidad</h3>
                        <div class="space-y-2">
                            <a href="{{ route('products.index', array_merge(request()->except(['disponible', 'page']), request('disponible') ? [] : ['disponible' => 1])) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
                                      {{ request('disponible') ? 'bg-success/10 text-success font-semibold' : 'text-text-muted hover:bg-bg-light' }}">
                                <span class="w-5 h-5 rounded-md border-2 flex items-center justify-center {{ request('disponible') ? 'border-success bg-success' : 'border-border-light' }}">
                                    @if(request('disponible'))<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m4.5 12.75 6 6 9-13.5"/></svg>@endif
                                </span>
                                En stock
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except(['oferta', 'page']), request('oferta') ? [] : ['oferta' => 1])) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
                                      {{ request('oferta') ? 'bg-danger/10 text-danger font-semibold' : 'text-text-muted hover:bg-bg-light' }}">
                                <span class="w-5 h-5 rounded-md border-2 flex items-center justify-center {{ request('oferta') ? 'border-danger bg-danger' : 'border-border-light' }}">
                                    @if(request('oferta'))<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m4.5 12.75 6 6 9-13.5"/></svg>@endif
                                </span>
                                En oferta
                            </a>
                        </div>
                    </div>

                    @if(request('precio_min') || request('precio_max') || request('disponible') || request('oferta') || $currentCategory)
                    <a href="{{ route('products.index') }}"
                       class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-semibold text-danger border border-danger/20 hover:bg-danger/5 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
                        Limpiar todos los filtros
                    </a>
                    @endif
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
<script>
function productFilters() {
    return { mobileOpen: false };
}
</script>
@endpush
