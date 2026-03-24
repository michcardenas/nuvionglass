@extends('layouts.admin')

@section('title', 'Editar secciones del inicio')
@section('page_title', 'Secciones del inicio')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6"
     x-data="{
        openSection: 'categories',
        toggle(s) { this.openSection = this.openSection === s ? null : s; }
     }">

    <p class="text-sm text-gray-500 mb-6">Edita el texto, iconos y contenido de las secciones del inicio. Los cambios se reflejan inmediatamente en la tienda.</p>

    <form method="POST" action="{{ route('admin.pages.home.update') }}">
        @method('PUT')
        @csrf

        {{-- ═══════════ CATEGORÍAS ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('categories')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">Tarjetas de categoría</h3>
                <svg :class="openSection === 'categories' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'categories'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Etiqueta superior</label>
                    <input type="text" name="categories_label" value="{{ $page->categories_label }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="categories_title" value="{{ $page->categories_title }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtítulo</label>
                    <input type="text" name="categories_subtitle" value="{{ $page->categories_subtitle }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div class="border-t pt-4 mt-4">
                    <h4 class="text-sm font-semibold text-gray-800 mb-3">Tarjetas (3 categorías)</h4>
                    @php $cards = $page->category_cards ?? []; @endphp
                    @for($i = 0; $i < 3; $i++)
                    @php $card = $cards[$i] ?? ['name' => '', 'link_param' => '', 'description' => '', 'icon_svg' => '']; @endphp
                    <div class="bg-gray-50 rounded-lg p-4 mb-3" x-data="{ showSvg{{ $i }}: false }">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Nombre</label>
                                <input type="text" name="category_cards[{{ $i }}][name]" value="{{ $card['name'] }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Parámetro URL</label>
                                <input type="text" name="category_cards[{{ $i }}][link_param]" value="{{ $card['link_param'] }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="ej: sin_graduacion">
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Descripción</label>
                            <textarea name="category_cards[{{ $i }}][description]" rows="2"
                                      class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">{{ $card['description'] }}</textarea>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-center justify-between mb-1">
                                <label class="text-xs font-medium text-gray-600">Icono</label>
                                <button type="button" @click="showSvg{{ $i }} = !showSvg{{ $i }}"
                                        class="text-xs text-blue-500 hover:text-blue-700"
                                        x-text="showSvg{{ $i }} ? 'Ocultar SVG' : 'Editar SVG'"></button>
                            </div>
                            @if($card['icon_svg'])
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:rgba(55,138,221,0.1);">
                                    <svg class="w-5 h-5" style="color:#378ADD;" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $card['icon_svg'] !!}</svg>
                                </div>
                                <span class="text-xs text-gray-400">Icono actual</span>
                            </div>
                            @endif
                            <div x-show="showSvg{{ $i }}" x-collapse>
                                <textarea name="category_cards[{{ $i }}][icon_svg]" rows="3"
                                          class="w-full rounded-lg border-gray-300 shadow-sm text-xs font-mono focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Pega el contenido SVG (paths) aquí">{{ $card['icon_svg'] }}</textarea>
                                <p class="text-xs text-gray-400 mt-1">Pega solo los &lt;path&gt; internos del SVG, no el &lt;svg&gt; exterior.</p>
                            </div>
                            <input x-show="!showSvg{{ $i }}" type="hidden" name="category_cards[{{ $i }}][icon_svg]" value="{{ $card['icon_svg'] }}">
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- ═══════════ CATÁLOGO HEADER ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('catalog')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">Encabezado del catálogo</h3>
                <svg :class="openSection === 'catalog' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'catalog'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Etiqueta</label>
                    <input type="text" name="catalog_label" value="{{ $page->catalog_label }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="catalog_title" value="{{ $page->catalog_title }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtítulo</label>
                    <input type="text" name="catalog_subtitle" value="{{ $page->catalog_subtitle }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
            </div>
        </div>

        {{-- ═══════════ PROMO 2×1 ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('promo')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">Banner promoción 2×1</h3>
                <svg :class="openSection === 'promo' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'promo'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Etiqueta</label>
                    <input type="text" name="promo_label" value="{{ $page->promo_label }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="promo_title" value="{{ $page->promo_title }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="promo_description" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ $page->promo_description }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                        <input type="text" name="promo_price" value="{{ $page->promo_price }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                               placeholder="$499.90">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nota del precio</label>
                        <input type="text" name="promo_price_note" value="{{ $page->promo_price_note }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Texto del botón</label>
                    <input type="text" name="promo_btn_text" value="{{ $page->promo_btn_text }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
            </div>
        </div>

        {{-- ═══════════ TOALLITAS ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('wipes')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">Sección toallitas / accesorios</h3>
                <svg :class="openSection === 'wipes' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'wipes'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Etiqueta</label>
                    <input type="text" name="wipes_label" value="{{ $page->wipes_label }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="wipes_title" value="{{ $page->wipes_title }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="wipes_description" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ $page->wipes_description }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Características (una por línea)</label>
                    <textarea name="wipes_features_text" rows="4"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                              placeholder="Fórmula sin alcohol&#10;Sistema 2 en 1">{{ implode("\n", $page->wipes_features ?? []) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ═══════════ FAQ ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('faq')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">Preguntas frecuentes (FAQ)</h3>
                <svg :class="openSection === 'faq' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'faq'" x-collapse class="px-6 pb-6">
                @php $faqs = $page->faqs ?? []; @endphp
                <div x-data="faqRepeater()" x-init="init()">
                    <template x-for="(faq, idx) in items" :key="idx">
                        <div class="bg-gray-50 rounded-lg p-4 mb-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-gray-500" x-text="'Pregunta ' + (idx + 1)"></span>
                                <button type="button" @click="items.splice(idx, 1)" class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
                            </div>
                            <div class="mb-2">
                                <input type="text" :name="'faqs[' + idx + '][q]'" x-model="faq.q"
                                       class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Pregunta">
                            </div>
                            <div>
                                <textarea :name="'faqs[' + idx + '][a]'" x-model="faq.a" rows="3"
                                          class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Respuesta"></textarea>
                            </div>
                        </div>
                    </template>
                    <button type="button" @click="items.push({q:'', a:''})"
                            class="mt-2 flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Agregar pregunta
                    </button>
                </div>
            </div>
        </div>

        {{-- ═══════════ TRUST BADGES ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('trust')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">Badges de confianza</h3>
                <svg :class="openSection === 'trust' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'trust'" x-collapse class="px-6 pb-6">
                @php $badges = $page->trust_badges ?? []; @endphp
                <div x-data="trustRepeater()" x-init="init()">
                    <template x-for="(badge, idx) in items" :key="idx">
                        <div class="bg-gray-50 rounded-lg p-4 mb-3">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold text-gray-500" x-text="'Badge ' + (idx + 1)"></span>
                                    <template x-if="badge.icon_svg">
                                        <div class="w-7 h-7 rounded flex items-center justify-center" style="background:rgba(55,138,221,0.1);">
                                            <svg class="w-4 h-4" style="color:#378ADD;" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-html="badge.icon_svg"></svg>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="items.splice(idx, 1)" class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
                                    <input type="text" :name="'trust_badges[' + idx + '][title]'" x-model="badge.title"
                                           class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Descripción</label>
                                    <input type="text" :name="'trust_badges[' + idx + '][description]'" x-model="badge.description"
                                           class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="mt-2" x-data="{ showCustom: false }">
                                <div class="flex items-center justify-between mb-1">
                                    <label class="text-xs font-medium text-gray-600">Icono</label>
                                    <button type="button" @click="showCustom = !showCustom"
                                            class="text-xs text-blue-500 hover:text-blue-700"
                                            x-text="showCustom ? 'Ocultar SVG' : 'SVG personalizado'"></button>
                                </div>
                                <div x-show="showCustom" x-collapse>
                                    <textarea :name="'trust_badges[' + idx + '][icon_svg]'" x-model="badge.icon_svg" rows="2"
                                              class="w-full rounded-lg border-gray-300 shadow-sm text-xs font-mono focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Paths SVG"></textarea>
                                </div>
                                <input x-show="!showCustom" type="hidden" :name="'trust_badges[' + idx + '][icon_svg]'" x-model="badge.icon_svg">
                            </div>
                        </div>
                    </template>
                    <button type="button" @click="items.push({icon_svg:'', title:'', description:''})"
                            class="mt-2 flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Agregar badge
                    </button>
                </div>
            </div>
        </div>

        {{-- ═══════════ CTA FINAL ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('cta')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">CTA final</h3>
                <svg :class="openSection === 'cta' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'cta'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="cta_title" value="{{ $page->cta_title }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtítulo</label>
                    <textarea name="cta_subtitle" rows="2"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ $page->cta_subtitle }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Botón principal</label>
                        <input type="text" name="cta_btn_primary_text" value="{{ $page->cta_btn_primary_text }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Botón secundario</label>
                        <input type="text" name="cta_btn_secondary_text" value="{{ $page->cta_btn_secondary_text }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Línea de confianza (una por línea)</label>
                    <textarea name="cta_trust_items_text" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                              placeholder="Envío gratis +$999&#10;Garantía 6 meses&#10;30 días de devolución">{{ implode("\n", $page->cta_trust_items ?? []) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Botón guardar --}}
        <button type="submit"
                class="w-full py-3 rounded-xl text-white font-medium text-base transition-colors"
                style="background:#378ADD;"
                onmouseover="this.style.background='#185FA5'"
                onmouseout="this.style.background='#378ADD'">
            Guardar cambios
        </button>
    </form>
</div>

@push('scripts')
<script>
function faqRepeater() {
    return {
        items: [],
        init() {
            this.items = @json($page->faqs ?? []);
        }
    };
}

function trustRepeater() {
    return {
        items: [],
        init() {
            this.items = @json($page->trust_badges ?? []);
        }
    };
}
</script>
@endpush
@endsection
