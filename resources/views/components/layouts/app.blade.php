<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Budget') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-zinc-100/70 text-zinc-900 font-sans antialiased selection:bg-zinc-900 selection:text-white">
    <div class="min-h-full flex flex-col">
        <!-- Top Navigation -->
        <nav class="sticky top-0 z-30 bg-white/95 backdrop-blur-xs border-b border-zinc-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Brand & Left Navigation Links -->
                    <div class="flex items-center gap-8">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 text-zinc-900 font-semibold tracking-tight text-base hover:opacity-90 transition">
                            <span class="w-8 h-8 rounded-lg bg-zinc-900 text-white flex items-center justify-center text-sm shadow-xs">
                                <i class="fa-solid fa-wallet"></i>
                            </span>
                            <span>Budget<span class="text-zinc-500 font-normal">Tracker</span></span>
                        </a>

                        <div class="hidden sm:flex items-center space-x-1">
                            <a href="{{ route('dashboard') }}" 
                               class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-zinc-100 text-zinc-900' : 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-50' }}">
                                <i class="fa-solid fa-gauge text-xs mr-1.5 opacity-70"></i> Dashboard
                            </a>
                            <a href="{{ route('pockets.index') }}" 
                               class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('pockets.*') ? 'bg-zinc-100 text-zinc-900' : 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-50' }}">
                                <i class="fa-solid fa-boxes-stacked text-xs mr-1.5 opacity-70"></i> Kantong
                            </a>
                            <a href="{{ route('transactions.index') }}" 
                               class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('transactions.*') ? 'bg-zinc-100 text-zinc-900' : 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-50' }}">
                                <i class="fa-solid fa-list-check text-xs mr-1.5 opacity-70"></i> Riwayat Transaksi
                            </a>
                        </div>
                    </div>

                    <!-- Right Navigation / User & Action -->
                    <div class="flex items-center gap-3">
                        <button type="button" 
                                onclick="document.getElementById('quick-transaction-modal')?.classList.remove('hidden')" 
                                class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-zinc-900 text-white text-xs font-medium hover:bg-zinc-800 transition shadow-xs">
                            <i class="fa-solid fa-plus text-[11px]"></i> Catat Transaksi
                        </button>

                        <div class="flex items-center pl-2 border-l border-zinc-200 gap-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-semibold text-zinc-900 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-zinc-500 leading-tight">{{ Auth::user()->email }}</p>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        title="Keluar" 
                                        data-confirm="Apakah Anda yakin ingin keluar dari akun?" 
                                        data-confirm-title="Keluar Akun"
                                        class="w-8 h-8 rounded-md border border-zinc-200 bg-white text-zinc-600 hover:text-zinc-900 hover:bg-zinc-50 flex items-center justify-center text-xs transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Navigation Bar -->
                <div class="sm:hidden flex items-center justify-around py-2 border-t border-zinc-100 text-xs">
                    <a href="{{ route('dashboard') }}" class="px-2 py-1 rounded {{ request()->routeIs('dashboard') ? 'font-semibold text-zinc-900' : 'text-zinc-600' }}">
                        <i class="fa-solid fa-gauge mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('pockets.index') }}" class="px-2 py-1 rounded {{ request()->routeIs('pockets.*') ? 'font-semibold text-zinc-900' : 'text-zinc-600' }}">
                        <i class="fa-solid fa-boxes-stacked mr-1"></i> Kantong
                    </a>
                    <a href="{{ route('transactions.index') }}" class="px-2 py-1 rounded {{ request()->routeIs('transactions.*') ? 'font-semibold text-zinc-900' : 'text-zinc-600' }}">
                        <i class="fa-solid fa-list mr-1"></i> Riwayat
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-auto py-6 border-t border-zinc-200/80 bg-white/50 text-xs text-zinc-500">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p>Budget & Expense Tracker — Simpel & Anti Ribet</p>
                <p class="text-zinc-400">Pockets Money Management</p>
            </div>
        </footer>
    </div>

    <!-- Quick Modal Transaction Form (Accessible from Anywhere) -->
    @include('components.quick-transaction-modal')

    <!-- Flash Messages Handler via Notiflix -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.Notiflix?.Notify?.success(@json(session('success')));
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.Notiflix?.Notify?.failure(@json(session('error')));
            });
        </script>
    @endif
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                @foreach($errors->all() as $err)
                    window.Notiflix?.Notify?.failure(@json($err));
                @endforeach
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>
