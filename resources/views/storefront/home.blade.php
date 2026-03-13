@extends('layouts.app')

@section('body_class', 'bg-bg-light text-text-dark')

@section('title', 'nuvion - glass | Protege tus ojos de la luz azul')
@section('meta_description', 'Lentes con protección de luz azul. Con o sin graduación. Diseño moderno que querrás usar todo el día. Envío gratis a todo México.')
@section('og_title', 'nuvion - glass | Lentes con protección de luz azul')
@section('og_description', 'Protege tus ojos de las pantallas. Lentes con filtro de luz azul, con o sin graduación. Envío gratis.')
@section('twitter_title', 'nuvion - glass | Lentes con protección de luz azul')
@section('twitter_description', 'Protege tus ojos de las pantallas. Lentes con filtro de luz azul, con o sin graduación. Envío gratis.')

@push('schema')
    {!! $organizationSchema !!}
    {!! $faqSchema !!}
@endpush

@section('content')

    {{-- ============================================================
         1. HERO — fondo oscuro #0A0E1A (fluye desde navbar)
         ============================================================ --}}
    <section class="relative bg-bg overflow-hidden"
             style="background: linear-gradient(135deg, #0A0E1A 0%, #001a40 50%, #0A0E1A 100%);
                    background-size: 200% 200%;
                    animation: gradientShift 10s ease infinite;">
        {{-- Glow decorativo --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-secondary/5 rounded-full blur-[120px] pointer-events-none"
             style="animation: pulseDot 6s ease-in-out infinite;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16 md:pt-16 md:pb-28 lg:pt-20 lg:pb-36">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Copy --}}
                <div class="order-2 lg:order-1">
                    <span class="inline-block text-secondary text-sm font-medium tracking-wider uppercase mb-4 anim-fade-up delay-100">Protección de luz azul</span>
                    {{-- Hero title — word-by-word cascade reveal --}}
                    <h1 class="font-brand text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.1]"
                        x-data="{ show: false }"
                        x-init="setTimeout(() => show = true, 250)">
                        <span class="hero-word-wrap"><span class="hero-word" :class="show && 'visible'" style="transition-delay: 0ms">Protege</span></span>
                        <span class="hero-word-wrap"><span class="hero-word" :class="show && 'visible'" style="transition-delay: 80ms">tus</span></span>
                        <span class="hero-word-wrap"><span class="hero-word" :class="show && 'visible'" style="transition-delay: 160ms">ojos</span></span>
                        <br>
                        <span class="hero-word-wrap"><span class="hero-word text-secondary" :class="show && 'visible'" style="transition-delay: 320ms">antes</span></span>
                        <span class="hero-word-wrap"><span class="hero-word text-secondary" :class="show && 'visible'" style="transition-delay: 400ms">de</span></span>
                        <span class="hero-word-wrap"><span class="hero-word text-secondary" :class="show && 'visible'" style="transition-delay: 480ms">que</span></span>
                        <span class="hero-word-wrap"><span class="hero-word text-secondary" :class="show && 'visible'" style="transition-delay: 560ms">sea</span></span>
                        <span class="hero-word-wrap"><span class="hero-word text-secondary" :class="show && 'visible'" style="transition-delay: 640ms">tarde</span></span>
                    </h1>
                    <p class="mt-6 text-base sm:text-lg text-muted/80 leading-relaxed max-w-lg anim-fade-up delay-300">
                        Lentes con protección de luz azul. Con o sin graduación. Diseño moderno que querrás usar todo el día.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 anim-fade-up delay-400">
                        <a href="{{ route('products.index') }}"
                           class="relative inline-flex items-center justify-center bg-secondary hover:bg-secondary/90 text-white px-8 py-3.5 rounded-xl font-semibold text-base transition-all duration-300 shadow-lg shadow-secondary/25 overflow-hidden
                                  hover:-translate-y-0.5 hover:shadow-xl hover:shadow-secondary/30 active:translate-y-0">
                            Ver lentes
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="{{ route('blue-light') }}"
                           class="inline-flex items-center justify-center border border-white/20 text-white/90 hover:bg-white/5 hover:border-white/40 px-8 py-3.5 rounded-xl font-medium text-base transition-colors">
                            ¿Qué es la luz azul?
                        </a>
                    </div>

                    {{-- Trust badges --}}
                    <div class="mt-10 flex flex-wrap items-center gap-6 text-sm text-muted/50 anim-fade-up delay-500">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                            <span>Envío gratis</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                            <span>Garantía 6 meses</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182"/></svg>
                            <span>30 días de devolución</span>
                        </div>
                    </div>
                </div>

                {{-- Imagen hero — scroll-driven gallery --}}
                @php
                $heroImages = [
                    'akz3gg94DYuehu11m3sBSaxjYLRAAGxT5fB6Cozk.png',
                    'EZT3BIVBQp25uDJC8kPeodhCCFMOzY0NsnGeRlEx.png',
                    'FtG9kU1bZCasQU1d9oZNWFc3JWBQsUOyVYPmuTSA.png',
                    'jZr0I7SxOBaqj5jECAuIMUbLLLfOOwpkhsqNQhLD.png',
                    'MPBPzKsunt1kCCL6QztOnsoY1lCVmgkn9bvOkVeG.png',
                    'oCAQWUGek3EklYHH6h9KCLYTNmLO0depaUtkIFjX.png',
                    'RiK57MpLZZxIxSIH5BKhXcABKyr9uy5aciKIevrD.png',
                    'rnCKGK5KfSxtaTp9fvZhuqiVJ0C0ye7REm2b7A3v.png',
                ];
                @endphp
                <div class="order-1 lg:order-2 flex justify-center anim-fade-right delay-300">
                    <div class="relative w-full max-w-md lg:max-w-lg aspect-square rounded-3xl bg-gradient-to-br from-secondary/10 to-primary/10 border border-white/5 flex items-center justify-center anim-float overflow-hidden"
                         x-data="heroGallery()"
                         @scroll.window.throttle.50ms="onScroll()">
                        @foreach($heroImages as $i => $img)
                        <img src="{{ asset('storage/products/' . $img) }}"
                             alt="nuvion glass producto {{ $i + 1 }}"
                             class="absolute inset-0 w-full h-full object-contain transition-opacity duration-500"
                             :class="current === {{ $i }} ? 'opacity-100' : 'opacity-0'">
                        @endforeach
                        {{-- Decorative ring --}}
                        <div class="absolute -inset-4 rounded-full border border-secondary/10 pointer-events-none"
                             style="animation: pulseDot 4s ease-in-out infinite;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         2. EDUCACIÓN RÁPIDA — ¿Qué es la luz azul?
         Fondo claro #F4F6F9
         ============================================================ --}}
    <section class="py-16 md:py-24 bg-bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Ilustración / gráfico — carrusel de infografías --}}
                <div class="relative" x-data="{ current: 0, total: {{ $infographics->count() ?: 1 }} }" x-reveal.once>
                    @if($infographics->count())
                    <div class="relative aspect-video rounded-2xl bg-white border border-border-light shadow-sm overflow-hidden">
                        @foreach($infographics as $i => $infographic)
                        <div class="absolute inset-0 transition-opacity duration-500"
                             :class="current === {{ $i }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                            <img src="{{ asset('storage/' . $infographic->image) }}"
                                 alt="{{ $infographic->title }}"
                                 class="w-full h-full object-cover"
                                 loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                            @if($infographic->title || $infographic->description)
                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/60 to-transparent px-5 pb-4 pt-10">
                                <p class="text-white font-semibold text-sm">{{ $infographic->title }}</p>
                                @if($infographic->description)
                                <p class="text-white/70 text-xs mt-0.5">{{ $infographic->description }}</p>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach

                        {{-- Nav arrows --}}
                        @if($infographics->count() > 1)
                        <button @click="current = (current - 1 + total) % total"
                                class="absolute left-2 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-white/80 hover:bg-white flex items-center justify-center shadow transition-colors">
                            <svg class="w-4 h-4 text-text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                        </button>
                        <button @click="current = (current + 1) % total"
                                class="absolute right-2 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-white/80 hover:bg-white flex items-center justify-center shadow transition-colors">
                            <svg class="w-4 h-4 text-text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                        </button>

                        {{-- Dots --}}
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5">
                            @foreach($infographics as $i => $inf)
                            <button @click="current = {{ $i }}"
                                    class="w-2 h-2 rounded-full transition-all duration-300"
                                    :class="current === {{ $i }} ? 'bg-white w-4' : 'bg-white/50'"></button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="aspect-video rounded-2xl bg-white border border-border-light shadow-sm flex items-center justify-center">
                        <span class="text-text-muted text-sm">Infografía: espectro de luz azul</span>
                    </div>
                    @endif
                </div>

                {{-- Contenido --}}
                <div x-data x-reveal.once>
                    <span class="inline-block text-secondary text-sm font-semibold tracking-wider uppercase mb-3">¿Sabías esto?</span>
                    <h2 class="font-brand text-3xl md:text-4xl font-bold text-text-dark leading-tight">
                        ¿Qué es la luz azul y por qué daña tus ojos?
                    </h2>
                    <p class="mt-5 text-text-muted leading-relaxed">
                        La luz azul de alta energía es emitida por pantallas, focos LED y el sol. La exposición prolongada penetra profundamente en tus ojos, causando:
                    </p>
                    <ul class="mt-5 space-y-3">
                        @php
                        $symptoms = [
                            'Fatiga visual y ojos secos',
                            'Dolores de cabeza crónicos',
                            'Alteración del ciclo de sueño',
                            'Tensión ocular constante',
                        ];
                        @endphp
                        @foreach($symptoms as $index => $symptom)
                        <li class="flex items-center gap-3 text-text-muted reveal"
                            style="transition-delay: {{ $index * 100 }}ms">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-danger/10 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                            </span>
                            {{ $symptom }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('blue-light') }}" class="mt-6 inline-flex items-center gap-2 text-secondary font-semibold hover:underline">
                        Conoce la ciencia completa
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Scroll-driven product image strip — glass effect --}}
    <div class="relative overflow-hidden py-6 md:py-8 bg-white/60 backdrop-blur-xl border-y border-white/40 shadow-[0_4px_30px_rgba(0,0,0,0.05)]"
         x-data @scroll.window.throttle.30ms="$el.querySelector('.strip-track').style.transform = `translateX(-${window.scrollY * 0.5}px)`">
        <div class="strip-track flex gap-10 md:gap-14 items-center will-change-transform" style="transition: transform 0.1s linear;">
            @for($set = 0; $set < 3; $set++)
                @foreach($heroImages as $img)
                <img src="{{ asset('storage/products/' . $img) }}"
                     alt="nuvion glass"
                     class="h-20 md:h-28 w-auto flex-shrink-0 object-contain opacity-50 hover:opacity-100 hover:scale-105 transition-all duration-300">
                @endforeach
            @endfor
        </div>
    </div>

    {{-- ============================================================
         3. PRODUCTOS DESTACADOS (3 top)
         Fondo blanco
         ============================================================ --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto" x-data x-reveal.once>
                <span class="inline-block text-secondary text-sm font-semibold tracking-wider uppercase mb-3">Catálogo</span>
                <h2 class="font-brand text-3xl md:text-4xl font-bold text-text-dark">Nuestros lentes destacados</h2>
                <p class="mt-4 text-text-muted">Sin graduación o con ella — hay un nuvion para ti.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($featuredProducts->take(3) as $index => $product)
                <div class="reveal group bg-bg-light rounded-2xl overflow-hidden border border-border-light
                            hover:shadow-xl hover:shadow-secondary/10 hover:-translate-y-1.5 hover:border-secondary/30
                            transition-all duration-300"
                     style="transition-delay: {{ $index * 150 }}ms">
                    {{-- Imagen --}}
                    <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-[4/3] overflow-hidden">
                        @if($product->images && count($product->images) > 0)
                            <div class="w-full h-full bg-white flex items-center justify-center">
                                <img src="{{ asset('storage/' . $product->images[0]) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105"
                                     loading="lazy">
                            </div>
                        @else
                            {{-- Attractive gradient placeholder --}}
                            @php
                                $gradients = [
                                    'from-primary/10 via-secondary/5 to-primary/15',
                                    'from-secondary/10 via-primary/5 to-secondary/15',
                                    'from-primary/15 via-secondary/10 to-primary/5',
                                ];
                            @endphp
                            <div class="w-full h-full bg-gradient-to-br {{ $gradients[$index % 3] }} flex items-center justify-center relative">
                                {{-- Animated decorative elements --}}
                                <div class="absolute inset-0 overflow-hidden">
                                    <div class="absolute top-6 right-6 w-20 h-20 rounded-full bg-secondary/10 blur-xl"></div>
                                    <div class="absolute bottom-8 left-8 w-16 h-16 rounded-full bg-primary/10 blur-lg"></div>
                                </div>
                                {{-- Glasses icon --}}
                                <div class="relative text-center transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-20 h-20 mx-auto text-secondary/25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                    <p class="mt-1 text-xs font-semibold text-secondary/40 tracking-wide">Próximamente</p>
                                </div>
                            </div>
                        @endif
                        {{-- Badge de oferta --}}
                        @if($product->compare_price && $product->compare_price > $product->price)
                            @php $discount = round((1 - $product->price / $product->compare_price) * 100); @endphp
                            <span class="absolute top-4 left-4 bg-secondary text-white text-xs font-bold px-3 py-1 rounded-full">-{{ $discount }}%</span>
                        @endif
                    </a>
                    {{-- Info --}}
                    <div class="p-5 md:p-6">
                        <p class="text-xs text-secondary font-medium uppercase tracking-wide">{{ $product->category->name ?? '' }}</p>
                        <h3 class="mt-1 font-brand text-lg font-semibold text-text-dark">{{ $product->name }}</h3>
                        <p class="mt-1.5 text-sm text-text-muted leading-relaxed line-clamp-2">{{ $product->description }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-primary">${{ number_format($product->price, 0, '.', ',') }}</span>
                                @if($product->compare_price && $product->compare_price > $product->price)
                                    <span class="ml-1.5 text-sm text-text-muted line-through">${{ number_format($product->compare_price, 0, '.', ',') }}</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}"
                               class="bg-primary hover:bg-primary-light text-white px-5 py-2.5 rounded-xl text-sm font-semibold
                                      transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:shadow-primary/20 active:translate-y-0">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-secondary font-semibold hover:underline text-base">
                    Ver todos los lentes
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================
         4. BENEFICIOS VISUALES CON ÍCONOS
         Fondo claro #F4F6F9
         ============================================================ --}}
    <section class="py-16 md:py-24 bg-bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto" x-data x-reveal.once>
                <span class="inline-block text-secondary text-sm font-semibold tracking-wider uppercase mb-3">Beneficios</span>
                <h2 class="font-brand text-3xl md:text-4xl font-bold text-text-dark">¿Por qué elegir nuvion?</h2>
                <p class="mt-4 text-text-muted">Tecnología que cuida tu visión. Diseño que querrás usar todo el día.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @php
                $benefits = [
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>',
                        'title' => 'Reduce fatiga visual',
                        'desc' => 'Filtra entre 30-50% de la luz azul dañina para que tus ojos descansen.',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>',
                        'title' => 'Mejora tu sueño',
                        'desc' => 'Bloquea la luz azul que altera tu ritmo circadiano y tu calidad de descanso.',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z"/>',
                        'title' => 'Menos dolores de cabeza',
                        'desc' => 'Reduce la tensión ocular que causa migrañas y dolores frecuentes.',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/>',
                        'title' => 'Diseño moderno',
                        'desc' => 'Marcos premium que se ven increíbles. Lentes que querrás usar todo el día.',
                    ],
                ];
                @endphp

                @foreach($benefits as $benefitIndex => $benefit)
                <div class="reveal bg-white rounded-2xl p-6 md:p-8 text-center border border-border-light
                            hover:shadow-lg hover:shadow-secondary/5 hover:-translate-y-1 transition-all duration-300 group"
                     style="transition-delay: {{ $benefitIndex * 100 }}ms">
                    <div class="w-14 h-14 mx-auto bg-secondary/10 rounded-2xl flex items-center justify-center
                                transition-transform duration-300 group-hover:scale-110 group-hover:bg-secondary/20">
                        <svg class="w-7 h-7 text-secondary transition-transform duration-300 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $benefit['icon'] !!}
                        </svg>
                    </div>
                    <h3 class="mt-5 font-brand text-lg font-semibold text-text-dark">{{ $benefit['title'] }}</h3>
                    <p class="mt-2 text-sm text-text-muted leading-relaxed">{{ $benefit['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         5. COMPARATIVO con / sin protección
         Fondo blanco
         ============================================================ --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-block text-secondary text-sm font-semibold tracking-wider uppercase mb-3">Comparativo</span>
                <h2 class="font-brand text-3xl md:text-4xl font-bold text-text-dark">Con vs. sin protección</h2>
                <p class="mt-4 text-text-muted">Mira la diferencia real de usar lentes con protección de luz azul.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 max-w-4xl mx-auto">
                {{-- Sin protección --}}
                <div class="reveal rounded-2xl border-2 border-danger/20 bg-danger/5 p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-danger/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
                        </div>
                        <h3 class="font-brand text-xl font-bold text-danger">Sin protección</h3>
                    </div>
                    <ul class="space-y-4">
                        @php
                        $noProtection = [
                            'Ojos cansados y secos después de 2 horas',
                            'Dolores de cabeza frecuentes al final del día',
                            'Dificultad para conciliar el sueño',
                            'Visión borrosa y tensión constante',
                        ];
                        @endphp
                        @foreach($noProtection as $npIndex => $item)
                        <li class="reveal flex items-start gap-3" style="transition-delay: {{ 100 + $npIndex * 80 }}ms">
                            <span class="flex-shrink-0 w-5 h-5 mt-0.5 rounded-full bg-danger/10 flex items-center justify-center">
                                <svg class="w-3 h-3 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18 18 6M6 6l12 12"/></svg>
                            </span>
                            <span class="text-text-dark/80">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Con nuvion --}}
                <div class="reveal delay-150 rounded-2xl border-2 border-success/20 bg-success/5 p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-success/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        </div>
                        <h3 class="font-brand text-xl font-bold text-success">Con nuvion glass</h3>
                    </div>
                    <ul class="space-y-4">
                        @php
                        $withProtection = [
                            'Vista cómoda todo el día sin fatiga',
                            'Menos dolores de cabeza y migrañas',
                            'Mejor calidad de sueño y descanso',
                            'Mayor rendimiento y concentración',
                        ];
                        @endphp
                        @foreach($withProtection as $wpIndex => $item)
                        <li class="reveal flex items-start gap-3" style="transition-delay: {{ 150 + $wpIndex * 80 }}ms">
                            <span class="flex-shrink-0 w-5 h-5 mt-0.5 rounded-full bg-success/10 flex items-center justify-center">
                                <svg class="w-3 h-3 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            </span>
                            <span class="text-text-dark/80">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         6. TESTIMONIOS / PRUEBA SOCIAL
         Fondo claro #F4F6F9
         ============================================================ --}}
    <section class="py-16 md:py-24 bg-bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto" x-data x-reveal.once>
                <span class="inline-block text-secondary text-sm font-semibold tracking-wider uppercase mb-3">Testimonios</span>
                <h2 class="font-brand text-3xl md:text-4xl font-bold text-text-dark">Lo que dicen nuestros clientes</h2>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                @php
                $testimonials = [
                    ['name' => 'María G.', 'role' => 'Diseñadora gráfica', 'text' => 'Desde que uso mis nuvion, ya no termino el día con los ojos rojos. Son súper cómodos y se ven increíbles.', 'avatar' => 'M'],
                    ['name' => 'Carlos R.', 'role' => 'Programador', 'text' => 'Trabajo 10 horas frente a la pantalla y estos lentes cambiaron todo. Menos dolor de cabeza y duermo mejor.', 'avatar' => 'C'],
                    ['name' => 'Ana L.', 'role' => 'Estudiante', 'text' => 'Los compré sin graduación y me encantan. El diseño es moderno y realmente siento la diferencia.', 'avatar' => 'A'],
                ];
                @endphp

                @foreach($testimonials as $tIndex => $testimonial)
                <div class="reveal bg-white rounded-2xl p-6 md:p-8 border border-border-light shadow-sm
                            hover:shadow-lg hover:shadow-secondary/5 hover:-translate-y-1 transition-all duration-300"
                     style="transition-delay: {{ $tIndex * 150 }}ms">
                    {{-- Stars --}}
                    <div class="flex items-center gap-1">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-warning anim-scale-in" style="animation-delay: {{ 300 + ($i * 80) }}ms" fill="currentColor" viewBox="0 0 24 24"><path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"/></svg>
                        @endfor
                    </div>

                    {{-- Quote --}}
                    <p class="mt-4 text-text-dark/80 leading-relaxed">"{{ $testimonial['text'] }}"</p>

                    {{-- Author --}}
                    <div class="mt-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm">
                            {{ $testimonial['avatar'] }}
                        </div>
                        <div>
                            <p class="font-semibold text-text-dark text-sm">{{ $testimonial['name'] }}</p>
                            <p class="text-xs text-text-muted">{{ $testimonial['role'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         7. FAQ — RESPONDE OBJECIONES (Alpine.js accordion)
         Fondo blanco
         ============================================================ --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-block text-secondary text-sm font-semibold tracking-wider uppercase mb-3">FAQ</span>
                <h2 class="font-brand text-3xl md:text-4xl font-bold text-text-dark">Preguntas frecuentes</h2>
                <p class="mt-4 text-text-muted">Todo lo que necesitas saber antes de proteger tu visión.</p>
            </div>

            <div class="mt-12 max-w-3xl mx-auto space-y-3 reveal visible" x-data="{ openFaq: null }">
                @php
                $faqs = [
                    ['q' => '¿De verdad funcionan los lentes de luz azul?', 'a' => 'Sí. Nuestros lentes filtran entre el 30% y 50% de la luz azul de alta energía emitida por pantallas y focos LED. Esto reduce la fatiga visual, dolores de cabeza y mejora la calidad del sueño. Múltiples estudios respaldan los beneficios de la filtración de luz azul.'],
                    ['q' => '¿Puedo usarlos si no tengo graduación?', 'a' => 'Por supuesto. Tenemos modelos sin graduación diseñados específicamente para personas que no necesitan corrección visual pero quieren proteger sus ojos de la luz azul de pantallas.'],
                    ['q' => '¿Cuánto tarda el envío?', 'a' => 'El envío estándar tarda de 3 a 5 días hábiles a cualquier parte de México. Ofrecemos envío gratis en compras mayores a $999 MXN.'],
                    ['q' => '¿Tienen garantía?', 'a' => 'Todos nuestros lentes incluyen 6 meses de garantía contra defectos de fabricación. Si no estás satisfecho, puedes devolverlos en los primeros 30 días.'],
                    ['q' => '¿Puedo pedir lentes con mi graduación?', 'a' => 'Sí. Ofrecemos lentes con graduación para miopía y lectura. Solo necesitas seleccionar la opción "con graduación" en la ficha del producto e indicar tus dioptrías.'],
                ];
                @endphp

                @foreach($faqs as $index => $faq)
                <div class="border border-border-light rounded-xl overflow-hidden bg-bg-light" x-data>
                    <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                            class="w-full flex items-center justify-between px-5 md:px-6 py-4 text-left
                                   hover:bg-white transition-all duration-200 group"
                            :class="openFaq === {{ $index }} ? 'bg-white' : ''">
                        <span class="font-semibold text-text-dark pr-4 transition-colors duration-200"
                              :class="openFaq === {{ $index }} ? 'text-secondary' : ''">{{ $faq['q'] }}</span>
                        <span class="flex-shrink-0 w-8 h-8 rounded-full bg-white border border-border-light flex items-center justify-center">
                            <svg :class="openFaq === {{ $index }} ? 'rotate-180' : ''" class="w-4 h-4 text-primary transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </span>
                    </button>
                    <div x-show="openFaq === {{ $index }}" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-96"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="px-5 md:px-6 pb-5">
                        <p class="text-text-muted leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         8. CTA FINAL — fondo oscuro (azul primario)
         ============================================================ --}}
    <section class="py-16 md:py-24 bg-primary relative overflow-hidden">
        {{-- Glow decorativo --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-secondary/10 rounded-full blur-[100px] pointer-events-none"
             style="animation: pulseDot 5s ease-in-out infinite;"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/20 rounded-full blur-[80px] pointer-events-none"
             style="animation: pulseDot 7s ease-in-out 1s infinite;"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-brand text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight reveal visible anim-fade-up">
                ¿Listo para proteger tu visión?
            </h2>
            <p class="mt-5 text-lg text-white/80 max-w-xl mx-auto reveal visible anim-fade-up delay-200">
                Ven mejor, duerme mejor, rinde más. Únete a miles de personas que ya cuidan sus ojos con nuvion.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('products.index') }}"
                   class="relative inline-flex items-center justify-center bg-secondary hover:bg-secondary/90 text-white px-10 py-4 rounded-xl font-semibold text-lg transition-all duration-300
                          shadow-lg shadow-secondary/25 hover:shadow-xl hover:shadow-secondary/40 hover:-translate-y-0.5
                          overflow-hidden group active:translate-y-0">
                    <span class="shimmer-inner absolute inset-0 w-full h-full"
                          style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
                                 transform: translateX(-100%);
                                 transition: transform 500ms ease;"></span>
                    Comprar ahora
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </a>
                <a href="{{ route('blue-light') }}"
                   class="inline-flex items-center justify-center border border-white/30 text-white hover:bg-white/10 px-10 py-4 rounded-xl font-medium text-lg transition-colors">
                    Aprende más
                </a>
            </div>

            {{-- Trust --}}
            <div class="mt-10 flex flex-wrap items-center justify-center gap-6 text-sm text-white/50">
                <span>Envío gratis a todo México</span>
                <span class="hidden sm:inline">|</span>
                <span>Garantía 6 meses</span>
                <span class="hidden sm:inline">|</span>
                <span>30 días de devolución</span>
            </div>
        </div>
    </section>

@endsection
