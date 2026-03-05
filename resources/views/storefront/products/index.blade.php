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
            {{-- Breadcrumb --}}
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
         Category filters + product grid
         ============================================================ --}}
    <section class="py-12 md:py-16 bg-bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Filters toolbar --}}
            <div class="mb-10 space-y-5" x-data="{ filtersOpen: false }">

                {{-- Row 1: Category pills + sort + toggle filters --}}
                <div class="flex flex-wrap items-center justify-between gap-4">
                    {{-- Category pills --}}
                    <div class="flex flex-wrap items-center gap-2 md:gap-3">
                        <a href="{{ route('products.index', request()->except(['categoria', 'page'])) }}"
                           class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                                  {{ !$currentCategory
                                      ? 'bg-secondary text-white shadow-md shadow-secondary/25'
                                      : 'bg-white text-text-muted border border-border-light hover:border-secondary/30 hover:text-secondary' }}">
                            Todos
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('products.index', array_merge(request()->except(['page']), ['categoria' => $category->slug])) }}"
                           class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                                  {{ $currentCategory === $category->slug
                                      ? 'bg-secondary text-white shadow-md shadow-secondary/25'
                                      : 'bg-white text-text-muted border border-border-light hover:border-secondary/30 hover:text-secondary' }}">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>

                    {{-- Sort + filter toggle --}}
                    <div class="flex items-center gap-3">
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

                        {{-- Filter toggle button --}}
                        <button @click="filtersOpen = !filtersOpen"
                                class="flex items-center gap-2 bg-white border border-border-light rounded-xl px-4 py-2.5 text-sm text-text-muted hover:border-secondary/30 transition-colors"
                                :class="filtersOpen && 'border-secondary/40 text-secondary'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/></svg>
                            Filtros
                            @if(request('precio_min') || request('precio_max') || request('disponible') || request('oferta'))
                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                            @endif
                        </button>
                    </div>
                </div>

                {{-- Row 2: Collapsible filter panel --}}
                <div x-show="filtersOpen" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2">
                    <form action="{{ route('products.index') }}" method="GET"
                          class="bg-white rounded-2xl border border-border-light p-5 md:p-6 shadow-sm">
                        {{-- Preserve existing query params --}}
                        @if($currentCategory)
                        <input type="hidden" name="categoria" value="{{ $currentCategory }}">
                        @endif
                        @if($currentSort !== 'destacados')
                        <input type="hidden" name="orden" value="{{ $currentSort }}">
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 items-end">
                            {{-- Price min --}}
                            <div>
                                <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">Precio mínimo</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted/50 text-sm">$</span>
                                    <input type="number" name="precio_min" step="0.01" min="0"
                                           value="{{ request('precio_min') }}"
                                           placeholder="{{ number_format($priceRange->min_price ?? 0, 0) }}"
                                           class="w-full pl-7 pr-3 py-2.5 rounded-xl border border-border-light text-sm text-text-dark
                                                  focus:outline-none focus:border-secondary/50 focus:ring-2 focus:ring-secondary/10 transition-colors">
                                </div>
                            </div>

                            {{-- Price max --}}
                            <div>
                                <label class="block text-xs font-semibold text-text-muted uppercase tracking-wider mb-2">Precio máximo</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted/50 text-sm">$</span>
                                    <input type="number" name="precio_max" step="0.01" min="0"
                                           value="{{ request('precio_max') }}"
                                           placeholder="{{ number_format($priceRange->max_price ?? 999, 0) }}"
                                           class="w-full pl-7 pr-3 py-2.5 rounded-xl border border-border-light text-sm text-text-dark
                                                  focus:outline-none focus:border-secondary/50 focus:ring-2 focus:ring-secondary/10 transition-colors">
                                </div>
                            </div>

                            {{-- Checkboxes --}}
                            <div class="flex flex-col gap-3">
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="checkbox" name="disponible" value="1"
                                           {{ request('disponible') ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-border-light text-secondary focus:ring-secondary/30">
                                    <span class="text-sm text-text-muted group-hover:text-text-dark transition-colors">Solo disponibles</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="checkbox" name="oferta" value="1"
                                           {{ request('oferta') ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-border-light text-secondary focus:ring-secondary/30">
                                    <span class="text-sm text-text-muted group-hover:text-text-dark transition-colors">Solo en oferta</span>
                                </label>
                            </div>

                            {{-- Buttons --}}
                            <div class="flex items-center gap-3">
                                <button type="submit"
                                        class="flex-1 bg-secondary hover:bg-secondary/90 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                    Aplicar
                                </button>
                                <a href="{{ route('products.index', $currentCategory ? ['categoria' => $currentCategory] : []) }}"
                                   class="px-5 py-2.5 rounded-xl text-sm font-semibold text-text-muted border border-border-light hover:border-danger/30 hover:text-danger transition-colors">
                                    Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Active filters summary --}}
                @if(request('precio_min') || request('precio_max') || request('disponible') || request('oferta'))
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs text-text-muted font-medium">Filtros activos:</span>
                    @if(request('precio_min'))
                    <a href="{{ route('products.index', request()->except(['precio_min', 'page'])) }}"
                       class="inline-flex items-center gap-1 bg-secondary/10 text-secondary text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-secondary/20 transition-colors">
                        Desde ${{ request('precio_min') }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
                    </a>
                    @endif
                    @if(request('precio_max'))
                    <a href="{{ route('products.index', request()->except(['precio_max', 'page'])) }}"
                       class="inline-flex items-center gap-1 bg-secondary/10 text-secondary text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-secondary/20 transition-colors">
                        Hasta ${{ request('precio_max') }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
                    </a>
                    @endif
                    @if(request('disponible'))
                    <a href="{{ route('products.index', request()->except(['disponible', 'page'])) }}"
                       class="inline-flex items-center gap-1 bg-success/10 text-success text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-success/20 transition-colors">
                        Disponibles
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
                    </a>
                    @endif
                    @if(request('oferta'))
                    <a href="{{ route('products.index', request()->except(['oferta', 'page'])) }}"
                       class="inline-flex items-center gap-1 bg-danger/10 text-danger text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-danger/20 transition-colors">
                        En oferta
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
                    </a>
                    @endif
                </div>
                @endif

            </div>

            {{-- Product grid --}}
            @if($products->count())
            <p class="text-sm text-text-muted mb-6">
                {{ $products->total() }} {{ $products->total() === 1 ? 'producto encontrado' : 'productos encontrados' }}
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
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
                   style="transition-delay: {{ $index * 100 }}ms">

                    {{-- Image --}}
                    <div class="relative aspect-[4/3] bg-bg-light flex items-center justify-center overflow-hidden">
                        @if($firstImage)
                        <img src="{{ asset('storage/' . $firstImage) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                             loading="lazy">
                        @else
                        <div class="flex flex-col items-center gap-2 text-text-muted/30">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/></svg>
                            <span class="text-xs font-medium">{{ $product->name }}</span>
                        </div>
                        @endif

                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if($product->is_featured)
                            <span class="bg-secondary text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                Destacado
                            </span>
                            @endif
                            @if($discount)
                            <span class="bg-danger text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                -{{ $discount }}%
                            </span>
                            @endif
                        </div>

                        {{-- Out of stock overlay --}}
                        @if($product->stock <= 0)
                        <div class="absolute inset-0 bg-white/70 flex items-center justify-center">
                            <span class="bg-text-dark text-white text-sm font-semibold px-4 py-2 rounded-full">Agotado</span>
                        </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="p-5 md:p-6">
                        {{-- Category --}}
                        @if($product->category)
                        <span class="text-xs font-medium text-secondary uppercase tracking-wider">
                            {{ $product->category->name }}
                        </span>
                        @endif

                        <h3 class="mt-1 font-brand text-lg font-semibold text-text-dark group-hover:text-secondary transition-colors duration-200">
                            {{ $product->name }}
                        </h3>

                        <p class="mt-1.5 text-sm text-text-muted leading-relaxed line-clamp-2">
                            {{ Str::limit($product->description, 90) }}
                        </p>

                        {{-- Price + CTA --}}
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-bold text-primary">${{ number_format($product->price, 2) }}</span>
                                @if($product->compare_price)
                                <span class="text-sm text-text-muted/60 line-through">${{ number_format($product->compare_price, 2) }}</span>
                                @endif
                            </div>
                            <span class="bg-primary group-hover:bg-primary-light text-white px-5 py-2.5 rounded-xl text-sm font-semibold
                                         transition-all duration-200 group-hover:-translate-y-0.5 group-hover:shadow-md group-hover:shadow-primary/20">
                                Ver detalle
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @endif

            @else
            {{-- Empty state --}}
            <div class="text-center py-20">
                <div class="w-16 h-16 mx-auto bg-secondary/10 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                </div>
                <h3 class="font-brand text-xl font-semibold text-text-dark">No encontramos productos</h3>
                <p class="mt-2 text-text-muted">No hay productos en esta categoría por el momento.</p>
                <a href="{{ route('products.index') }}"
                   class="mt-6 inline-flex items-center gap-2 bg-secondary hover:bg-secondary/90 text-white px-6 py-3 rounded-xl font-semibold text-sm transition-colors">
                    Ver todos los lentes
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            @endif

        </div>
    </section>

@endsection
