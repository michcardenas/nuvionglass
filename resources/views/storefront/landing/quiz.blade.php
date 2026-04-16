@extends('layouts.app')

@section('body_class', 'bg-bg text-text')

@section('title', '¿Qué lentes necesitas? — Quiz | Nuvion Glass')
@section('meta_description', 'Responde 4 preguntas y descubre qué lentes con protección de luz azul son perfectos para ti. Quiz interactivo de nuvion glass.')

@section('content')

    <section class="min-h-[80vh] flex items-center py-12">
        <div class="w-full max-w-2xl mx-auto px-4 sm:px-6"
             x-data="quizApp()"
             x-cloak>

            {{-- Progress bar --}}
            <div class="mb-8" x-show="step <= totalSteps">
                <div class="flex justify-between text-xs text-muted/50 mb-2">
                    <span>Pregunta <span x-text="step"></span> de <span x-text="totalSteps"></span></span>
                    <span x-text="Math.round((step / totalSteps) * 100) + '%'"></span>
                </div>
                <div class="h-1.5 bg-surface rounded-full overflow-hidden">
                    <div class="h-full bg-secondary rounded-full transition-all duration-500"
                         :style="'width: ' + ((step / totalSteps) * 100) + '%'"></div>
                </div>
            </div>

            {{-- Step 1: Usage --}}
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-brand text-2xl md:text-3xl font-bold mb-2">¿Para qué usarás tus lentes?</h2>
                <p class="text-muted/60 mb-8">Selecciona tu uso principal.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <button @click="answers.usage = 'screen'; nextStep()"
                            class="group bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.usage === 'screen' ? 'border-secondary' : 'border-border'">
                        <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/></svg>
                        </div>
                        <h3 class="font-semibold">Trabajo / Oficina</h3>
                        <p class="text-sm text-muted/50 mt-1">Computadora, laptop, reuniones virtuales</p>
                    </button>

                    <button @click="answers.usage = 'gaming'; nextStep()"
                            class="group bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.usage === 'gaming' ? 'border-secondary' : 'border-border'">
                        <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.491 48.491 0 0 1-4.163-.3c-1.543-.2-2.766-1.363-3.03-2.893a16.867 16.867 0 0 1-.236-2.634c0-1.548 1.294-2.78 2.834-2.612A48.394 48.394 0 0 1 12 5.04a48.394 48.394 0 0 1 6.052-.498c1.54-.168 2.834 1.064 2.834 2.612a16.88 16.88 0 0 1-.236 2.634c-.264 1.53-1.487 2.693-3.03 2.893a48.49 48.49 0 0 1-4.163.3.64.64 0 0 1-.657-.643v0Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11.25a3 3 0 1 1-6 0v-2.625"/></svg>
                        </div>
                        <h3 class="font-semibold">Gaming</h3>
                        <p class="text-sm text-muted/50 mt-1">Sesiones largas de videojuegos</p>
                    </button>

                    <button @click="answers.usage = 'study'; nextStep()"
                            class="group bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.usage === 'study' ? 'border-secondary' : 'border-border'">
                        <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>
                        </div>
                        <h3 class="font-semibold">Estudio</h3>
                        <p class="text-sm text-muted/50 mt-1">Clases online, lectura digital</p>
                    </button>

                    <button @click="answers.usage = 'general'; nextStep()"
                            class="group bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.usage === 'general' ? 'border-secondary' : 'border-border'">
                        <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                        </div>
                        <h3 class="font-semibold">Uso general</h3>
                        <p class="text-sm text-muted/50 mt-1">Celular, tablet, TV</p>
                    </button>
                </div>
            </div>

            {{-- Step 2: Hours --}}
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-brand text-2xl md:text-3xl font-bold mb-2">¿Cuántas horas al día usas pantallas?</h2>
                <p class="text-muted/60 mb-8">Incluye trabajo, estudio y tiempo libre.</p>

                <div class="space-y-3">
                    <template x-for="option in hoursOptions" :key="option.value">
                        <button @click="answers.hours = option.value; nextStep()"
                                class="w-full bg-surface border-2 rounded-xl p-5 text-left transition-all hover:border-secondary flex items-center justify-between"
                                :class="answers.hours === option.value ? 'border-secondary' : 'border-border'">
                            <div>
                                <h3 class="font-semibold" x-text="option.label"></h3>
                                <p class="text-sm text-muted/50 mt-0.5" x-text="option.desc"></p>
                            </div>
                            <svg class="w-5 h-5 text-secondary flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Step 3: Prescription --}}
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-brand text-2xl md:text-3xl font-bold mb-2">¿Necesitas graduación?</h2>
                <p class="text-muted/60 mb-8">Si usas lentes con receta, podemos integrar tu graduación.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <button @click="answers.prescription = 'no'; nextStep()"
                            class="bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.prescription === 'no' ? 'border-secondary' : 'border-border'">
                        <div class="w-10 h-10 bg-success/10 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        </div>
                        <h3 class="font-semibold">No, sin graduación</h3>
                        <p class="text-sm text-muted/50 mt-1">Solo protección de luz azul</p>
                    </button>

                    <button @click="answers.prescription = 'yes'; nextStep()"
                            class="bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.prescription === 'yes' ? 'border-secondary' : 'border-border'">
                        <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        </div>
                        <h3 class="font-semibold">Sí, con graduación</h3>
                        <p class="text-sm text-muted/50 mt-1">Miopía, astigmatismo o lectura</p>
                    </button>
                </div>
            </div>

            {{-- Step 4: Style --}}
            <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-brand text-2xl md:text-3xl font-bold mb-2">¿Qué estilo prefieres?</h2>
                <p class="text-muted/60 mb-8">Elige el que más vaya contigo.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <button @click="answers.style = 'classic'; nextStep()"
                            class="bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.style === 'classic' ? 'border-secondary' : 'border-border'">
                        <h3 class="font-semibold mb-1">Clásico</h3>
                        <p class="text-sm text-muted/50">Minimalista, discreto, para todo</p>
                    </button>
                    <button @click="answers.style = 'modern'; nextStep()"
                            class="bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.style === 'modern' ? 'border-secondary' : 'border-border'">
                        <h3 class="font-semibold mb-1">Moderno</h3>
                        <p class="text-sm text-muted/50">Trendy, llamativo, con personalidad</p>
                    </button>
                    <button @click="answers.style = 'sport'; nextStep()"
                            class="bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.style === 'sport' ? 'border-secondary' : 'border-border'">
                        <h3 class="font-semibold mb-1">Deportivo</h3>
                        <p class="text-sm text-muted/50">Resistente, grip, para actividades</p>
                    </button>
                    <button @click="answers.style = 'round'; nextStep()"
                            class="bg-surface border-2 rounded-2xl p-6 text-left transition-all hover:border-secondary"
                            :class="answers.style === 'round' ? 'border-secondary' : 'border-border'">
                        <h3 class="font-semibold mb-1">Redondo</h3>
                        <p class="text-sm text-muted/50">Sofisticado, retro, con carácter</p>
                    </button>
                </div>
            </div>

            {{-- Step 5: Lead capture --}}
            <div x-show="step === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/></svg>
                    </div>
                    <h2 class="font-brand text-2xl md:text-3xl font-bold">¡Tenemos tu recomendación!</h2>
                    <p class="mt-2 text-muted/60">Ingresa tus datos para ver el lente perfecto para ti.</p>
                </div>

                <form @submit.prevent="submitQuiz()" class="space-y-4 max-w-sm mx-auto">
                    <div>
                        <label for="quiz-name" class="block text-sm font-medium text-muted/70 mb-1">Tu nombre</label>
                        <input type="text" id="quiz-name" x-model="form.name" required
                               class="w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent placeholder-muted/30"
                               placeholder="Ej: María García">
                    </div>
                    <div>
                        <label for="quiz-email" class="block text-sm font-medium text-muted/70 mb-1">Tu email</label>
                        <input type="email" id="quiz-email" x-model="form.email" required
                               class="w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent placeholder-muted/30"
                               placeholder="tu@email.com">
                    </div>
                    <button type="submit" :disabled="loading"
                            class="w-full bg-secondary hover:bg-secondary/90 text-white py-3.5 rounded-xl font-semibold transition-colors disabled:opacity-50">
                        <span x-show="!loading">Ver mi recomendación</span>
                        <span x-show="loading" class="flex items-center justify-center">
                            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                            Procesando...
                        </span>
                    </button>
                    <p x-show="error" x-text="error" class="text-danger text-sm text-center"></p>
                </form>
            </div>

            {{-- Step 6: Result --}}
            <div x-show="step === 6" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="text-center mb-8">
                    <span class="inline-block text-secondary text-sm font-medium tracking-wider uppercase mb-2">Tu resultado</span>
                    <h2 class="font-brand text-2xl md:text-3xl font-bold">Te recomendamos</h2>
                </div>

                <div class="bg-surface rounded-2xl border border-border overflow-hidden max-w-md mx-auto">
                    <div class="aspect-[4/3] bg-bg flex items-center justify-center">
                        <template x-if="result.product_image">
                            <img :src="'/storage/' + result.product_image" :alt="result.product_name" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!result.product_image">
                            <span class="text-muted/30 text-sm" x-text="result.product_name"></span>
                        </template>
                    </div>
                    <div class="p-6">
                        <h3 class="font-brand text-xl font-bold" x-text="result.product_name"></h3>
                        <p class="mt-2 text-muted/60 text-sm" x-text="result.reason"></p>
                        <div class="mt-4 flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-secondary">$<span x-text="parseFloat(result.product_price).toFixed(2)"></span></span>
                        </div>
                        <a :href="result.product_url"
                           class="mt-6 block w-full bg-secondary hover:bg-secondary/90 text-white text-center py-3.5 rounded-xl font-semibold transition-colors">
                            Ver este producto
                        </a>
                    </div>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('products.index') }}" class="text-secondary hover:text-secondary/80 text-sm font-medium">
                        O ver todo el catálogo →
                    </a>
                </div>
            </div>

            {{-- Back button --}}
            <div class="mt-8" x-show="step > 1 && step <= totalSteps">
                <button @click="prevStep()" class="text-sm text-muted/50 hover:text-muted/80 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                    Pregunta anterior
                </button>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
