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
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- TODO: Product detail with gallery, variants, cart button, trust badges --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="aspect-square bg-border-light rounded-2xl flex items-center justify-center border border-border-light">
                    <span class="text-text-muted/50">Galería de producto</span>
                </div>
                <div>
                    <h1 class="font-brand text-3xl font-bold">Nombre del producto</h1>
                    <p class="mt-4 text-text-muted">Descripción del producto (Fase 3).</p>
                    <div class="mt-6">
                        <span class="text-3xl font-bold text-secondary">$XXX</span>
                    </div>
                    <button class="mt-8 w-full bg-secondary hover:bg-secondary/90 text-white py-3 rounded-lg font-medium transition-colors">
                        Agregar al carrito
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
