@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])
@section('canonical', $seo['canonical'])
@section('og_type', $seo['og_type'])
@section('og_title', $seo['og_title'])
@section('og_description', $seo['og_description'])
@section('og_image', $seo['og_image'])
@section('twitter_title', $seo['twitter_title'])
@section('twitter_description', $seo['twitter_description'])
@section('twitter_image', $seo['twitter_image'])

@push('schema')
    {!! $schema !!}
    {!! $breadcrumbs !!}
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="bg-bg-light border-b border-border-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex items-center gap-2 text-sm text-text-muted">
                <a href="{{ route('home') }}" class="hover:text-secondary transition-colors">Inicio</a>
                <svg class="w-3.5 h-3.5 text-text-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                <a href="{{ route('products.index') }}" class="hover:text-secondary transition-colors">Lentes</a>
                @if($product->category)
                <svg class="w-3.5 h-3.5 text-text-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                <a href="{{ route('products.index', ['categoria' => $product->category->slug]) }}" class="hover:text-secondary transition-colors">{{ $product->category->name }}</a>
                @endif
                <svg class="w-3.5 h-3.5 text-text-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                <span class="text-text-dark font-medium truncate">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    {{-- Product detail --}}
    <section class="py-10 md:py-16 bg-white" x-data="productDetail()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">

                {{-- ======================== LEFT: IMAGE GALLERY ======================== --}}
                <div class="space-y-4">
                    {{-- Main image with zoom --}}
                    <div class="relative aspect-square bg-bg-light rounded-2xl border border-border-light overflow-hidden cursor-zoom-in group"
                         @mousemove="zoomImage($event)" @mouseleave="zoomActive = false" @mouseenter="zoomActive = true"
                         @click="openLightbox()">

                        @if($product->images && count($product->images) > 0)
                            @foreach($product->images as $i => $image)
                            <img src="{{ asset('storage/' . $image) }}"
                                 alt="{{ $product->name }} - imagen {{ $i + 1 }}"
                                 class="absolute inset-0 w-full h-full object-contain p-6 transition-opacity duration-300"
                                 :class="activeImage === {{ $i }} ? 'opacity-100' : 'opacity-0'"
                                 :style="activeImage === {{ $i }} && zoomActive ? 'transform: scale(2); transform-origin: ' + zoomX + '% ' + zoomY + '%' : ''">
                            @endforeach
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/5 to-secondary/10">
                                <div class="text-center">
                                    <svg class="w-24 h-24 mx-auto text-secondary/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-secondary/30">Imagen próximamente</p>
                                </div>
                            </div>
                        @endif

                        {{-- Zoom hint --}}
                        @if($product->images && count($product->images) > 0)
                        <div class="absolute bottom-4 right-4 bg-black/50 text-white text-xs px-3 py-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                            Hover para zoom
                        </div>
                        @endif

                        {{-- Badges --}}
                        <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                            @if($product->compare_price && $product->compare_price > $product->price)
                                @php $discount = round((1 - $product->price / $product->compare_price) * 100); @endphp
                                <span class="bg-danger text-white text-xs font-bold px-3 py-1 rounded-full shadow">-{{ $discount }}%</span>
                            @endif
                            @if($product->is_featured)
                                <span class="bg-secondary text-white text-xs font-bold px-3 py-1 rounded-full shadow">Destacado</span>
                            @endif
                        </div>
                    </div>

                    {{-- Thumbnails --}}
                    @if($product->images && count($product->images) > 1)
                    <div class="flex gap-3 overflow-x-auto pb-1">
                        @foreach($product->images as $i => $image)
                        <button @click="activeImage = {{ $i }}"
                                class="shrink-0 w-20 h-20 rounded-xl border-2 overflow-hidden transition-all duration-200"
                                :class="activeImage === {{ $i }} ? 'border-secondary shadow-md shadow-secondary/20' : 'border-border-light hover:border-secondary/30'">
                            <img src="{{ asset('storage/' . $image) }}" alt="" class="w-full h-full object-contain p-1">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- ======================== RIGHT: PRODUCT INFO ======================== --}}
                <div class="lg:sticky lg:top-24 lg:self-start">
                    {{-- Category --}}
                    @if($product->category)
                    <a href="{{ route('products.index', ['categoria' => $product->category->slug]) }}"
                       class="inline-block text-xs font-bold text-secondary uppercase tracking-wider hover:underline mb-2">
                        {{ $product->category->name }}
                    </a>
                    @endif

                    {{-- Name --}}
                    <h1 class="font-brand text-3xl md:text-4xl font-bold text-text-dark leading-tight">{{ $product->name }}</h1>

                    {{-- Price --}}
                    <div class="mt-4 flex items-baseline gap-3">
                        <span class="text-3xl font-bold text-primary">${{ number_format($product->price, 0, '.', ',') }}</span>
                        @if($product->compare_price && $product->compare_price > $product->price)
                        <span class="text-lg text-text-muted/50 line-through">${{ number_format($product->compare_price, 0, '.', ',') }}</span>
                        <span class="bg-danger/10 text-danger text-xs font-bold px-2 py-1 rounded-full">Ahorras ${{ number_format($product->compare_price - $product->price, 0, '.', ',') }}</span>
                        @endif
                    </div>

                    {{-- Short description --}}
                    <p class="mt-5 text-text-muted leading-relaxed">{{ $product->description }}</p>

                    {{-- Variants --}}
                    @if($product->variants->count())
                    <div class="mt-6">
                        @php
                            $variantGroups = $product->variants->groupBy('name');
                        @endphp
                        @foreach($variantGroups as $attrName => $options)
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-text-dark mb-2">
                                {{ $attrName }}: <span class="font-normal text-text-muted" x-text="selectedVariantLabel || 'Seleccionar'"></span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($options as $variant)
                                <button type="button"
                                        @click="selectVariant({{ $variant->id }}, '{{ $variant->value }}', {{ $variant->price_modifier }}, {{ $variant->stock }})"
                                        class="px-4 py-2.5 rounded-xl text-sm font-medium border-2 transition-all duration-200"
                                        :class="selectedVariantId === {{ $variant->id }}
                                            ? 'border-secondary bg-secondary/10 text-secondary'
                                            : 'border-border-light text-text-muted hover:border-secondary/30 hover:text-text-dark'">
                                    {{ $variant->value }}
                                    @if($variant->price_modifier > 0)
                                    <span class="text-xs text-text-muted/60">+${{ number_format($variant->price_modifier, 0) }}</span>
                                    @endif
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Quantity + Add to cart --}}
                    <div class="mt-6 space-y-4">
                        <div class="flex items-center gap-4">
                            {{-- Quantity --}}
                            <div class="flex items-center border-2 border-border-light rounded-xl overflow-hidden">
                                <button @click="qty > 1 && qty--" class="w-11 h-11 flex items-center justify-center text-text-muted hover:bg-bg-light transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/></svg>
                                </button>
                                <span class="w-12 h-11 flex items-center justify-center text-sm font-bold text-text-dark" x-text="qty"></span>
                                <button @click="qty < 10 && qty++" class="w-11 h-11 flex items-center justify-center text-text-muted hover:bg-bg-light transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                </button>
                            </div>

                            {{-- Stock indicator --}}
                            @if($product->stock > 0)
                            <span class="flex items-center gap-1.5 text-sm text-success">
                                <span class="w-2 h-2 rounded-full bg-success"></span>
                                En stock
                            </span>
                            @else
                            <span class="flex items-center gap-1.5 text-sm text-danger">
                                <span class="w-2 h-2 rounded-full bg-danger"></span>
                                Agotado
                            </span>
                            @endif
                        </div>

                        {{-- Add to cart button --}}
                        <button @click="addToCart()"
                                :disabled="adding || {{ $product->stock <= 0 ? 'true' : 'false' }}"
                                class="w-full flex items-center justify-center gap-3 bg-secondary hover:bg-secondary/90 text-white py-4 rounded-2xl font-bold text-base
                                       transition-all duration-300 shadow-lg shadow-secondary/25 hover:shadow-xl hover:shadow-secondary/30 hover:-translate-y-0.5
                                       disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:shadow-lg active:translate-y-0">
                            <template x-if="!adding && !added">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                                    Agregar al carrito
                                </span>
                            </template>
                            <template x-if="adding">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    Agregando...
                                </span>
                            </template>
                            <template x-if="added">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                    Agregado
                                </span>
                            </template>
                        </button>
                    </div>

                    {{-- Trust badges --}}
                    <div class="mt-8 grid grid-cols-2 gap-3">
                        <div class="flex items-center gap-3 bg-bg-light rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                            <div>
                                <p class="text-xs font-bold text-text-dark">Envío gratis</p>
                                <p class="text-xs text-text-muted">En compras +$999</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-bg-light rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                            <div>
                                <p class="text-xs font-bold text-text-dark">Garantía 6 meses</p>
                                <p class="text-xs text-text-muted">Contra defectos</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-bg-light rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182"/></svg>
                            <div>
                                <p class="text-xs font-bold text-text-dark">30 días</p>
                                <p class="text-xs text-text-muted">Devolución fácil</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-bg-light rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <div>
                                <p class="text-xs font-bold text-text-dark">Filtro certificado</p>
                                <p class="text-xs text-text-muted">Luz azul 30-50%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================== PRODUCT DETAILS TABS ======================== --}}
            <div class="mt-16 border-t border-border-light pt-12" x-data="{ activeTab: 'description' }">
                <div class="flex gap-1 border-b border-border-light mb-8 overflow-x-auto">
                    <button @click="activeTab = 'description'"
                            class="px-6 py-3 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap"
                            :class="activeTab === 'description' ? 'border-secondary text-secondary' : 'border-transparent text-text-muted hover:text-text-dark'">
                        Descripción
                    </button>
                    @if($product->variants->count())
                    <button @click="activeTab = 'specs'"
                            class="px-6 py-3 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap"
                            :class="activeTab === 'specs' ? 'border-secondary text-secondary' : 'border-transparent text-text-muted hover:text-text-dark'">
                        Especificaciones
                    </button>
                    @endif
                    <button @click="activeTab = 'shipping'"
                            class="px-6 py-3 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap"
                            :class="activeTab === 'shipping' ? 'border-secondary text-secondary' : 'border-transparent text-text-muted hover:text-text-dark'">
                        Envío y devoluciones
                    </button>
                </div>

                <div x-show="activeTab === 'description'" class="prose prose-sm max-w-3xl text-text-muted leading-relaxed">
                    <p>{{ $product->description }}</p>
                </div>

                @if($product->variants->count())
                <div x-show="activeTab === 'specs'" x-cloak class="max-w-3xl">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-border-light">
                            @foreach($product->variants->groupBy('name') as $attr => $vals)
                            <tr>
                                <td class="py-3 pr-4 font-semibold text-text-dark w-40">{{ $attr }}</td>
                                <td class="py-3 text-text-muted">{{ $vals->pluck('value')->join(', ') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="py-3 pr-4 font-semibold text-text-dark">Protección</td>
                                <td class="py-3 text-text-muted">Filtro de luz azul 30-50% (380-500nm)</td>
                            </tr>
                            <tr>
                                <td class="py-3 pr-4 font-semibold text-text-dark">Material</td>
                                <td class="py-3 text-text-muted">Marco TR-90 ultraligero</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif

                <div x-show="activeTab === 'shipping'" x-cloak class="max-w-3xl space-y-4 text-sm text-text-muted leading-relaxed">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-secondary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                        <div>
                            <p class="font-semibold text-text-dark">Envío estándar: 3-5 días hábiles</p>
                            <p>Envío gratis en pedidos mayores a $999 MXN. Costo de envío: $99 MXN.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-secondary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182"/></svg>
                        <div>
                            <p class="font-semibold text-text-dark">Devoluciones: 30 días</p>
                            <p>Si no estás satisfecho, puedes devolver tu producto dentro de los primeros 30 días. El producto debe estar en su empaque original.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================== RELATED PRODUCTS ======================== --}}
            @if($related->count())
            <div class="mt-16 border-t border-border-light pt-12">
                <h2 class="font-brand text-2xl font-bold text-text-dark mb-8">También te puede gustar</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($related as $relProduct)
                    @php $relImg = $relProduct->images[0] ?? null; @endphp
                    <a href="{{ route('products.show', $relProduct->slug) }}"
                       class="group bg-bg-light rounded-2xl overflow-hidden border border-border-light hover:shadow-lg hover:-translate-y-1 transition-all duration-300 block">
                        <div class="aspect-[4/3] bg-white overflow-hidden">
                            @if($relImg)
                            <img src="{{ asset('storage/' . $relImg) }}" alt="{{ $relProduct->name }}" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/5 to-secondary/10">
                                <svg class="w-12 h-12 text-secondary/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-brand font-semibold text-text-dark group-hover:text-secondary transition-colors">{{ $relProduct->name }}</h3>
                            <p class="mt-1 text-lg font-bold text-primary">${{ number_format($relProduct->price, 0, '.', ',') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </section>

    {{-- Lightbox --}}
    <div x-show="lightboxOpen" x-cloak
         class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center"
         @keydown.escape.window="lightboxOpen = false">
        <button @click="lightboxOpen = false" class="absolute top-4 right-4 text-white/70 hover:text-white z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
        </button>
        @if($product->images && count($product->images) > 0)
        <button @click="activeImage = (activeImage - 1 + {{ count($product->images) }}) % {{ count($product->images) }}"
                class="absolute left-4 text-white/70 hover:text-white z-10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        </button>
        <button @click="activeImage = (activeImage + 1) % {{ count($product->images) }}"
                class="absolute right-4 text-white/70 hover:text-white z-10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        </button>
        @foreach($product->images as $i => $image)
        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
             class="max-h-[85vh] max-w-[90vw] object-contain transition-opacity duration-300"
             x-show="activeImage === {{ $i }}">
        @endforeach
        @endif
    </div>

@endsection

@push('scripts')
<script>
function productDetail() {
    return {
        activeImage: 0,
        zoomActive: false,
        zoomX: 50,
        zoomY: 50,
        lightboxOpen: false,
        selectedVariantId: null,
        selectedVariantLabel: '',
        selectedVariantModifier: 0,
        selectedVariantStock: null,
        qty: 1,
        adding: false,
        added: false,

        zoomImage(e) {
            const rect = e.currentTarget.getBoundingClientRect();
            this.zoomX = ((e.clientX - rect.left) / rect.width) * 100;
            this.zoomY = ((e.clientY - rect.top) / rect.height) * 100;
        },

        openLightbox() {
            this.zoomActive = false;
            this.lightboxOpen = true;
        },

        selectVariant(id, label, modifier, stock) {
            this.selectedVariantId = id;
            this.selectedVariantLabel = label;
            this.selectedVariantModifier = modifier;
            this.selectedVariantStock = stock;
        },

        async addToCart() {
            if (this.adding) return;
            this.adding = true;
            this.added = false;

            try {
                const res = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        product_id: {{ $product->id }},
                        variant_id: this.selectedVariantId,
                        qty: this.qty,
                    }),
                });

                const data = await res.json();

                if (res.ok) {
                    this.added = true;
                    // Update cart badge
                    const badge = document.getElementById('cart-badge');
                    const count = document.getElementById('cart-count');
                    if (badge && count) {
                        badge.classList.remove('hidden');
                        count.textContent = data.cart_count;
                    }
                    // Open cart drawer
                    window.dispatchEvent(new CustomEvent('open-cart-drawer', { detail: data }));
                    setTimeout(() => { this.added = false; }, 2000);
                }
            } catch (e) {
                console.error(e);
            } finally {
                this.adding = false;
            }
        },
    };
}
</script>
@endpush
