@extends('layouts.app')

@section('body_class', 'bg-bg-light text-text-dark')

@section('title', $seoSettings->meta_title ?? 'nuvion - glass | Protege tus ojos de la luz azul')
@section('meta_description', $seoSettings->meta_description ?? 'Lentes con protección de luz azul. Con o sin graduación. Diseño moderno que querrás usar todo el día. Envío gratis a todo México.')
@section('robots', $seoSettings->robots ?? 'index, follow')
@section('canonical', $seoSettings->canonical_url ?? url()->current())
@section('og_type', $seoSettings->og_type ?? 'website')
@section('og_title', $seoSettings->og_title ?? $seoSettings->meta_title ?? 'nuvion - glass | Lentes con protección de luz azul')
@section('og_description', $seoSettings->og_description ?? $seoSettings->meta_description ?? 'Protege tus ojos de las pantallas. Lentes con filtro de luz azul, con o sin graduación. Envío gratis.')
@section('og_image', $seoSettings->og_image_url ?? asset('images/og-default.jpg'))
@section('twitter_card', $seoSettings->twitter_card ?? 'summary_large_image')
@section('twitter_title', $seoSettings->twitter_title ?? $seoSettings->meta_title ?? 'nuvion - glass | Lentes con protección de luz azul')
@section('twitter_description', $seoSettings->twitter_description ?? $seoSettings->meta_description ?? 'Protege tus ojos de las pantallas. Lentes con filtro de luz azul, con o sin graduación. Envío gratis.')
@section('twitter_image', $seoSettings->twitter_image_url ?? $seoSettings->og_image_url ?? asset('images/og-default.jpg'))

@push('schema')
    {!! $organizationSchema !!}
    {!! $faqSchema !!}
    @if($seoSettings && $seoSettings->custom_schema_markup)
        {!! $seoSettings->custom_schema_markup !!}
    @endif
@endpush

