<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Budget by AkuOnline — Kelola Kantong Anggaran Cepat & Anti-Ribet</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23312E81'><path d='M21 7.28V5c0-1.1-.9-2-2-2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-2.28c.59-.35 1-.99 1-1.72V9c0-.73-.41-1.37-1-1.72zM20 9v6h-7V9h7zM5 19V5h14v2h-6c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6v2H5z'/></svg>">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Local Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">

    <!-- Progressive Web App Meta -->
    <x-pwa-meta />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col bg-[#F8FAFC] text-slate-800 antialiased selection:bg-[#EEF2FF] selection:text-[#312E81]">
    <!-- PWA Install Banner -->
    <x-pwa-install-banner />

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group cursor-pointer">
                <span class="w-9 h-9 rounded-xl bg-[#312E81] text-white flex items-center justify-center text-sm shadow-sm group-hover:scale-105 transition">
                    <i class="fa-regular xx fa-wallet"></i>
                </span>
                <span class="font-bold text-slate-900 tracking-tight text-base sm:text-lg">
                    Budget <span class="text-[#312E81] font-semibold text-xs px-2 py-0.5 rounded-full bg-[#EEF2FF]">by AkuOnline</span>
                </span>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm inline-flex items-center gap-2 cursor-pointer touch-press">
                        <i class="fa-regular xx fa-gauge-high text-xs"></i>
                        <span>Buka Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold cursor-pointer touch-press">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm inline-flex items-center gap-1.5 cursor-pointer touch-press">
                        <span>Daftar Gratis</span>
                        <i class="fa-regular xx fa-arrow-right text-[11px]"></i>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-1 flex flex-col justify-center">
        <section class="max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-20 text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#EEF2FF] text-[#312E81] text-xs font-semibold mb-6 border border-indigo-100 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-[#312E81] animate-pulse"></span>
                <span>Pencatatan Keuangan Mobile-First & Anti-Ribet</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto leading-tight sm:leading-tight">
                Kelola Kantong Anggaran dengan <span class="text-[#312E81]">Sentuhan Mudah</span>
            </h1>

            <p class="mt-4 sm:mt-6 text-sm sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Pisahkan alokasi harian, pos belanja, dan tabungan ke dalam kantong-kantong pintar. Catat transaksi secepat kilat dengan ergonomi jempol yang nyaman di smartphone Anda.
            </p>

            <!-- CTA Buttons -->
            <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 max-w-md mx-auto">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto btn-primary min-h-[48px] px-6 py-3 rounded-xl text-sm font-semibold shadow-md flex items-center justify-center gap-2 cursor-pointer touch-press">
                        <i class="fa-regular xx fa-gauge-high"></i>
                        <span>Menuju Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto btn-primary min-h-[48px] px-6 py-3 rounded-xl text-sm font-semibold shadow-md flex items-center justify-center gap-2 cursor-pointer touch-press">
                        <span>Mulai Sekarang — Gratis</span>
                        <i class="fa-regular xx fa-arrow-right text-xs"></i>
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto btn-secondary min-h-[48px] px-6 py-3 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 cursor-pointer touch-press">
                        <i class="fa-regular xx fa-right-to-bracket text-[#312E81]"></i>
                        <span>Sudah Punya Akun</span>
                    </a>
                @endauth
            </div>

            <!-- Features Highlights Cards -->
            <div class="mt-16 sm:mt-24 grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs hover:border-[#312E81] hover:shadow-md transition group">
                    <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-lg mb-4 group-hover:scale-105 transition shadow-xs">
                        <i class="fa-regular xx fa-boxes-stacked"></i>
                    </span>
                    <h3 class="text-base font-bold text-slate-800 mb-2 group-hover:text-[#312E81] transition">Kantong Anggaran Pintar</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Kelompokkan uang Anda ke pos-pos terpisah seperti Kas Harian, Liburan, atau Dana Darurat dengan saldo real-time.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs hover:border-[#312E81] hover:shadow-md transition group">
                    <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-lg mb-4 group-hover:scale-105 transition shadow-xs">
                        <i class="fa-regular xx fa-bolt"></i>
                    </span>
                    <h3 class="text-base font-bold text-slate-800 mb-2 group-hover:text-[#312E81] transition">Anti-Malas Quick Input</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Pencatatan super cepat dengan preset chips (+10k, +50k) dan autofill tanggal. Selesai dalam 3 detik tanpa ribet.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs hover:border-[#312E81] hover:shadow-md transition group">
                    <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-lg mb-4 group-hover:scale-105 transition shadow-xs">
                        <i class="fa-regular xx fa-mobile-screen"></i>
                    </span>
                    <h3 class="text-base font-bold text-slate-800 mb-2 group-hover:text-[#312E81] transition">Thumb-Friendly Ergonomics</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Dirancang khusus untuk layar sentuh mobile dengan bottom navigation bar, target sentuh 44px, dan bottom sheet intuitif.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200/80 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-[#312E81] text-white flex items-center justify-center text-[10px]">
                    <i class="fa-regular xx fa-wallet"></i>
                </span>
                <span>Budget by AkuOnline &copy; {{ date('Y') }}. All rights reserved.</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="hover:text-slate-800 transition cursor-pointer">Masuk</a>
                <a href="{{ route('register') }}" class="hover:text-slate-800 transition cursor-pointer">Daftar</a>
            </div>
        </div>
    </footer>
</body>
</html>
