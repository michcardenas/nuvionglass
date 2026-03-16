<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') | nuvion - glass</title>
    <link rel="icon" type="image/png" href="{{ asset('img/isotipo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 font-body min-h-screen" x-data="{ sidebarOpen: true }">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-primary text-white transition-all duration-300 flex flex-col shrink-0">
            <div class="p-4 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('img/isotipo.png') }}" alt="nuvion - glass" class="h-8 w-8 object-contain shrink-0">
                    <span x-show="sidebarOpen" class="font-brand text-lg text-secondary">nuvion</span>
                    <span x-show="sidebarOpen" class="text-xs text-white/60 uppercase tracking-wider">admin</span>
                </a>
            </div>

            <nav class="flex-1 py-4 space-y-1 px-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 12 8.954-8.955a1.126 1.126 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.products.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <span x-show="sidebarOpen">Productos</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.categories.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6h.008v.008H6V6Z"/>
                    </svg>
                    <span x-show="sidebarOpen">Categorías</span>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.orders.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                    </svg>
                    <span x-show="sidebarOpen">Órdenes</span>
                </a>
                <a href="{{ route('admin.discount-codes.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.discount-codes.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z"/>
                    </svg>
                    <span x-show="sidebarOpen">Descuentos</span>
                </a>
                <a href="{{ route('admin.shipping.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.shipping.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                    </svg>
                    <span x-show="sidebarOpen">Envíos</span>
                </a>
                <a href="{{ route('admin.leads.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.leads.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                    <span x-show="sidebarOpen">Leads</span>
                </a>
                <a href="{{ route('admin.blog.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.blog.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5"/>
                    </svg>
                    <span x-show="sidebarOpen">Blog</span>
                </a>
                <a href="{{ route('admin.infographics.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm {{ request()->routeIs('admin.infographics.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                    </svg>
                    <span x-show="sidebarOpen">Infografías</span>
                </a>
            </nav>

            {{-- User / Logout --}}
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-sm font-bold shrink-0">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div x-show="sidebarOpen" class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-white/60 hover:text-white">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top bar --}}
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h1>
                </div>
                <a href="{{ route('home') }}" target="_blank" class="text-sm text-secondary hover:underline">Ver tienda &rarr;</a>
            </header>

            {{-- Page content --}}
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                         x-transition class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                         x-transition class="mb-6 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