<script>
    function quizApp() {
        return {
            step: 1,
            totalSteps: 4,
            loading: false,
            error: '',
            answers: {
                usage: '',
                hours: '',
                prescription: '',
                style: '',
            },
            form: {
                name: '',
                email: '',
            },
            result: {},
            hoursOptions: [
                { value: '1-3', label: 'Menos de 4 horas', desc: 'Uso moderado de pantallas' },
                { value: '4-6', label: '4 a 6 horas', desc: 'Uso frecuente, trabajo o estudio' },
                { value: '6-8', label: '6 a 8 horas', desc: 'Uso intenso, jornada completa' },
                { value: '8+', label: 'Más de 8 horas', desc: 'Uso extremo, trabajo + ocio' },
            ],
            nextStep() {
                if (this.step < 4) {
                    this.step++;
                } else {
                    this.step = 5; // Lead capture
                }
            },
            prevStep() {
                if (this.step > 1) this.step--;
            },
            async submitQuiz() {
                this.loading = true;
                this.error = '';
                try {
                    const response = await fetch('{{ route("landing.quiz.result") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            name: this.form.name,
                            email: this.form.email,
                            answers: this.answers,
                        }),
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.result = data.recommendation;
                        this.step = 6;
                    } else {
                        this.error = data.message || 'Ocurrió un error. Intenta de nuevo.';
                    }
                } catch (e) {
                    this.error = 'Error de conexión. Verifica tu internet e intenta de nuevo.';
                } finally {
                    this.loading = false;
                }
            },
        };
    }
</script>
@endpush
