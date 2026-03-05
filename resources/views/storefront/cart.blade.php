@extends('layouts.app')

@section('title', 'Carrito de compras | nuvion - glass')

@section('content')
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-brand text-3xl font-bold">Tu carrito</h1>

            {{-- TODO: Cart items from CartService --}}
            <div class="mt-8">
                <p class="text-muted/50 text-center py-20">Tu carrito está vacío.</p>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('checkout.index') }}" class="bg-secondary hover:bg-secondary/90 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                    Ir al checkout
                </a>
            </div>
        </div>
    </section>
@endsection
