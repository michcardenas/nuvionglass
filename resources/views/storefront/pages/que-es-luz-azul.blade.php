@extends('layouts.app')

@section('title', '¿Qué es la luz azul? | nuvion - glass')
@section('meta_description', '¿Qué es la luz azul y por qué es dañina? Aprende cómo proteger tus ojos de pantallas, focos LED y más. Guía completa de nuvion glass.')
@section('canonical', route('blue-light'))
@section('og_title', '¿Qué es la luz azul? | nuvion - glass')
@section('og_description', 'Aprende cómo la luz azul afecta tus ojos y cómo protegerte con lentes especializados.')
@section('twitter_title', '¿Qué es la luz azul? | nuvion - glass')
@section('twitter_description', 'Aprende cómo la luz azul afecta tus ojos y cómo protegerte con lentes especializados.')

@push('schema')
    {!! $faqSchema !!}
    {!! $breadcrumbSchema !!}
@endpush

@section('content')
    <section class="py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-brand text-3xl md:text-4xl font-bold">¿Qué es la luz azul?</h1>

            <div class="mt-8 prose max-w-none">
                <p class="text-lg text-text-muted leading-relaxed">
                    La luz azul es una porción del espectro de luz visible con longitud de onda entre 380 y 500 nanómetros.
                    Es emitida por el sol, pantallas de dispositivos electrónicos, focos LED y luces fluorescentes.
                </p>

                <h2 class="font-brand text-2xl font-bold mt-12">¿Por qué es dañina?</h2>
                <p class="text-text-muted leading-relaxed">
                    La exposición prolongada a la luz azul de alta energía puede causar fatiga visual digital,
                    dolores de cabeza, ojos secos y alteraciones en el ciclo circadiano que afectan la calidad del sueño.
                </p>

                <h2 class="font-brand text-2xl font-bold mt-12">¿Cómo te protegen los lentes nuvion?</h2>
                <p class="text-text-muted leading-relaxed">
                    Nuestros lentes están equipados con un filtro especial que bloquea entre el 30% y 50% de la luz azul dañina,
                    reduciendo significativamente la fatiga visual y mejorando tu comodidad frente a pantallas.
                </p>

                <h2 class="font-brand text-2xl font-bold mt-12">¿Quién debería usar lentes con protección de luz azul?</h2>
                <ul class="mt-4 space-y-2 text-text-muted">
                    <li>Personas que trabajan frente a una computadora 6+ horas al día</li>
                    <li>Gamers y streamers</li>
                    <li>Estudiantes en clases en línea</li>
                    <li>Cualquier persona que usa el celular frecuentemente</li>
                    <li>Personas con dificultad para dormir por uso nocturno de pantallas</li>
                </ul>
            </div>

            <div class="mt-12">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center bg-secondary hover:bg-secondary/90 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                    Ver nuestros lentes
                </a>
            </div>
        </div>
    </section>
@endsection
