@extends('layouts.admin')

@section('title', 'Editar página del quiz')
@section('page_title', 'Página del Quiz')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6"
     x-data="{
        openSection: 'textos',
        toggle(s) { this.openSection = this.openSection === s ? null : s; }
     }">

    <p class="text-sm text-gray-500 mb-6">Edita los textos del quiz y las reglas de recomendación. Las 4 preguntas del quiz se mantienen fijas, pero puedes decidir qué producto se recomienda según las respuestas.</p>

    <form method="POST" action="{{ route('admin.pages.quiz.update') }}">
        @method('PUT')
        @csrf

        {{-- ═══════════ 1. TEXTOS ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('textos')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">1. Textos del quiz</h3>
                <svg :class="openSection === 'textos' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'textos'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título del hero</label>
                    <input type="text" name="hero_title" value="{{ $page->hero_title }}"
                           placeholder="¿Qué lentes son para ti?"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtítulo del hero</label>
                    <input type="text" name="hero_subtitle" value="{{ $page->hero_subtitle }}"
                           placeholder="Responde 4 preguntas rápidas y te recomendamos los mejores lentes para ti."
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
            </div>
        </div>

        {{-- ═══════════ 2. RESULTADO ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('resultado')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">2. Pantalla de resultado</h3>
                <svg :class="openSection === 'resultado' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'resultado'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título del resultado</label>
                    <input type="text" name="result_title" value="{{ $page->result_title }}"
                           placeholder="Tu recomendación"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Texto del botón CTA</label>
                    <input type="text" name="result_cta_text" value="{{ $page->result_cta_text }}"
                           placeholder="Ver este producto"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Razón por defecto</label>
                    <textarea name="default_reason" rows="2"
                              placeholder="Este es nuestro modelo más popular y versátil."
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ $page->default_reason }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Se muestra cuando ninguna regla de recomendación coincide.</p>
                </div>
            </div>
        </div>

        {{-- ═══════════ 3. PRODUCTO POR DEFECTO ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('default')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">3. Producto por defecto</h3>
                <svg :class="openSection === 'default' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'default'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Producto recomendado por defecto</label>
                    <select name="default_product_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">— Usar primer destacado —</option>
                        @foreach($products as $prod)
                        <option value="{{ $prod->id }}" {{ $page->default_product_id == $prod->id ? 'selected' : '' }}>{{ $prod->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Se usa cuando ninguna regla de recomendación coincide con las respuestas.</p>
                </div>
            </div>
        </div>

        {{-- ═══════════ 4. REGLAS DE RECOMENDACIÓN ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('rules')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">4. Reglas de recomendación</h3>
                <svg :class="openSection === 'rules' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'rules'" x-collapse class="px-6 pb-6">
                <p class="text-xs text-gray-500 mb-3">Define qué producto recomendar según las respuestas del quiz. La primera regla que coincida será la usada. Si ninguna coincide, se usa el producto por defecto.</p>

                <div x-data="rulesRepeater()" x-init="init()">
                    <template x-for="(rule, idx) in items" :key="idx">
                        <div class="bg-gray-50 rounded-lg p-4 mb-3">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold text-gray-500" x-text="'Regla ' + (idx + 1)"></span>
                                <button type="button" @click="items.splice(idx, 1)" class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Si la respuesta de...</label>
                                    <select :name="'recommendation_rules[' + idx + '][condition_field]'" x-model="rule.condition_field"
                                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="usage">Uso principal</option>
                                        <option value="prescription">Graduación</option>
                                        <option value="hours">Horas de uso</option>
                                        <option value="style">Estilo preferido</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">... es igual a</label>
                                    <select :name="'recommendation_rules[' + idx + '][condition_value]'" x-model="rule.condition_value"
                                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <template x-if="rule.condition_field === 'usage'">
                                            <optgroup label="Uso">
                                                <option value="screen">Trabajo / Oficina</option>
                                                <option value="gaming">Gaming</option>
                                                <option value="study">Estudio</option>
                                                <option value="general">Uso general</option>
                                            </optgroup>
                                        </template>
                                        <template x-if="rule.condition_field === 'prescription'">
                                            <optgroup label="Graduación">
                                                <option value="yes">Sí necesita</option>
                                                <option value="no">No necesita</option>
                                            </optgroup>
                                        </template>
                                        <template x-if="rule.condition_field === 'hours'">
                                            <optgroup label="Horas">
                                                <option value="1-3">Menos de 4 horas</option>
                                                <option value="4-6">4 a 6 horas</option>
                                                <option value="6-8">6 a 8 horas</option>
                                                <option value="8+">Más de 8 horas</option>
                                            </optgroup>
                                        </template>
                                        <template x-if="rule.condition_field === 'style'">
                                            <optgroup label="Estilo">
                                                <option value="classic">Clásico</option>
                                                <option value="modern">Moderno</option>
                                                <option value="sport">Deportivo</option>
                                                <option value="round">Redondo</option>
                                            </optgroup>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Recomendar producto</label>
                                    <select :name="'recommendation_rules[' + idx + '][product_id]'" x-model="rule.product_id"
                                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">— Selecciona —</option>
                                        @foreach($products as $prod)
                                        <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Razón que ve el usuario</label>
                                <input type="text" :name="'recommendation_rules[' + idx + '][reason]'" x-model="rule.reason"
                                       placeholder="Ej: Para gaming intenso necesitas filtro de alto rendimiento."
                                       class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="items.push({condition_field:'usage', condition_value:'gaming', product_id:'', reason:''})"
                            class="mt-2 flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Agregar regla
                    </button>
                </div>
            </div>
        </div>

        {{-- ═══════════ 5. SEO ═══════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4">
            <button type="button" @click="toggle('seo')"
                    class="w-full flex items-center justify-between px-6 py-4 text-left">
                <h3 class="text-base font-semibold text-gray-900">5. SEO</h3>
                <svg :class="openSection === 'seo' && 'rotate-180'" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-show="openSection === 'seo'" x-collapse class="px-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta título</label>
                    <input type="text" name="meta_title" value="{{ $page->meta_title }}"
                           placeholder="¿Qué lentes necesitas? — Quiz | Nuvion Glass"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta descripción</label>
                    <textarea name="meta_description" rows="2"
                              placeholder="Responde 4 preguntas y descubre qué lentes con protección de luz azul son perfectos para ti."
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ $page->meta_description }}</textarea>
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
function rulesRepeater() {
    return {
        items: [],
        init() {
            this.items = @json($page->recommendation_rules ?? []);
        }
    };
}
</script>
@endpush
@endsection
