@extends('layouts.app')

@section('title', 'Blog | nuvion - glass')
@section('meta_description', 'Artículos sobre salud visual, luz azul y cómo proteger tus ojos. Blog nuvion glass.')
@section('canonical', route('blog.index'))
@section('og_title', 'Blog | nuvion - glass')
@section('og_description', 'Artículos sobre salud visual, luz azul y cómo proteger tus ojos.')
@section('twitter_title', 'Blog | nuvion - glass')
@section('twitter_description', 'Artículos sobre salud visual, luz azul y cómo proteger tus ojos.')

@push('schema')
    {!! $breadcrumbs !!}
@endpush

@section('content')
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-brand text-3xl md:text-4xl font-bold">Blog</h1>
            <p class="mt-4 text-text-muted">Consejos para cuidar tu visión y rendir más.</p>

            {{-- TODO: Blog post list from database --}}
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <p class="text-text-muted/60 col-span-full text-center py-20">Artículos del blog se cargarán aquí (Fase 3).</p>
            </div>
        </div>
    </section>
@endsection
