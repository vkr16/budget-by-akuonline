<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Budget') }}</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Local Vendor Assets: Font Awesome Pro & Notiflix AIO -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <script src="{{ asset('assets/vendor/notiflix/notiflix.min.js') }}"></script>

    <!-- Progressive Web App Meta -->
    <x-pwa-meta />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#F8FAFC] text-[#1F2937] font-sans antialiased selection:bg-[#312E81] selection:text-white">
    <div class="min-h-full flex flex-col">
        <!-- PWA Install Banner -->
        <x-pwa-install-banner />

        <!-- Top Navigation (Desktop & Mobile Header) -->
        <nav class="glass-header sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-zinc-200/90">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-17">
                    <!-- Brand & Left Navigation Links -->
                    <div class="flex items-center gap-6 sm:gap-8">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 text-slate-900 font-bold tracking-tight text-base group cursor-pointer">
                            <span class="w-9 h-9 rounded-xl bg-[#312E81] text-white flex items-center justify-center text-sm shadow-xs transition-transform group-hover:scale-105">
                                <i class="fa-regular xx fa-wallet text-[#C7D2FE]"></i>
                            </span>
                            <span class="leading-tight font-bold">
                                Budget <span class="text-[#312E81] font-semibold text-xs px-2 py-0.5 rounded-full bg-[#EEF2FF]">by AkuOnline</span>
                            </span>
                        </a>

                        <!-- Desktop Horizontal Navigation Links -->
                        <div class="hidden sm:flex items-center space-x-1.5">
                            <a href="{{ route('dashboard') }}"
                               class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center cursor-pointer {{ request()->routeIs('dashboard') ? 'bg-[#EEF2FF] text-[#312E81]' : 'text-slate-600 hover:text-[#312E81] hover:bg-[#EEF2FF]' }}">
                                <i class="fa-regular xx fa-gauge text-xs mr-1.5 opacity-80"></i> Dashboard
                            </a>
                            <a href="{{ route('pockets.index') }}"
                               class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center cursor-pointer {{ request()->routeIs('pockets.*') ? 'bg-[#EEF2FF] text-[#312E81]' : 'text-slate-600 hover:text-[#312E81] hover:bg-[#EEF2FF]' }}">
                                <i class="fa-regular xx fa-boxes-stacked text-xs mr-1.5 opacity-80"></i> Kantong
                            </a>
                            <a href="{{ route('transactions.index') }}"
                               class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center cursor-pointer {{ request()->routeIs('transactions.*') ? 'bg-[#EEF2FF] text-[#312E81]' : 'text-slate-600 hover:text-[#312E81] hover:bg-[#EEF2FF]' }}">
                                <i class="fa-regular xx fa-list-check text-xs mr-1.5 opacity-80"></i> Riwayat Transaksi
                            </a>
                        </div>
                    </div>

                    <!-- Right Navigation / User & Action -->
                    <div class="flex items-center gap-2.5 sm:gap-3">
                        <button type="button"
                                onclick="window.installPwa()"
                                class="pwa-install-btn hidden items-center gap-1.5 px-3 py-2 rounded-xl btn-secondary text-xs font-bold shadow-2xs cursor-pointer touch-press"
                                title="Pasang Aplikasi di Perangkat">
                            <i class="fa-regular xx fa-download text-[11px] text-[#312E81]"></i>
                            <span class="hidden md:inline">Install App</span>
                        </button>

                        <button type="button"
                                onclick="document.getElementById('quick-transaction-modal')?.classList.remove('hidden')"
                                class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl btn-primary text-xs font-bold shadow-xs cursor-pointer touch-press">
                            <i class="fa-regular xx fa-plus text-[11px]"></i>
                            <span>Catat Transaksi</span>
                        </button>

                        <div class="flex items-center pl-2 border-l border-slate-200 gap-2.5 sm:gap-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-slate-500 leading-tight">{{ Auth::user()->email }}</p>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        title="Keluar"
                                        data-confirm="Apakah Anda yakin ingin keluar dari akun?"
                                        data-confirm-title="Keluar Akun"
                                        class="w-9 h-9 rounded-xl border border-zinc-200 bg-white text-zinc-600 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 flex items-center justify-center text-xs transition cursor-pointer touch-press shadow-2xs">
                                    <i class="fa-regular xx fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content Area with Bottom Padding for Mobile Nav -->
        <main class="flex-1 py-6 sm:py-8 pb-32 sm:pb-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <!-- STICKY MOBILE BOTTOM NAVIGATION BAR (THUMB ZONE) -->
        <nav class="sm:hidden bottom-nav-mobile px-4 flex items-center justify-around select-none">
            <!-- Tab 1: Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-[10.5px] transition cursor-pointer touch-press {{ request()->routeIs('dashboard') ? 'text-[#312E81] font-bold' : 'text-zinc-500 hover:text-zinc-800 font-medium' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs {{ request()->routeIs('dashboard') ? 'bg-[#EEF2FF]' : '' }}">
                    <i class="fa-light xx {{ request()->routeIs('dashboard') ? 'text-lg' : 'text-2xl' }} fa-gauge"></i>
                </div>
                <span class="tracking-tight">{{ request()->routeIs('dashboard') ? 'Dashboard' : '' }}</span>
            </a>

            <!-- Tab 2: Kantong -->
            <a href="{{ route('pockets.index') }}" class="flex flex-col items-center gap-1 text-[10.5px] transition cursor-pointer touch-press {{ request()->routeIs('pockets.*') ? 'text-[#312E81] font-bold' : 'text-zinc-500 hover:text-zinc-800 font-medium' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs {{ request()->routeIs('pockets.*') ? 'bg-[#EEF2FF]' : '' }}">
                    <i class="fa-light xx {{ request()->routeIs('pockets.*') ? 'text-lg' : 'text-2xl' }} fa-boxes-stacked"></i>
                </div>
                <span class="tracking-tight">{{ request()->routeIs('pockets.*') ? 'Kantong' : '' }}</span>
            </a>

            <!-- Center Floating Thumb Action: Catat Cepat (+) -->
            <div class="-mt-7">
                <button type="button"
                        onclick="document.getElementById('quick-transaction-modal')?.classList.remove('hidden')"
                        class="touch-target w-12 h-12 rounded-2xl btn-primary text-white shadow-lg shadow-indigo-900/25 flex items-center justify-center text-base hover:scale-105 transition-all touch-press cursor-pointer"
                        title="Catat Cepat">
                    <i class="fa-light xx text-lg fa-plus"></i>
                </button>
            </div>

            <!-- Tab 3: Riwayat Transaksi -->
            <a href="{{ route('transactions.index') }}" class="flex flex-col items-center gap-1 text-[10.5px] transition cursor-pointer touch-press {{ request()->routeIs('transactions.*') ? 'text-[#312E81] font-bold' : 'text-zinc-500 hover:text-zinc-800 font-medium' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs {{ request()->routeIs('transactions.*') ? 'bg-[#EEF2FF]' : '' }}">
                    <i class="fa-light xx {{ request()->routeIs('transactions.*') ? 'text-lg' : 'text-2xl' }} fa-receipt"></i>
                </div>
                <span class="tracking-tight">{{ request()->routeIs('transactions.*') ? 'Riwayat' : '' }}</span>
            </a>

            <!-- Tab 4: Keluar Akun -->
            <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                @csrf
                <button type="submit"
                        data-confirm="Apakah Anda yakin ingin keluar dari akun?"
                        data-confirm-title="Keluar Akun"
                        class="flex flex-col items-center gap-1 text-[10.5px] text-zinc-500 hover:text-rose-600 font-medium transition cursor-pointer touch-press">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs">
                        <i class="fa-light xx text-2xl fa-arrow-right-from-bracket"></i>
                    </div>
                    {{-- <span class="tracking-tight">Keluar</span> --}}
                </button>
            </form>
        </nav>

        <!-- Footer (Hidden on Mobile to keep bottom clean, visible on desktop) -->
        <footer class="mt-auto hidden sm:block py-6 border-t border-zinc-200/80 bg-white/70 text-xs text-zinc-500">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-[#312E81] text-white flex items-center justify-center text-[10px]">
                        <i class="fa-regular xx fa-wallet text-[#C7D2FE]"></i>
                    </span>
                    <span class="font-bold text-zinc-800">Budget by AkuOnline</span>
                    <span>&bull;</span>
                    <span>Sistem Pengelolaan Anggaran & Kantong</span>
                </div>
                <div class="text-zinc-400">
                    &copy; {{ date('Y') }} AkuOnline. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <!-- Quick Modal Transaction Form (Accessible from Anywhere) -->
    @include('components.quick-transaction-modal')

    <!-- PWA Shortcut Action Handler -->
    @if(request('action') === 'quick_transaction')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('quick-transaction-modal')?.classList.remove('hidden');
            });
        </script>
    @endif

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