@section('content')

    {{-- ============================================================
         1. HERO — split claro (default) o video full width
         ============================================================ --}}
    <style>
        @keyframes hSlideUp {
            from { opacity:0; transform:translateY(22px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes hSlideRight {
            from { opacity:0; transform:translateX(20px); }
            to   { opacity:1; transform:translateX(0); }
        }
        @keyframes hFloatIn {
            from { opacity:0; transform:scale(.94); }
            to   { opacity:1; transform:scale(1); }
        }

        .h-anim-1 { animation: hSlideUp .7s ease .05s both; }
        .h-anim-2 { animation: hSlideUp .7s ease .15s both; }
        .h-anim-3 { animation: hSlideUp .7s ease .25s both; }
        .h-anim-4 { animation: hSlideUp .7s ease .35s both; }
        .h-anim-5 { animation: hSlideUp .7s ease .45s both; }
        .h-anim-6 { animation: hSlideUp .7s ease .55s both; }
        .h-img-anim { animation: hSlideRight .8s ease .2s both; }
        .h-float-anim { animation: hFloatIn .6s ease both; }
        .h-float-anim:nth-child(2) { animation-delay:.5s; }
        .h-float-anim:nth-child(3) { animation-delay:.7s; }

        .h-btn-dark {
            background: #0d1117;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 13px 26px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background .2s, transform .15s;
        }
        .h-btn-dark:hover {
            background: #378ADD;
            transform: translateY(-1px);
        }

        .h-btn-outline {
            background: transparent;
            color: #374151;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 13px 26px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all .2s;
        }
        .h-btn-outline:hover {
            border-color: #378ADD;
            color: #378ADD;
        }

        .h-trust-bar {
            background: #f9fafb;
            border-top: 1px solid #f3f4f6;
            padding: 14px 6%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 28px;
            flex-wrap: wrap;
        }
        .h-trust-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #6b7280;
        }
        .h-trust-icon {
            width: 22px; height: 22px;
            background: #EBF4FF;
            border-radius: 50%;
            display: flex; align-items: center;
            justify-content: center;
            font-size: 11px; color: #378ADD;
            flex-shrink: 0;
        }

        .h-float-badge {
            position: absolute;
            background: #fff;
            border-radius: 10px;
            padding: 10px 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .h-float-num {
            font-size: 20px;
            font-weight: 700;
            color: #0d1117;
            line-height: 1;
        }
        .h-float-lbl {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .h-split-grid {
                grid-template-columns: 1fr !important;
            }
            .h-split-right {
                height: 300px !important;
                min-height: 0 !important;
            }
            .h-float-badge { display: none !important; }
            .h-split-left {
                padding: 48px 24px 32px !important;
            }
            .h-trust-bar { gap: 16px; }
        }
        @media (prefers-reduced-motion: reduce) {
            .h-anim-1,.h-anim-2,.h-anim-3,
            .h-anim-4,.h-anim-5,.h-anim-6,
            .h-img-anim,.h-float-anim {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>

    @if($heroMode === 'split')
    {{-- ===== MODO A: SPLIT LAYOUT CLARO ===== --}}
    <section style="background:#ffffff;overflow:hidden;">
        <div class="h-split-grid" style="display:grid;grid-template-columns:1fr 1fr;min-height:580px;">

            {{-- COLUMNA IZQUIERDA: Texto --}}
            <div class="h-split-left" style="display:flex;flex-direction:column;justify-content:center;padding:72px 48px 72px 6%;background:#ffffff;">

                {{-- Eyebrow pill --}}
                <div class="h-anim-1" style="display:inline-flex;align-items:center;gap:7px;background:#EBF4FF;border:0.5px solid #B5D4F4;border-radius:20px;padding:5px 14px;font-size:11px;color:#185FA5;letter-spacing:.08em;text-transform:uppercase;margin-bottom:20px;width:fit-content;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#378ADD;flex-shrink:0;"></span>
                    {{ $hero->eyebrow_text ?? 'Protección de luz azul' }}
                </div>

                {{-- Título --}}
                @php
                    $t1 = $hero->title_line1 ?? 'Lentes que cuidan';
                    $t2 = $hero->title_line2 ?? 'tus ojos de las';
                    $t3 = $hero->title_line3 ?? 'pantallas';
                    $hl = $hero->title_highlight_word ?? 'pantallas';
                @endphp
                <h1 class="h-anim-2" style="font-size:clamp(34px,4.2vw,54px);font-weight:800;color:#0d1117;line-height:1.05;letter-spacing:-.025em;margin-bottom:18px;font-family:'Bai Jamjuree',sans-serif;">
                    {{ $t1 }}<br>
                    {{ $t2 }}<br>
                    @if($hl && str_contains($t3, $hl))
                        {!! str_replace($hl, '<span style="color:#378ADD;">'.$hl.'</span>', e($t3)) !!}
                    @else
                        {{ $t3 }}
                    @endif
                </h1>

                {{-- Badge 2x1 --}}
                @if($hero->badge_text ?? true)
                <div class="h-anim-3" style="display:inline-flex;align-items:center;gap:8px;background:#F0F7FF;border:1px solid #BFDBFE;border-radius:8px;padding:9px 16px;font-size:13px;color:#1e40af;margin-bottom:20px;width:fit-content;">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <rect x="1" y="3.5" width="12" height="9" rx="1.5" stroke="#1e40af" stroke-width="1.2"/>
                        <path d="M5 3.5V3a2 2 0 014 0v.5" stroke="#1e40af" stroke-width="1.2"/>
                    </svg>
                    {!! str_replace(
                        ['2x1', '$499.90'],
                        ['<strong style="font-weight:700;">2x1</strong>', '<strong style="font-weight:700;">$499.90</strong>'],
                        e($hero->badge_text ?? '2x1 en todos los lentes · $499.90 c/u')
                    ) !!}
                </div>
                @endif

                {{-- Subtítulo --}}
                <p class="h-anim-4" style="font-size:15px;color:#6b7280;line-height:1.65;margin-bottom:28px;max-width:400px;">
                    {{ $hero->subtitle ?? 'Con o sin graduación. Filtro de luz azul de alta eficiencia en todos los modelos.' }}
                </p>

                {{-- Botones --}}
                <div class="h-anim-5" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:28px;">
                    <a href="{{ $hero->btn_primary_url ?? '/lentes' }}" class="h-btn-dark">
                        {{ $hero->btn_primary_text ?? 'Ver lentes' }} →
                    </a>
                    <a href="{{ $hero->btn_secondary_url ?? '/que-es-la-luz-azul' }}" class="h-btn-outline">
                        {{ $hero->btn_secondary_text ?? '¿Qué es la luz azul?' }}
                    </a>
                </div>

                {{-- Trust items --}}
                @php
                    $trustItems = $hero->trust_items ?? ['Envío gratis +$999', 'Garantía 6 meses', '30 días devolución'];
                @endphp
                <div class="h-anim-6" style="display:flex;gap:16px;flex-wrap:wrap;">
                    @foreach($trustItems as $item)
                    <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#9ca3af;">
                        <span style="color:#22c55e;font-size:11px;">✓</span>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>

            </div>

            {{-- COLUMNA DERECHA: Imagen del producto --}}
            <div class="h-split-right h-img-anim" style="position:relative;overflow:hidden;background:linear-gradient(135deg,#e0f2fe 0%,#dbeafe 50%,#ede9fe 100%);min-height:580px;">

                @if($heroProduct && $heroProduct->featured_image)
                <img src="{{ asset('storage/'.$heroProduct->featured_image) }}"
                     alt="{{ $heroProduct->name }} nuvion glass filtro luz azul"
                     style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;object-position:center;padding:40px;transition:transform .4s ease;"
                     onmouseover="this.style.transform='scale(1.03)'"
                     onmouseout="this.style.transform='scale(1)'">
                @else
                {{-- Fallback si no hay imagen --}}
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                    <div style="width:220px;height:110px;border:4px solid rgba(13,17,23,0.15);border-radius:50%;position:relative;">
                        <div style="position:absolute;inset:12px;border-radius:50%;background:linear-gradient(135deg,rgba(56,130,221,0.15),rgba(139,92,246,0.1));"></div>
                    </div>
                </div>
                @endif

                {{-- Float badges --}}
                <div class="h-float-badge h-float-anim" style="top:14%;left:6%;">
                    <div class="h-float-num">{{ $hero->stat1_number ?? '2x1' }}</div>
                    <div class="h-float-lbl">{{ $hero->stat1_label ?? 'combinables' }}</div>
                </div>
                <div class="h-float-badge h-float-anim" style="bottom:20%;right:8%;">
                    <div class="h-float-num">{{ $hero->stat2_number ?? '6' }}</div>
                    <div class="h-float-lbl">{{ $hero->stat2_label ?? 'modelos' }}</div>
                </div>
                <div class="h-float-badge h-float-anim" style="top:52%;left:5%;">
                    <div class="h-float-num">7+</div>
                    <div class="h-float-lbl">colores</div>
                </div>

                {{-- Nombre del producto --}}
                @if($heroProduct)
                <div style="position:absolute;bottom:20px;left:50%;transform:translateX(-50%);background:rgba(255,255,255,0.9);backdrop-filter:blur(8px);border-radius:20px;padding:6px 16px;font-size:12px;color:#374151;white-space:nowrap;border:0.5px solid rgba(0,0,0,0.06);">
                    {{ $heroProduct->name }} · con filtro luz azul
                </div>
                @endif
            </div>
        </div>

        {{-- Trust bar inferior --}}
        <div class="h-trust-bar">
            <div class="h-trust-item">
                <div class="h-trust-icon">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none">
                        <path d="M2 5.5l2.5 2.5L9 3" stroke="#378ADD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                Filtro luz azul certificado
            </div>
            <div class="h-trust-item">
                <div class="h-trust-icon">📦</div>
                Envío gratis +$999
            </div>
            <div class="h-trust-item">
                <div class="h-trust-icon">↩</div>
                30 días devolución
            </div>
            <div class="h-trust-item">
                <div class="h-trust-icon">★</div>
                Garantía 6 meses
            </div>
        </div>
    </section>

    @else
    {{-- ===== MODO B: VIDEO FULL WIDTH ===== --}}
    <section style="position:relative;min-height:100vh;min-height:100svh;max-height:900px;overflow:hidden;background:#f9fafb;">

        {{-- Video de fondo --}}
        @php
            $vp = $hero->video_position ?? 50;
            $translateX = round(($vp - 50) * -0.4, 1);
        @endphp
        <video autoplay muted loop playsinline preload="metadata"
               style="position:absolute;inset:0;width:120%;height:100%;object-fit:cover;transform:translateX({{ $translateX }}%);">
            <source src="{{ asset('storage/'.$hero->media_path) }}" type="video/mp4">
        </video>

        {{-- Overlay claro de izquierda a derecha --}}
        @php
            $op = $hero->overlay_opacity ?? 0.55;
        @endphp
        <div style="position:absolute;inset:0;background:linear-gradient(to right,rgba(255,255,255,{{ round(0.5 + $op * 0.5, 2) }}) 0%,rgba(255,255,255,{{ round(0.4 + $op * 0.48, 2) }}) 30%,rgba(255,255,255,{{ round($op * 0.67, 2) }}) 55%,rgba(255,255,255,{{ round($op * 0.17, 2) }}) 80%,rgba(255,255,255,0.0) 100%);pointer-events:none;"></div>

        {{-- Contenido --}}
        <div style="position:relative;z-index:2;width:100%;max-width:1200px;margin:0 auto;padding:0 6%;min-height:inherit;display:flex;align-items:center;">
            <div style="max-width:580px;padding:80px 0;">

                {{-- Eyebrow --}}
                <div class="h-anim-1" style="font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:#378ADD;font-weight:500;margin-bottom:14px;">
                    {{ $hero->eyebrow_text ?? 'nuvion glass · protección visual' }}
                </div>

                {{-- Título --}}
                @php
                    $t1 = $hero->title_line1 ?? 'Tus ojos merecen';
                    $t2 = $hero->title_line2 ?? 'protección';
                    $t3 = $hero->title_line3 ?? 'real';
                    $hl = $hero->title_highlight_word ?? 'real';
                @endphp
                <h1 class="h-anim-2" style="font-size:clamp(36px,5vw,62px);font-weight:800;color:#0d1117;line-height:1.04;letter-spacing:-.025em;margin-bottom:20px;font-family:'Bai Jamjuree',sans-serif;">
                    {{ $t1 }}<br>{{ $t2 }}<br>
                    @if($hl && str_contains($t3, $hl))
                        {!! str_replace($hl, '<span style="color:#378ADD;">'.$hl.'</span>', e($t3)) !!}
                    @else
                        {{ $t3 }}
                    @endif
                </h1>

                {{-- Badge 2x1 --}}
                <div class="h-anim-3" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.85);border:1px solid #BFDBFE;border-radius:8px;padding:9px 16px;font-size:13px;color:#1e40af;margin-bottom:20px;backdrop-filter:blur(4px);width:fit-content;">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <rect x="1" y="3.5" width="12" height="9" rx="1.5" stroke="#1e40af" stroke-width="1.2"/>
                        <path d="M5 3.5V3a2 2 0 014 0v.5" stroke="#1e40af" stroke-width="1.2"/>
                    </svg>
                    {!! str_replace(
                        ['2x1', '$499.90'],
                        ['<strong>2x1</strong>', '<strong>$499.90</strong>'],
                        e($hero->badge_text ?? '2x1 en todos los lentes · $499.90 c/u')
                    ) !!}
                </div>

                {{-- Subtítulo --}}
                <p class="h-anim-4" style="font-size:16px;color:#4b5563;line-height:1.65;margin-bottom:30px;max-width:420px;">
                    {{ $hero->subtitle ?? 'Con o sin graduación. Filtro de luz azul de alta eficiencia.' }}
                </p>

                {{-- Botones --}}
                <div class="h-anim-5" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:28px;">
                    <a href="{{ $hero->btn_primary_url ?? '/lentes' }}" class="h-btn-dark">
                        {{ $hero->btn_primary_text ?? 'Ver lentes' }} →
                    </a>
                    <a href="{{ $hero->btn_secondary_url ?? '/que-es-la-luz-azul' }}" class="h-btn-outline">
                        {{ $hero->btn_secondary_text ?? '¿Qué es la luz azul?' }}
                    </a>
                </div>

                {{-- Trust items --}}
                @php
                    $trustItems = $hero->trust_items ?? ['Envío gratis +$999', 'Garantía 6 meses', '30 días devolución'];
                @endphp
                <div class="h-anim-6" style="display:flex;gap:16px;flex-wrap:wrap;">
                    @foreach($trustItems as $item)
                    <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#6b7280;">
                        <span style="color:#22c55e;font-size:11px;">✓</span>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- Trust bar sobre el borde inferior --}}
        <div style="position:absolute;bottom:0;left:0;right:0;z-index:3;">
            <div class="h-trust-bar" style="background:rgba(255,255,255,0.92);backdrop-filter:blur(8px);border-top:1px solid rgba(0,0,0,0.06);">
                <div class="h-trust-item">
                    <div class="h-trust-icon">✓</div>
                    Filtro certificado
                </div>
                <div class="h-trust-item">
                    <div class="h-trust-icon">📦</div>
                    Envío gratis +$999
                </div>
                <div class="h-trust-item">
                    <div class="h-trust-icon">↩</div>
                    30 días devolución
                </div>
                <div class="h-trust-item">
                    <div class="h-trust-icon">★</div>
                    Garantía 6 meses
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================================================
         2. TARJETAS DE CATEGORÍA
         ============================================================ --}}
    <section class="py-16 md:py-24" style="background: #F4F6F9;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto reveal">
                <span class="inline-block text-sm font-semibold tracking-wider uppercase mb-3" style="color: #378ADD;">{{ $homePage->categories_label ?? 'Categorías' }}</span>
                <h2 class="font-brand text-3xl md:text-4xl font-bold" style="color: #1a1a2e;">{{ $homePage->categories_title ?? 'Encuentra tus lentes ideales' }}</h2>
                <p class="mt-4" style="color: #6b7280;">{{ $homePage->categories_subtitle ?? 'Con o sin graduación, tenemos el modelo perfecto para ti.' }}</p>
            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-6 md:gap-8">
                @foreach(($homePage->category_cards ?? []) as $catIndex => $cat)
                <a href="{{ route('products.index', ['tipo' => $cat['link_param'] ?? '']) }}"
                   class="reveal group bg-white rounded-2xl p-6 md:p-8 text-center border transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                   style="border-color: #e5e7eb; transition-delay: {{ $catIndex * 120 }}ms;"
                   onmouseover="this.style.borderColor='#378ADD';this.style.boxShadow='0 20px 40px rgba(55,138,221,0.12)'"
                   onmouseout="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
                    <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center transition-transform duration-300 group-hover:scale-110"
                         style="background: rgba(55,138,221,0.1);">
                        <svg class="w-7 h-7" style="color: #378ADD;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $cat['icon_svg'] ?? '' !!}
                        </svg>
                    </div>
                    <h3 class="mt-5 font-brand text-lg font-semibold" style="color: #1a1a2e;">{{ $cat['name'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed" style="color: #6b7280;">{{ $cat['description'] ?? '' }}</p>
                    <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold transition-all duration-200 group-hover:gap-2"
                          style="color: #378ADD;">
                        Ver modelos
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         3. CATÁLOGO DE PRODUCTOS CON FILTROS (client-side)
         ============================================================ --}}
    <section class="py-16 md:py-24 bg-white"
             x-data="{
                activeType: 'all',
                activeColor: null,
                filterProducts() {
                    const cards = document.querySelectorAll('[data-product-card]');
                    cards.forEach(card => {
                        const type = card.dataset.type;
                        const colors = card.dataset.colors ? card.dataset.colors.split(',') : [];
                        const matchType = this.activeType === 'all' || type === this.activeType;
                        const matchColor = !this.activeColor || colors.includes(this.activeColor);
                        card.style.display = (matchType && matchColor) ? '' : 'none';
                    });
                }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center max-w-2xl mx-auto reveal">
                <span class="inline-block text-sm font-semibold tracking-wider uppercase mb-3" style="color: #378ADD;">{{ $homePage->catalog_label ?? 'Catálogo' }}</span>
                <h2 class="font-brand text-3xl md:text-4xl font-bold" style="color: #1a1a2e;">{{ $homePage->catalog_title ?? 'Nuestros lentes' }}</h2>
                <p class="mt-4" style="color: #6b7280;">{{ $homePage->catalog_subtitle ?? 'Todos con filtro de luz azul y promoción 2×1.' }}</p>
            </div>

            {{-- Filtros --}}
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-6 reveal">
                {{-- Filtro por tipo --}}
                <div class="flex flex-wrap justify-center gap-2">
                    @php
                    $typeFilters = [
                        ['key' => 'all', 'label' => 'Todos'],
                        ['key' => 'sin_graduacion', 'label' => 'Sin Graduación'],
                        ['key' => 'lectura', 'label' => 'Lectura'],
                        ['key' => 'miopia', 'label' => 'Miopía'],
                    ];
                    @endphp
                    @foreach($typeFilters as $filter)
                    <button @click="activeType = '{{ $filter['key'] }}'; filterProducts()"
                            class="px-4 py-2 rounded-full text-sm font-medium border transition-all duration-200"
                            :style="activeType === '{{ $filter['key'] }}'
                                ? 'background: #378ADD; color: white; border-color: #378ADD;'
                                : 'background: white; color: #6b7280; border-color: #e5e7eb;'"
                            :class="activeType === '{{ $filter['key'] }}' ? 'shadow-md' : 'hover:border-gray-400'">
                        {{ $filter['label'] }}
                    </button>
                    @endforeach
                </div>

                {{-- Separador --}}
                <div class="hidden sm:block w-px h-8" style="background: #e5e7eb;"></div>

                {{-- Filtro por color --}}
                <div class="flex flex-wrap justify-center items-center gap-2">
                    <span class="text-xs font-medium mr-1" style="color: #9ca3af;">Color:</span>
                    <button @click="activeColor = null; filterProducts()"
                            class="w-7 h-7 rounded-full border-2 transition-all duration-200 flex items-center justify-center"
                            :style="!activeColor ? 'border-color: #378ADD;' : 'border-color: #e5e7eb;'"
                            title="Todos los colores">
                        <span class="text-xs font-bold" style="color: #6b7280;">∅</span>
                    </button>
                    @foreach(\App\Helpers\ColorHelper::all() as $colorName => $hex)
                        @if($coloresDisponibles->contains($colorName))
                        <button @click="activeColor = activeColor === '{{ $colorName }}' ? null : '{{ $colorName }}'; filterProducts()"
                                class="w-7 h-7 rounded-full border-2 transition-all duration-200 hover:scale-110"
                                :style="activeColor === '{{ $colorName }}' ? 'border-color: #378ADD; box-shadow: 0 0 0 2px rgba(55,138,221,0.3);' : 'border-color: #e5e7eb;'"
                                style="background: {{ $hex }};"
                                title="{{ $colorName }}">
                        </button>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Grid de productos --}}
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($lentes as $index => $product)
                <div data-product-card
                     data-type="{{ $product->type }}"
                     data-colors="{{ $product->variants->where('is_active', true)->pluck('color')->unique()->filter()->implode(',') }}"
                     class="reveal group bg-white rounded-2xl overflow-hidden border transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                     style="border-color: #e5e7eb; transition-delay: {{ ($index % 6) * 100 }}ms;"
                     onmouseover="this.style.borderColor='rgba(55,138,221,0.3)';this.style.boxShadow='0 20px 40px rgba(55,138,221,0.1)'"
                     onmouseout="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
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
                            <div class="w-full h-full flex items-center justify-center relative"
                                 style="background: linear-gradient(135deg, rgba(55,138,221,0.08), rgba(0,47,109,0.12));">
                                <div class="absolute inset-0 overflow-hidden">
                                    <div class="absolute top-6 right-6 w-20 h-20 rounded-full blur-xl" style="background: rgba(55,138,221,0.1);"></div>
                                    <div class="absolute bottom-8 left-8 w-16 h-16 rounded-full blur-lg" style="background: rgba(0,47,109,0.1);"></div>
                                </div>
                                <div class="relative text-center transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-20 h-20 mx-auto" style="color: rgba(55,138,221,0.25);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                    <p class="mt-1 text-xs font-semibold tracking-wide" style="color: rgba(55,138,221,0.4);">Foto próximamente</p>
                                </div>
                            </div>
                        @endif

                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                            @if($product->compare_price && $product->compare_price > $product->price)
                                @php $discount = round((1 - $product->price / $product->compare_price) * 100); @endphp
                                <span class="text-white text-xs font-bold px-3 py-1 rounded-full" style="background: #378ADD;">-{{ $discount }}%</span>
                            @endif
                            @if($product->badge_2x1)
                                <span class="text-white text-xs font-bold px-3 py-1 rounded-full" style="background: #002F6D;">2×1</span>
                            @endif
                        </div>
                    </a>

                    {{-- Info --}}
                    <div class="p-5 md:p-6">
                        <p class="text-xs font-medium uppercase tracking-wide" style="color: #378ADD;">
                            {{ str_replace('_', ' ', $product->type) }}
                        </p>
                        <h3 class="mt-1 font-brand text-lg font-semibold" style="color: #1a1a2e;">{{ $product->name }}</h3>
                        <p class="mt-1.5 text-sm leading-relaxed line-clamp-2" style="color: #6b7280;">{{ $product->description }}</p>

                        {{-- Colores disponibles --}}
                        @php $productColors = $product->variants->where('is_active', true)->pluck('color')->unique()->filter(); @endphp
                        @if($productColors->count() > 0)
                        <div class="mt-3 flex items-center gap-1.5">
                            @foreach($productColors->take(6) as $colorName)
                            <span class="w-4 h-4 rounded-full border" style="background: {{ \App\Helpers\ColorHelper::hex($colorName) }}; border-color: #e5e7eb;" title="{{ $colorName }}"></span>
                            @endforeach
                            @if($productColors->count() > 6)
                            <span class="text-xs" style="color: #9ca3af;">+{{ $productColors->count() - 6 }}</span>
                            @endif
                        </div>
                        @endif

                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold" style="color: #002F6D;">${{ number_format($product->price, 0, '.', ',') }}</span>
                                @if($product->compare_price && $product->compare_price > $product->price)
                                    <span class="ml-1.5 text-sm line-through" style="color: #9ca3af;">${{ number_format($product->compare_price, 0, '.', ',') }}</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}"
                               class="text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0"
                               style="background: #002F6D;"
                               onmouseover="this.style.background='#003d8f';this.style.boxShadow='0 4px 12px rgba(0,47,109,0.3)'"
                               onmouseout="this.style.background='#002F6D';this.style.boxShadow='none'">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 font-semibold text-base hover:underline" style="color: #378ADD;">
                    Ver catálogo completo
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================
         4. BANNER 2×1
         ============================================================ --}}
    <section class="relative py-16 md:py-24 overflow-hidden"
             style="background: linear-gradient(135deg, #002F6D 0%, #001a40 100%);">
        {{-- Decorativos --}}
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-[100px] pointer-events-none"
             style="background: rgba(55,138,221,0.15); animation: pulseDot 5s ease-in-out infinite;"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full blur-[80px] pointer-events-none"
             style="background: rgba(0,47,109,0.3); animation: pulseDot 7s ease-in-out 1s infinite;"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="reveal">
                    <span class="inline-block text-sm font-bold tracking-wider uppercase mb-4 px-3 py-1 rounded-full"
                          style="color: #378ADD; background: rgba(55,138,221,0.15);">{{ $homePage->promo_label ?? 'Promoción' }}</span>
                    <h2 class="font-brand text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-[1.1]">
                        {!! nl2br(e($homePage->promo_title ?? '2×1 en todos los lentes')) !!}
                    </h2>
                    <p class="mt-5 text-lg leading-relaxed" style="color: rgba(255,255,255,0.7);">
                        {{ $homePage->promo_description ?? 'Compra un par y llévate el segundo completamente gratis. Todos los modelos, todos los colores, todas las graduaciones.' }}
                    </p>
                    <div class="mt-4 flex items-center gap-3">
                        <span class="text-3xl font-bold text-white">{{ $homePage->promo_price ?? '$499.90' }}</span>
                        <span class="text-sm" style="color: rgba(255,255,255,0.5);">{{ $homePage->promo_price_note ?? 'por par · el segundo es gratis' }}</span>
                    </div>
                    <a href="{{ route('products.index') }}"
                       class="mt-8 inline-flex items-center justify-center text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0"
                       style="background: #378ADD; box-shadow: 0 10px 30px rgba(55,138,221,0.3);"
                       onmouseover="this.style.background='#2d7acc';this.style.boxShadow='0 14px 35px rgba(55,138,221,0.4)'"
                       onmouseout="this.style.background='#378ADD';this.style.boxShadow='0 10px 30px rgba(55,138,221,0.3)'">
                        {{ $homePage->promo_btn_text ?? 'Aprovecha ahora' }}
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

                {{-- Visual decorativo --}}
                <div class="reveal delay-200 hidden lg:flex items-center justify-center">
                    <div class="relative">
                        <div class="w-64 h-64 rounded-full flex items-center justify-center"
                             style="background: rgba(55,138,221,0.1); border: 1px solid rgba(55,138,221,0.2);">
                            <div class="w-48 h-48 rounded-full flex items-center justify-center"
                                 style="background: rgba(55,138,221,0.15); border: 1px solid rgba(55,138,221,0.25);">
                                <span class="font-brand text-7xl font-bold text-white">2×1</span>
                            </div>
                        </div>
                        <div class="absolute -top-4 -right-4 px-4 py-2 rounded-xl text-white text-sm font-bold"
                             style="background: #378ADD; animation: pulseDot 3s ease-in-out infinite;">
                            ¡GRATIS!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         5. TOALLITAS
         ============================================================ --}}
    <section class="py-16 md:py-24" style="background: #F4F6F9;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Texto --}}
                <div class="reveal">
                    <span class="inline-block text-sm font-semibold tracking-wider uppercase mb-3" style="color: #378ADD;">{{ $homePage->wipes_label ?? 'Accesorios' }}</span>
                    <h2 class="font-brand text-3xl md:text-4xl font-bold" style="color: #1a1a2e;">{{ $homePage->wipes_title ?? 'Cuida tus lentes' }}</h2>
                    <p class="mt-4 leading-relaxed" style="color: #6b7280;">
                        {{ $homePage->wipes_description ?? 'Toallitas limpiadoras 2 en 1: paño húmedo con fórmula sin alcohol + paño seco. Resultados inmediatos para lentes, pantallas, cámaras y tablets.' }}
                    </p>
                    <div class="mt-6 space-y-3">
                        @foreach(($homePage->wipes_features ?? []) as $fIdx => $feature)
                        <div class="flex items-center gap-3 reveal" style="transition-delay: {{ $fIdx * 80 }}ms;">
                            <span class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center"
                                  style="background: rgba(55,138,221,0.1);">
                                <svg class="w-3 h-3" style="color: #378ADD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            </span>
                            <span class="text-sm" style="color: #4b5563;">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Cards de toallitas --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($toallitas as $tIdx => $toallita)
                    <div class="reveal group bg-white rounded-2xl overflow-hidden border transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                         style="border-color: #e5e7eb; transition-delay: {{ $tIdx * 120 }}ms;"
                         onmouseover="this.style.borderColor='rgba(55,138,221,0.3)';this.style.boxShadow='0 20px 40px rgba(55,138,221,0.1)'"
                         onmouseout="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
                        {{-- Imagen --}}
                        <a href="{{ route('products.show', $toallita->slug) }}" class="block relative aspect-square overflow-hidden">
                            @if($toallita->images && count($toallita->images) > 0)
                                <div class="w-full h-full bg-white flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $toallita->images[0]) }}"
                                         alt="{{ $toallita->name }}"
                                         class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105"
                                         loading="lazy">
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center"
                                     style="background: linear-gradient(135deg, rgba(55,138,221,0.06), rgba(0,47,109,0.1));">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 mx-auto" style="color: rgba(55,138,221,0.2);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                                        </svg>
                                    </div>
                                </div>
                            @endif
                        </a>
                        {{-- Info --}}
                        <div class="p-4">
                            <h3 class="font-brand text-sm font-semibold leading-tight" style="color: #1a1a2e;">{{ $toallita->name }}</h3>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xl font-bold" style="color: #002F6D;">${{ number_format($toallita->price, 0, '.', ',') }}</span>
                                <a href="{{ route('products.show', $toallita->slug) }}"
                                   class="text-white px-4 py-2 rounded-lg text-xs font-semibold transition-all duration-200 hover:-translate-y-0.5"
                                   style="background: #002F6D;"
                                   onmouseover="this.style.background='#003d8f'"
                                   onmouseout="this.style.background='#002F6D'">
                                    Ver producto
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         6. FAQ + CONFIANZA + CTA FINAL
         ============================================================ --}}
    {{-- FAQ --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-block text-sm font-semibold tracking-wider uppercase mb-3" style="color: #378ADD;">FAQ</span>
                <h2 class="font-brand text-3xl md:text-4xl font-bold" style="color: #1a1a2e;">Preguntas frecuentes</h2>
                <p class="mt-4" style="color: #6b7280;">Todo lo que necesitas saber antes de proteger tu visión.</p>
            </div>

            <div class="mt-12 max-w-3xl mx-auto space-y-3 reveal visible" x-data="{ openFaq: null }">
                @foreach(($homePage->faqs ?? []) as $index => $faq)
                <div class="border rounded-xl overflow-hidden" style="border-color: #e5e7eb; background: #F4F6F9;">
                    <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                            class="w-full flex items-center justify-between px-5 md:px-6 py-4 text-left transition-all duration-200 group"
                            :style="openFaq === {{ $index }} ? 'background: white;' : ''"
                            onmouseover="if(!this.classList.contains('bg-white'))this.style.background='white'"
                            onmouseout="this.style.background=''">
                        <span class="font-semibold pr-4 transition-colors duration-200"
                              :style="openFaq === {{ $index }} ? 'color: #378ADD;' : 'color: #1a1a2e;'">{{ $faq['q'] }}</span>
                        <span class="flex-shrink-0 w-8 h-8 rounded-full bg-white border flex items-center justify-center"
                              style="border-color: #e5e7eb;">
                            <svg :class="openFaq === {{ $index }} ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" style="color: #002F6D;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <p class="leading-relaxed" style="color: #6b7280;">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Confianza + CTA Final --}}
    <section class="relative py-16 md:py-24 overflow-hidden"
             style="background: linear-gradient(135deg, #0A0E1A 0%, #001a40 50%, #0A0E1A 100%);">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-[100px] pointer-events-none"
             style="background: rgba(55,138,221,0.08); animation: pulseDot 5s ease-in-out infinite;"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Trust badges --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 mb-16">
                @foreach(($homePage->trust_badges ?? []) as $bIdx => $badge)
                <div class="reveal text-center" style="transition-delay: {{ $bIdx * 100 }}ms;">
                    <div class="w-12 h-12 mx-auto rounded-xl flex items-center justify-center"
                         style="background: rgba(55,138,221,0.15);">
                        <svg class="w-6 h-6" style="color: #378ADD;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $badge['icon_svg'] ?? '' !!}
                        </svg>
                    </div>
                    <h3 class="mt-3 font-brand text-sm font-semibold text-white">{{ $badge['title'] }}</h3>
                    <p class="mt-1 text-xs" style="color: rgba(255,255,255,0.5);">{{ $badge['description'] ?? '' }}</p>
                </div>
                @endforeach
            </div>

            {{-- Separador --}}
            <div class="flex justify-center my-12 md:my-16">
                <div class="w-24 h-px" style="background: linear-gradient(90deg, transparent, rgba(55,138,221,0.3), transparent);"></div>
            </div>

            {{-- CTA --}}
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="font-brand text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight reveal">
                    {{ $homePage->cta_title ?? '¿Listo para proteger tu visión?' }}
                </h2>
                <p class="mt-6 text-lg leading-relaxed max-w-xl mx-auto reveal" style="color: rgba(255,255,255,0.65);">
                    {{ $homePage->cta_subtitle ?? 'Ve mejor, duerme mejor, rinde más. Únete a quienes ya cuidan sus ojos con nuvion.' }}
                </p>
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 reveal">
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center justify-center text-white px-10 py-4 rounded-xl font-semibold text-lg transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0"
                       style="background: #378ADD; box-shadow: 0 10px 30px rgba(55,138,221,0.3);"
                       onmouseover="this.style.background='#2d7acc';this.style.boxShadow='0 14px 35px rgba(55,138,221,0.4)'"
                       onmouseout="this.style.background='#378ADD';this.style.boxShadow='0 10px 30px rgba(55,138,221,0.3)'">
                        {{ $homePage->cta_btn_primary_text ?? 'Comprar ahora' }}
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="{{ route('blue-light') }}"
                       class="inline-flex items-center justify-center border px-10 py-4 rounded-xl font-medium text-lg transition-colors"
                       style="border-color: rgba(255,255,255,0.25); color: white;"
                       onmouseover="this.style.background='rgba(255,255,255,0.08)'"
                       onmouseout="this.style.background='transparent'">
                        {{ $homePage->cta_btn_secondary_text ?? 'Aprende más' }}
                    </a>
                </div>

                <div class="mt-12 flex flex-wrap items-center justify-center gap-4 sm:gap-6 text-sm"
                     style="color: rgba(255,255,255,0.4);">
                    @foreach(($homePage->cta_trust_items ?? []) as $ctaIdx => $trustItem)
                        @if($ctaIdx > 0)
                            <span class="hidden sm:inline">·</span>
                        @endif
                        <span>{{ $trustItem }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection
