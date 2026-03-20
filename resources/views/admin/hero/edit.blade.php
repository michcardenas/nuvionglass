@extends('layouts.admin')

@section('title', 'Gestionar Hero')
@section('page_title', 'Gestionar Hero')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start;">

            {{-- ============ COLUMNA IZQUIERDA: FORMULARIO ============ --}}
            <div style="display:flex;flex-direction:column;gap:20px;">

                {{-- Card: Contenido multimedia --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Contenido multimedia</h3>

                    {{-- Tipo de fondo --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de fondo</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="media_mode" value="video"
                                       {{ $hero->media_type === 'video' ? 'checked' : '' }}
                                       onchange="document.getElementById('media-upload').style.display='block';document.getElementById('gradient-check').style.display='none';">
                                <span class="text-sm text-gray-700">Video</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="media_mode" value="image"
                                       {{ $hero->media_type === 'image' ? 'checked' : '' }}
                                       onchange="document.getElementById('media-upload').style.display='block';document.getElementById('gradient-check').style.display='none';">
                                <span class="text-sm text-gray-700">Imagen</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="media_mode" value="gradient"
                                       {{ $hero->media_type === 'gradient' ? 'checked' : '' }}
                                       onchange="document.getElementById('media-upload').style.display='none';document.getElementById('gradient-check').style.display='block';">
                                <span class="text-sm text-gray-700">Gradiente</span>
                            </label>
                        </div>
                    </div>

                    {{-- Preview actual --}}
                    @if($hero->media_path)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Media actual</label>
                        @if($hero->media_type === 'video')
                        <video src="{{ asset('storage/' . $hero->media_path) }}"
                               style="width:100%;max-height:160px;border-radius:8px;object-fit:cover;" muted></video>
                        @else
                        <img src="{{ asset('storage/' . $hero->media_path) }}"
                             style="width:100%;max-height:160px;border-radius:8px;object-fit:cover;">
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ $hero->media_path }}</p>
                    </div>
                    @endif

                    {{-- Checkbox eliminar media --}}
                    <div id="gradient-check" style="{{ $hero->media_type === 'gradient' && !$hero->media_path ? 'display:block' : 'display:none' }}">
                        @if($hero->media_path)
                        <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer mb-3">
                            <input type="checkbox" name="use_gradient" value="1">
                            Eliminar media y usar gradiente
                        </label>
                        @else
                        <p class="text-sm text-gray-500 italic">Usando gradiente CSS por defecto.</p>
                        @endif
                    </div>

                    {{-- File upload --}}
                    <div id="media-upload" style="{{ $hero->media_type !== 'gradient' ? 'display:block' : 'display:none' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subir archivo</label>
                        <input type="file" name="media_file"
                               accept="video/mp4,video/webm,image/jpeg,image/png,image/webp"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1">Video: .mp4 recomendado, max 50MB &middot; Imagen: .jpg o .png, min 1920px de ancho</p>
                    </div>

                    {{-- Overlay opacity --}}
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Oscuridad del overlay: <span id="op-val" class="text-gray-500">{{ round($hero->overlay_opacity * 100) }}%</span>
                        </label>
                        <input type="range" name="overlay_opacity"
                               min="0.2" max="0.9" step="0.05"
                               value="{{ $hero->overlay_opacity }}"
                               class="w-full"
                               oninput="document.getElementById('op-val').textContent=Math.round(this.value*100)+'%'">
                        <p class="text-xs text-gray-400 mt-1">Mas alto = texto mas legible sobre el video/imagen</p>
                    </div>
                </div>

                {{-- Card: Textos del hero --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Textos del hero</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Eyebrow (pill superior)</label>
                            <input type="text" name="eyebrow_text" value="{{ $hero->eyebrow_text }}"
                                   placeholder="Ej: Proteccion de luz azul"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Linea 1 del titulo</label>
                                <input type="text" name="title_line1" value="{{ $hero->title_line1 }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Linea 2 del titulo</label>
                                <input type="text" name="title_line2" value="{{ $hero->title_line2 }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Linea 3 del titulo</label>
                                <input type="text" name="title_line3" value="{{ $hero->title_line3 }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Palabra a resaltar en azul</label>
                            <input type="text" name="title_highlight_word" value="{{ $hero->title_highlight_word }}"
                                   placeholder="Debe ser una palabra de la linea 3"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <p class="text-xs text-gray-400 mt-1">Esta palabra aparecera en azul (#378ADD) en el titulo</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitulo</label>
                            <textarea name="subtitle" rows="2"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ $hero->subtitle }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Texto del badge promocional</label>
                            <input type="text" name="badge_text" value="{{ $hero->badge_text }}"
                                   placeholder="Dejar vacio para ocultar el badge"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>

                {{-- Card: Botones --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Botones</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Boton principal — texto</label>
                            <input type="text" name="btn_primary_text" value="{{ $hero->btn_primary_text }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Boton principal — URL</label>
                            <input type="text" name="btn_primary_url" value="{{ $hero->btn_primary_url }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Boton secundario — texto</label>
                            <input type="text" name="btn_secondary_text" value="{{ $hero->btn_secondary_text }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Boton secundario — URL</label>
                            <input type="text" name="btn_secondary_url" value="{{ $hero->btn_secondary_url }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>

                {{-- Card: Estadisticas flotantes --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Estadisticas flotantes</h3>
                    <p class="text-xs text-gray-400 mb-3">Cards glassmorphism que flotan a la derecha del hero. Solo visibles en desktop. Dejar vacio para ocultar.</p>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stat 1 — numero</label>
                            <input type="text" name="stat1_number" value="{{ $hero->stat1_number }}"
                                   placeholder="Ej: 2x1"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stat 1 — etiqueta</label>
                            <input type="text" name="stat1_label" value="{{ $hero->stat1_label }}"
                                   placeholder="Ej: en todos los lentes"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stat 2 — numero</label>
                            <input type="text" name="stat2_number" value="{{ $hero->stat2_number }}"
                                   placeholder="Ej: 6"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stat 2 — etiqueta</label>
                            <input type="text" name="stat2_label" value="{{ $hero->stat2_label }}"
                                   placeholder="Ej: modelos disponibles"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>

                {{-- Card: Badges de confianza --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Badges de confianza</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Items (uno por linea)</label>
                        <textarea name="trust_items" rows="4"
                                  placeholder="Un item por linea:&#10;Envio gratis +$999&#10;Garantia 6 meses&#10;30 dias devolucion"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ implode("\n", $hero->trust_items ?? []) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Un item por linea. Dejar vacio para ocultar.</p>
                    </div>
                </div>

                {{-- Boton guardar --}}
                <button type="submit"
                        class="w-full py-3 rounded-xl text-white font-medium text-base transition-colors"
                        style="background:#378ADD;"
                        onmouseover="this.style.background='#185FA5'"
                        onmouseout="this.style.background='#378ADD'">
                    Guardar cambios
                </button>
            </div>

            {{-- ============ COLUMNA DERECHA: PREVIEW EN VIVO ============ --}}
            <div style="position:sticky;top:90px;">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Preview en vivo</h3>

                    <div id="hero-preview"
                         style="position:relative;height:320px;border-radius:12px;overflow:hidden;background:linear-gradient(135deg,#060d1a 0%,#0a1628 30%,#0f2440 60%,#060d1a 100%);">

                        {{-- Overlay --}}
                        <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(6,13,26,0.97) 0%,rgba(6,13,26,0.88) 30%,rgba(6,13,26,0.65) 55%,rgba(6,13,26,0.25) 75%,rgba(6,13,26,0.08) 100%);pointer-events:none;"></div>

                        {{-- Glow --}}
                        <div style="position:absolute;top:-20%;left:10%;width:200px;height:200px;background:radial-gradient(circle,rgba(56,130,221,0.12) 0%,transparent 60%);pointer-events:none;"></div>

                        {{-- Content --}}
                        <div style="position:relative;z-index:2;padding:24px 20px;max-width:280px;">

                            <div id="prev-eyebrow"
                                 style="display:inline-flex;align-items:center;gap:4px;background:rgba(56,130,221,0.12);border:0.5px solid rgba(56,130,221,0.3);border-radius:12px;padding:2px 10px;font-size:7px;color:#85B7EB;letter-spacing:.08em;text-transform:uppercase;margin-bottom:10px;">
                                {{ $hero->eyebrow_text }}
                            </div>

                            <div id="prev-title"
                                 style="font-size:18px;font-weight:800;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:8px;font-family:'Bai Jamjuree',sans-serif;">
                                @php
                                    $prevLine3 = e($hero->title_line3);
                                    if ($hero->title_highlight_word && str_contains($hero->title_line3, $hero->title_highlight_word)) {
                                        $prevLine3 = str_replace(e($hero->title_highlight_word), '<span style="color:#378ADD;">' . e($hero->title_highlight_word) . '</span>', $prevLine3);
                                    }
                                @endphp
                                {{ $hero->title_line1 }}<br>{{ $hero->title_line2 }}<br>{!! $prevLine3 !!}
                            </div>

                            <div id="prev-badge"
                                 style="display:inline-block;background:rgba(56,130,221,0.1);border:0.5px solid rgba(56,130,221,0.22);border-radius:4px;padding:3px 8px;font-size:7px;color:#85B7EB;margin-bottom:8px;{{ !$hero->badge_text ? 'display:none;' : '' }}">
                                {{ $hero->badge_text }}
                            </div>

                            <p id="prev-subtitle"
                               style="font-size:8px;color:rgba(255,255,255,0.45);line-height:1.5;margin-bottom:12px;max-width:200px;">
                                {{ $hero->subtitle }}
                            </p>

                            <div style="display:flex;gap:6px;">
                                <div id="prev-btn1"
                                     style="background:#378ADD;color:#fff;border-radius:4px;padding:4px 12px;font-size:8px;font-weight:500;">
                                    {{ $hero->btn_primary_text }} &rarr;
                                </div>
                                <div id="prev-btn2"
                                     style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:0.5px solid rgba(255,255,255,0.18);border-radius:4px;padding:4px 12px;font-size:8px;">
                                    {{ $hero->btn_secondary_text }}
                                </div>
                            </div>
                        </div>

                        {{-- Stats preview --}}
                        <div id="prev-stat1" style="position:absolute;right:12px;top:30px;background:rgba(255,255,255,0.05);border:0.5px solid rgba(255,255,255,0.1);border-radius:6px;padding:6px 10px;{{ !$hero->stat1_number ? 'display:none;' : '' }}">
                            <div style="font-size:14px;font-weight:700;color:#fff;line-height:1;" id="prev-stat1-num">{{ $hero->stat1_number }}</div>
                            <div style="font-size:6px;margin-top:2px;color:rgba(255,255,255,0.35);" id="prev-stat1-label">{{ $hero->stat1_label }}</div>
                        </div>
                        <div id="prev-stat2" style="position:absolute;right:12px;bottom:50px;background:rgba(255,255,255,0.05);border:0.5px solid rgba(255,255,255,0.1);border-radius:6px;padding:6px 10px;{{ !$hero->stat2_number ? 'display:none;' : '' }}">
                            <div style="font-size:14px;font-weight:700;color:#fff;line-height:1;" id="prev-stat2-num">{{ $hero->stat2_number }}</div>
                            <div style="font-size:6px;margin-top:2px;color:rgba(255,255,255,0.35);" id="prev-stat2-label">{{ $hero->stat2_label }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
function updatePreview() {
    var eyebrow = document.querySelector('[name="eyebrow_text"]').value;
    var t1 = document.querySelector('[name="title_line1"]').value;
    var t2 = document.querySelector('[name="title_line2"]').value;
    var t3 = document.querySelector('[name="title_line3"]').value;
    var highlight = document.querySelector('[name="title_highlight_word"]').value;
    var subtitle = document.querySelector('[name="subtitle"]').value;
    var badge = document.querySelector('[name="badge_text"]').value;
    var btn1 = document.querySelector('[name="btn_primary_text"]').value;
    var btn2 = document.querySelector('[name="btn_secondary_text"]').value;
    var s1n = document.querySelector('[name="stat1_number"]').value;
    var s1l = document.querySelector('[name="stat1_label"]').value;
    var s2n = document.querySelector('[name="stat2_number"]').value;
    var s2l = document.querySelector('[name="stat2_label"]').value;

    document.getElementById('prev-eyebrow').textContent = eyebrow;

    var titleHtml = escapeHtml(t1) + '<br>' + escapeHtml(t2) + '<br>';
    if (highlight && t3.includes(highlight)) {
        titleHtml += escapeHtml(t3).replace(escapeHtml(highlight), '<span style="color:#378ADD;">' + escapeHtml(highlight) + '</span>');
    } else {
        titleHtml += escapeHtml(t3);
    }
    document.getElementById('prev-title').innerHTML = titleHtml;

    document.getElementById('prev-subtitle').textContent = subtitle;

    var badgeEl = document.getElementById('prev-badge');
    badgeEl.textContent = badge;
    badgeEl.style.display = badge ? 'inline-block' : 'none';

    document.getElementById('prev-btn1').innerHTML = escapeHtml(btn1) + ' &rarr;';
    document.getElementById('prev-btn2').textContent = btn2;

    document.getElementById('prev-stat1-num').textContent = s1n;
    document.getElementById('prev-stat1-label').textContent = s1l;
    document.getElementById('prev-stat1').style.display = s1n ? 'block' : 'none';

    document.getElementById('prev-stat2-num').textContent = s2n;
    document.getElementById('prev-stat2-label').textContent = s2l;
    document.getElementById('prev-stat2').style.display = s2n ? 'block' : 'none';
}

function escapeHtml(text) {
    var d = document.createElement('div');
    d.textContent = text;
    return d.innerHTML;
}

document.querySelectorAll('input[type="text"], textarea').forEach(function(el) {
    el.addEventListener('input', updatePreview);
});
</script>

<style>
@media (max-width: 1024px) {
    div[style*="grid-template-columns:1fr 380px"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
