@extends('layouts.app')

@section('title', 'Checkout | nuvion - glass')

@section('content')
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-brand text-3xl font-bold">Checkout</h1>

            {{-- TODO: Checkout form with customer info, order summary, payment --}}
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h2 class="font-brand text-xl font-semibold mb-6">Datos de envío</h2>
                    <p class="text-muted/50">Formulario de checkout (Fase 3).</p>
                </div>
                <div>
                    <h2 class="font-brand text-xl font-semibold mb-6">Resumen del pedido</h2>
                    <p class="text-muted/50">Resumen del carrito aquí.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
