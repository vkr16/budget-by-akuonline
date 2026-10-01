<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Design Guide & UI System - Budget by AkuOnline</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Local Vendor Assets: Font Awesome Pro & Notiflix AIO -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <script src="{{ asset('assets/vendor/notiflix/notiflix.min.js') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', var(--font-sans), sans-serif;
            background-color: #F9FAF8;
            color: #1F2937;
        }

        .font-mono-numbers {
            font-family: 'JetBrains Mono', monospace;
            font-variant-numeric: tabular-nums;
        }

        /* Mobile Frame Simulator Mockup */
        .mobile-simulator-frame {
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .mobile-simulator-frame.view-mobile {
            max-width: 412px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 25px 60px -15px rgba(49, 46, 129, 0.25), 0 0 0 10px #312E81, 0 0 0 12px #3730A3;
            border-radius: 42px;
            overflow: hidden;
            background: #F8FAFC;
        }

        .mobile-simulator-frame.view-mobile .device-notch {
            display: flex;
        }

        .mobile-simulator-frame.view-full {
            max-width: 100%;
            box-shadow: none;
            border-radius: 1rem;
            background: #F8FAFC;
            border: 1px solid #E5E7EB;
            overflow: hidden;
        }

        .mobile-simulator-frame.view-full .device-notch {
            display: none;
        }

        /* Active touch scale micro-interactions */
        .touch-press:active {
            transform: scale(0.97);
        }

        /* Custom soft bottom-sheet animation */
        @keyframes slideUpSheet {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-sheet-up {
            animation: slideUpSheet 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="min-h-full flex flex-col antialiased selection:bg-[#312E81] selection:text-white">

    <!-- Top Sticky Header -->
    <header class="glass-header sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-zinc-200/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-18">
                <!-- Brand Logo & Title -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-[#312E81] text-white flex items-center justify-center shadow-xs transition-transform group-hover:scale-105">
                            <i class="fa-regular xx fa-wallet text-sm text-[#C7D2FE]"></i>
                        </div>
                        <div class="flex flex-col leading-tight">
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold text-zinc-900 text-base tracking-tight">Budget</span>
                                <span class="px-2 py-0.5 rounded-md bg-[#EEF2FF] text-[#312E81] text-[10px] font-bold tracking-wide uppercase">Design Guide</span>
                            </div>
                            <span class="text-[11px] text-zinc-500 font-medium">by AkuOnline &bull; Mobile-First System</span>
                        </div>
                    </a>
                </div>

                <!-- Action Controls -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <!-- Simulator Toggle: Mobile vs Responsive Full -->
                    <div class="bg-zinc-100 p-1 rounded-xl flex items-center border border-zinc-200 text-xs font-semibold">
                        <button type="button" id="btnViewMobile" class="touch-target-sm px-3 py-1.5 rounded-lg bg-white text-[#312E81] shadow-2xs flex items-center gap-1.5 transition font-bold">
                            <i class="fa-regular xx fa-mobile-screen text-[11px]"></i>
                            <span class="hidden sm:inline">Mobile Frame</span>
                        </button>
                        <button type="button" id="btnViewFull" class="touch-target-sm px-3 py-1.5 rounded-lg text-zinc-600 hover:text-zinc-900 transition flex items-center gap-1.5 font-medium">
                            <i class="fa-regular xx fa-laptop text-[11px]"></i>
                            <span class="hidden sm:inline">Full Responsive</span>
                        </button>
                    </div>

                    <a href="{{ route('dashboard') }}" class="touch-target-sm px-3.5 py-1.5 rounded-xl text-xs font-semibold border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 transition">
                        <i class="fa-regular xx fa-arrow-left text-[10px] mr-1.5 text-zinc-400"></i> App
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-grow w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-12 sm:space-y-14">

        <!-- INTRO & PHILOSOPHY BANNER -->
        <section class="card-soft p-6 sm:p-8 border border-zinc-200/90 relative overflow-hidden bg-gradient-to-br from-white via-[#F8FAFC] to-[#EEF2FF]/50">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                <div class="max-w-2xl space-y-2.5">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-[#EEF2FF] text-[#312E81] text-xs font-bold">
                        <i class="fa-regular xx fa-sparkles text-xs text-[#3730A3]"></i>
                        <span>Redesign Foundation: Soft & Natural</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black text-zinc-900 tracking-tight">
                        Sistem Desain Budget by AkuOnline (Mobile-First)
                    </h1>
                    <p class="text-xs sm:text-sm text-zinc-600 leading-relaxed">
                        Transformasi dari antarmuka monokrom hitam pekat ke ekosistem visual <strong>Tailwind Indigo-900 & Soft Indigo</strong> yang ramah sentuhan jempol (<em>thumb-friendly ergonomics</em>), dan sudut melengkung natural (<em>subtle rounded corners</em>) tanpa gimmick.
                    </p>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <button type="button" onclick="document.getElementById('mobilePreviewSection').scrollIntoView({behavior: 'smooth'})" class="touch-target px-4 py-2.5 rounded-xl btn-primary text-xs font-bold inline-flex items-center gap-2">
                        <i class="fa-regular xx fa-eye text-xs"></i>
                        <span>Lihat Demo Interaktif</span>
                    </button>
                    <button type="button" onclick="document.getElementById('paletteSection').scrollIntoView({behavior: 'smooth'})" class="touch-target px-4 py-2.5 rounded-xl btn-secondary text-xs font-bold inline-flex items-center gap-2">
                        <i class="fa-regular xx fa-palette text-xs"></i>
                        <span>Palet Warna</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- 1. COMPARISON MATRIX: BEFORE vs PAYME vs BUDGET REDESIGN -->
        <section class="space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-1 border-b border-zinc-200/80 pb-3">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-zinc-900 flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                            <i class="fa-regular xx fa-code-compare"></i>
                        </span>
                        <span>Perbandingan Desain: Sebelum vs PayMe vs Budget Baru</span>
                    </h2>
                </div>
                <span class="text-xs text-zinc-400">Analisis kebutuhan & transisi UI</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Col 1: Desain Lama -->
                <div class="card-soft p-5 sm:p-6 border border-zinc-200 bg-white space-y-3.5">
                    <div class="flex items-center justify-between pb-2.5 border-b border-zinc-100">
                        <span class="text-xs font-bold text-zinc-700">1. Desain Lama (Budget Saat Ini)</span>
                        <span class="text-[10px] font-semibold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md">Desktop-Centric</span>
                    </div>
                    <ul class="text-xs text-zinc-600 space-y-2.5 leading-relaxed">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-xmark text-rose-500 mt-1 shrink-0"></i>
                            <span><strong>Warna:</strong> Monokrom hitam pekat (<code class="text-[10px] bg-zinc-100 px-1.5 py-0.5 rounded">bg-zinc-900</code> / <code class="text-[10px] bg-zinc-100 px-1.5 py-0.5 rounded">#18181b</code>), dingin dan kaku.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-xmark text-rose-500 mt-1 shrink-0"></i>
                            <span><strong>Layout:</strong> Navigasi horizontal di atas layar. Sulit dijangkau dengan 1 tangan di smartphone.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-xmark text-rose-500 mt-1 shrink-0"></i>
                            <span><strong>Corners:</strong> Sudut kaku <code class="text-[10px] bg-zinc-100 px-1.5 py-0.5 rounded">rounded-md</code> (6px) dan <code class="text-[10px] bg-zinc-100 px-1.5 py-0.5 rounded">rounded-lg</code> (8px).</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-xmark text-rose-500 mt-1 shrink-0"></i>
                            <span><strong>Touch Target:</strong> Tombol standar web klik desktop (&lt;36px), rawan salah pencet jari.</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 2: Inspirasi PayMe Guide -->
                <div class="card-soft p-5 sm:p-6 border border-emerald-200 bg-emerald-50/20 space-y-3.5">
                    <div class="flex items-center justify-between pb-2.5 border-b border-emerald-100">
                        <span class="text-xs font-bold text-emerald-900">2. Standar PayMe Guide</span>
                        <span class="text-[10px] font-semibold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-md">Fintech Standard</span>
                    </div>
                    <ul class="text-xs text-zinc-700 space-y-2.5 leading-relaxed">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-check text-emerald-600 mt-1 shrink-0"></i>
                            <span><strong>Warna:</strong> Flat Emerald (<code class="text-[10px] bg-white px-1.5 py-0.5 rounded">#064E3B</code>) bertema QRIS/Invoice fintech.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-check text-emerald-600 mt-1 shrink-0"></i>
                            <span><strong>Ergonomi:</strong> Target sentuh <code class="text-[10px] bg-white px-1.5 py-0.5 rounded">touch-target</code> (min 44px), tactile stepper, dan preset chips.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-check text-emerald-600 mt-1 shrink-0"></i>
                            <span><strong>Interaksi:</strong> 1-click salin rekening, toast feedback, dan feedback modal halus.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-check text-emerald-600 mt-1 shrink-0"></i>
                            <span><strong>Permukaan:</strong> Solid surface bersih dengan kontras tinggi tanpa efek visual murahan.</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Redesign Budget by AkuOnline -->
                <div class="card-soft p-5 sm:p-6 border border-[#3730A3]/30 bg-[#EEF2FF]/40 space-y-3.5 relative shadow-xs">
                    <div class="flex items-center justify-between pb-2.5 border-b border-[#C7D2FE]">
                        <span class="text-xs font-black text-[#312E81]">3. Budget by AkuOnline (Redesign)</span>
                        <span class="text-[10px] font-bold text-white bg-[#312E81] px-2 py-0.5 rounded-md">Target Baru</span>
                    </div>
                    <ul class="text-xs text-zinc-800 space-y-2.5 leading-relaxed">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-circle-check text-[#312E81] mt-1 shrink-0"></i>
                            <span><strong>Warna Soft & Natural:</strong> Tailwind Indigo-900 (<code class="text-[10px] bg-white px-1.5 py-0.5 rounded text-[#312E81] font-bold">oklch(35.9% 0.144 278.697) / #312E81</code>) dan Soft Indigo (<code class="text-[10px] bg-white px-1.5 py-0.5 rounded">#EEF2FF</code>). <em>Bukan hitam pekat!</em></span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-circle-check text-[#312E81] mt-1 shrink-0"></i>
                            <span><strong>Mobile First & Thumb Zone:</strong> Sticky Bottom Navigation Bar dengan tombol aksi tengah Catat Transaksi (+) yang siap ditekan satu jempol.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-circle-check text-[#312E81] mt-1 shrink-0"></i>
                            <span><strong>Natural Rounded Corners:</strong> Sudut seimbang <code class="text-[10px] bg-white px-1.5 py-0.5 rounded">rounded-xl</code> (14px) untuk kartu dan <code class="text-[10px] bg-white px-1.5 py-0.5 rounded">rounded-2xl</code> (16px) untuk modal bottom sheet.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-regular xx fa-circle-check text-[#312E81] mt-1 shrink-0"></i>
                            <span><strong>Anti-Malas Logger:</strong> Chips Rupiah (+10rb s/d +500rb), tactile toggle Pengeluaran/Pemasukan, dan alokasi kantong instan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- 2. COLOR PALETTE: SOFT & NATURAL (NO BLACK) -->
        <section id="paletteSection" class="space-y-6">
            <div class="border-b border-zinc-200/80 pb-3">
                <h2 class="text-base sm:text-lg font-bold text-zinc-900 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                        <i class="fa-regular xx fa-droplet"></i>
                    </span>
                    <span>Palet Warna: Tailwind Indigo-900 & Natural Tints (Bukan Hitam)</span>
                </h2>
                <p class="text-xs text-zinc-500 mt-1">Klik swatch warna untuk menyalin nilai HEX ke clipboard. Menggunakan standar Tailwind Indigo-900 (<code>oklch(35.9% 0.144 278.697)</code>).</p>
            </div>

            <!-- Primary Tailwind Indigo Scale -->
            <div class="space-y-3">
                <span class="text-xs font-bold text-zinc-700 tracking-wider uppercase block">Brand Utama: Tailwind Indigo-900 (Aksen & Tombol Primer)</span>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                    <!-- Indigo 900 (Main Primary Brand) -->
                    <button type="button" class="copy-color-btn text-left p-3.5 sm:p-4 rounded-xl border border-zinc-200 bg-white hover:border-[#312E81] transition group touch-press" data-hex="#312E81" data-name="Tailwind Indigo-900 (Brand Primary)">
                        <div class="w-full h-14 rounded-lg bg-[#312E81] mb-3 shadow-2xs flex items-center justify-center text-white text-xs font-bold">
                            Primary
                        </div>
                        <div class="text-xs font-bold text-zinc-900">Indigo 900</div>
                        <div class="text-[11px] text-zinc-500 font-mono-numbers">#312E81</div>
                        <span class="text-[10px] text-[#312E81] font-semibold block mt-1.5">Tombol & Aksen Utama</span>
                    </button>

                    <!-- Indigo 800 (Hover/Active) -->
                    <button type="button" class="copy-color-btn text-left p-3.5 sm:p-4 rounded-xl border border-zinc-200 bg-white hover:border-[#3730A3] transition group touch-press" data-hex="#3730A3" data-name="Indigo 800 (Hover)">
                        <div class="w-full h-14 rounded-lg bg-[#3730A3] mb-3 shadow-2xs"></div>
                        <div class="text-xs font-bold text-zinc-900">Indigo 800</div>
                        <div class="text-[11px] text-zinc-500 font-mono-numbers">#3730A3</div>
                        <span class="text-[10px] text-zinc-400 block mt-1.5">Hover State Tombol</span>
                    </button>

                    <!-- Indigo 100 (Badge Tint) -->
                    <button type="button" class="copy-color-btn text-left p-3.5 sm:p-4 rounded-xl border border-zinc-200 bg-white hover:border-[#C7D2FE] transition group touch-press" data-hex="#E0E7FF" data-name="Indigo 100 (Badge Tint)">
                        <div class="w-full h-14 rounded-lg bg-[#E0E7FF] mb-3 border border-[#C7D2FE]"></div>
                        <div class="text-xs font-bold text-zinc-900">Indigo 100</div>
                        <div class="text-[11px] text-zinc-500 font-mono-numbers">#E0E7FF</div>
                        <span class="text-[10px] text-zinc-400 block mt-1.5">Latar Badge & Chip</span>
                    </button>

                    <!-- Indigo 50 (Soft Indigo Surface) -->
                    <button type="button" class="copy-color-btn text-left p-3.5 sm:p-4 rounded-xl border border-zinc-200 bg-white hover:border-[#C7D2FE] transition group touch-press" data-hex="#EEF2FF" data-name="Indigo 50 (Soft Surface)">
                        <div class="w-full h-14 rounded-lg bg-[#EEF2FF] mb-3 border border-[#E0E7FF]"></div>
                        <div class="text-xs font-bold text-zinc-900">Indigo 50</div>
                        <div class="text-[11px] text-zinc-500 font-mono-numbers">#EEF2FF</div>
                        <span class="text-[10px] text-zinc-400 block mt-1.5">Secondary Button BG</span>
                    </button>

                    <!-- Canvas Slate -->
                    <button type="button" class="copy-color-btn text-left p-3.5 sm:p-4 rounded-xl border border-zinc-200 bg-white hover:border-zinc-300 transition group touch-press" data-hex="#F8FAFC" data-name="Canvas Slate">
                        <div class="w-full h-14 rounded-lg bg-[#F8FAFC] mb-3 border border-zinc-200"></div>
                        <div class="text-xs font-bold text-zinc-900">Canvas</div>
                        <div class="text-[11px] text-zinc-500 font-mono-numbers">#F8FAFC</div>
                        <span class="text-[10px] text-zinc-400 block mt-1.5">Background Aplikasi</span>
                    </button>

                    <!-- Indigo 950 (Dark Contrast Accent) -->
                    <button type="button" class="copy-color-btn text-left p-3.5 sm:p-4 rounded-xl border border-zinc-200 bg-white hover:border-zinc-400 transition group touch-press" data-hex="#1E1B4B" data-name="Indigo 950 (Dark Contrast)">
                        <div class="w-full h-14 rounded-lg bg-[#1E1B4B] mb-3 shadow-2xs"></div>
                        <div class="text-xs font-bold text-zinc-900">Indigo 950</div>
                        <div class="text-[11px] text-zinc-500 font-mono-numbers">#1E1B4B</div>
                        <span class="text-[10px] text-zinc-400 block mt-1.5">Aksen Gelap & Header</span>
                    </button>
                </div>
            </div>

            <!-- Semantic Fintech Colors -->
            <div class="space-y-3 pt-2">
                <span class="text-xs font-bold text-zinc-700 tracking-wider uppercase block">Warna Semantik Finansial (Aliran Dana & Status)</span>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Pemasukan (In) -->
                    <div class="p-4 sm:p-4.5 rounded-xl border border-emerald-200 bg-emerald-50/50 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm shrink-0">
                                <i class="fa-regular xx fa-arrow-down-left"></i>
                            </span>
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-emerald-950 block truncate">Pemasukan (Cash In)</span>
                                <span class="text-[11px] text-emerald-700 block truncate">Emerald #059669 / bg #ECFDF5</span>
                            </div>
                        </div>
                        <span class="font-mono-numbers text-xs font-bold text-emerald-800 shrink-0">+Rp 10.000.000</span>
                    </div>

                    <!-- Pengeluaran (Out) -->
                    <div class="p-4 sm:p-4.5 rounded-xl border border-rose-200 bg-rose-50/50 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center text-sm shrink-0">
                                <i class="fa-regular xx fa-arrow-up-right"></i>
                            </span>
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-rose-950 block truncate">Pengeluaran (Cash Out)</span>
                                <span class="text-[11px] text-rose-700 block truncate">Terracotta Rose #DC2626 / bg #FEF2F2</span>
                            </div>
                        </div>
                        <span class="font-mono-numbers text-xs font-bold text-rose-800 shrink-0">-Rp 25.000</span>
                    </div>

                    <!-- Pending / Alokasi -->
                    <div class="p-4 sm:p-4.5 rounded-xl border border-amber-200 bg-amber-50/50 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-10 h-10 rounded-xl bg-amber-600 text-white flex items-center justify-center text-sm shrink-0">
                                <i class="fa-regular xx fa-clock"></i>
                            </span>
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-amber-950 block truncate">Alokasi & Tagihan</span>
                                <span class="text-[11px] text-amber-700 block truncate">Warm Amber #D97706 / bg #FFFBEB</span>
                            </div>
                        </div>
                        <span class="font-mono-numbers text-xs font-bold text-amber-800 shrink-0">Sisa 3 Hari</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. INTERACTIVE MOBILE APP SIMULATOR (TARGET UTAMA MOBILE TOUCH) -->
        <section id="mobilePreviewSection" class="space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-1 border-b border-zinc-200/80 pb-3">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-zinc-900 flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                            <i class="fa-regular xx fa-mobile-screen-button"></i>
                        </span>
                        <span>Simulator Layar Ponsel: Prototipe UI Budget Baru</span>
                    </h2>
                    <p class="text-xs text-zinc-500 mt-1">
                        Cobalah berinteraksi langsung: tekan toggle pemasukan/pengeluaran, chips nominal, dan tombol bottom sheet.
                    </p>
                </div>
                <div class="text-xs font-medium text-[#312E81] bg-[#EEF2FF] px-3 py-1 rounded-md self-start sm:self-auto mt-2 sm:mt-0">
                    <i class="fa-regular xx fa-hand-pointer mr-1"></i> Mode Interaktif Aktif
                </div>
            </div>

            <!-- SIMULATOR CONTAINER -->
            <div class="py-6 flex justify-center bg-zinc-100/60 p-3 sm:p-8 rounded-3xl border border-zinc-200/80">
                <div id="deviceSimulatorFrame" class="mobile-simulator-frame view-mobile w-full relative">

                    <!-- Mobile Device Top Status / Notch Bar -->
                    <div class="device-notch px-6 pt-3.5 pb-2.5 flex items-center justify-between text-xs text-zinc-800 border-b border-zinc-200/60 bg-white select-none">
                        <span class="font-bold text-[11px] font-mono-numbers" id="clockSimulator">09:41</span>
                        <!-- Fake Speaker & Camera Pill -->
                        <div class="w-24 h-4 bg-zinc-900 rounded-full flex items-center justify-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-zinc-800 border border-zinc-700"></div>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-zinc-600">
                            <i class="fa-regular xx fa-signal"></i>
                            <i class="fa-regular xx fa-wifi"></i>
                            <i class="fa-regular xx fa-battery-full text-zinc-800"></i>
                        </div>
                    </div>

                    <!-- Inner Mobile App Content (Scrollable) -->
                    <div class="p-4 sm:p-5 space-y-4 pb-6 overflow-y-auto max-h-[720px]" id="mobileScrollArea">

                        <!-- Mobile Header Greeting -->
                        <div class="flex items-center justify-between pt-1 pb-1">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#312E81] text-white flex items-center justify-center font-bold text-xs shadow-2xs">
                                    FM
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-zinc-900 leading-tight">Halo, Fikri 👋</h3>
                                    <p class="text-[11px] text-zinc-500 mt-0.5">Anggaran {{ now()->translatedFormat('F Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" class="touch-target w-9 h-9 rounded-xl bg-white border border-zinc-200 text-zinc-600 hover:text-zinc-900 flex items-center justify-center text-xs shadow-2xs touch-press" title="Filter Kantong">
                                    <i class="fa-regular xx fa-sliders"></i>
                                </button>
                                <button type="button" class="touch-target w-9 h-9 rounded-xl bg-white border border-zinc-200 text-zinc-600 hover:text-zinc-900 flex items-center justify-center text-xs shadow-2xs touch-press" title="Notifikasi">
                                    <i class="fa-regular fa-bell"></i>
                                </button>
                            </div>
                        </div>

                        <!-- 1. SALDO CARD (TAILWIND INDIGO-900 THEME) -->
                        <div class="card-soft rounded-2xl p-5 bg-gradient-to-br from-[#312E81] to-[#1E1B4B] text-white shadow-sm relative overflow-hidden space-y-3">
                            <!-- Background subtle organic glow -->
                            <div class="absolute -right-8 -bottom-8 w-40 h-40 rounded-full bg-[#3730A3]/40 blur-2xl pointer-events-none"></div>

                            <div class="flex items-center justify-between text-xs text-[#C7D2FE]">
                                <span class="font-medium tracking-wide uppercase text-[10px]">Total Saldo Semua Kantong</span>
                                <span class="px-2.5 py-0.5 rounded-full bg-[#3730A3]/60 text-white text-[10px] font-semibold border border-[#6366F1]/40">
                                    4 Kantong Aktif
                                </span>
                            </div>

                            <div class="my-2">
                                <div class="text-2xl sm:text-3xl font-black font-mono-numbers tracking-tight text-white" id="simulatedTotalBalance">
                                    Rp 14.850.000
                                </div>
                            </div>

                            <!-- Mini In vs Out Metrics -->
                            <div class="pt-3.5 border-t border-[#3730A3]/80 grid grid-cols-2 gap-3 text-xs">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5 text-[11px] text-[#C7D2FE]">
                                        <i class="fa-regular xx fa-arrow-down-left text-[10px] text-emerald-400"></i>
                                        <span>Masuk Bulan Ini</span>
                                    </div>
                                    <div class="font-bold font-mono-numbers text-white text-xs">
                                        Rp 12.000.000
                                    </div>
                                </div>
                                <div class="space-y-1 text-right">
                                    <div class="flex items-center justify-end gap-1.5 text-[11px] text-[#F3C5C5]">
                                        <span>Keluar Bulan Ini</span>
                                        <i class="fa-regular xx fa-arrow-up-right text-[10px] text-rose-400"></i>
                                    </div>
                                    <div class="font-bold font-mono-numbers text-white text-xs" id="simulatedTotalExpense">
                                        Rp 5.250.000
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. QUICK RECORD CARD ("ANTI-MALAS" FRICTIONLESS LOGGER) -->
                        <div class="card-soft rounded-2xl p-4 sm:p-5 border border-zinc-200 bg-white space-y-4 shadow-2xs">
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                                        <i class="fa-regular xx fa-bolt"></i>
                                    </span>
                                    <h4 class="text-xs font-bold text-zinc-900 tracking-tight">Catat Transaksi Cepat</h4>
                                </div>
                                <span class="text-[10px] font-semibold text-[#312E81] bg-[#EEF2FF] px-2.5 py-0.5 rounded-md">
                                    1-Tap Mode
                                </span>
                            </div>

                            <!-- Tactile Type Switcher: Out vs In -->
                            <div class="grid grid-cols-2 gap-1.5 p-1 rounded-xl bg-zinc-100 border border-zinc-200/80">
                                <button type="button" id="btnTypeOut" class="touch-target-sm rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 bg-white text-rose-700 shadow-2xs border border-rose-200 min-h-[44px]">
                                    <i class="fa-regular xx fa-arrow-up-right text-[11px]"></i>
                                    <span>Pengeluaran</span>
                                </button>
                                <button type="button" id="btnTypeIn" class="touch-target-sm rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 text-zinc-600 hover:text-zinc-900 min-h-[44px]">
                                    <i class="fa-regular xx fa-arrow-down-left text-[11px]"></i>
                                    <span>Pemasukan</span>
                                </button>
                            </div>

                            <!-- Rupiah Input Field -->
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-zinc-700 uppercase tracking-wider">
                                    Nominal Transfer / Belanja
                                </label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-4 font-bold font-mono-numbers text-zinc-400 text-sm pointer-events-none">Rp</span>
                                    <input type="text" id="demoAmountInput" value="35.000" class="touch-target w-full pl-12 pr-4 py-3 text-base font-bold font-mono-numbers text-zinc-900 bg-[#F9FAF8] border border-zinc-300 rounded-xl focus:outline-none focus:border-[#312E81] focus:ring-2 focus:ring-[#312E81]/20 transition min-h-[48px]" placeholder="0">
                                </div>
                            </div>

                            <!-- Quick Preset Chips (+10k, +20k, +50k, +100k, +500k) -->
                            <div class="space-y-1.5">
                                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider block">Tambah Cepat:</span>
                                <div class="flex flex-wrap gap-2 pt-0.5" id="simulatorChips">
                                    <button type="button" class="preset-chip touch-target-sm px-3 py-1.5 rounded-xl text-xs font-semibold bg-zinc-100 hover:bg-zinc-200 text-zinc-800 border border-zinc-200 transition touch-press" data-add="10000">+10rb</button>
                                    <button type="button" class="preset-chip touch-target-sm px-3 py-1.5 rounded-xl text-xs font-semibold bg-zinc-100 hover:bg-zinc-200 text-zinc-800 border border-zinc-200 transition touch-press" data-add="20000">+20rb</button>
                                    <button type="button" class="preset-chip touch-target-sm px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#EEF2FF] text-[#312E81] border border-[#C7D2FE] transition touch-press" data-add="50000">+50rb</button>
                                    <button type="button" class="preset-chip touch-target-sm px-3 py-1.5 rounded-xl text-xs font-semibold bg-zinc-100 hover:bg-zinc-200 text-zinc-800 border border-zinc-200 transition touch-press" data-add="100000">+100rb</button>
                                    <button type="button" class="preset-chip touch-target-sm px-3 py-1.5 rounded-xl text-xs font-semibold bg-zinc-100 hover:bg-zinc-200 text-zinc-800 border border-zinc-200 transition touch-press" data-add="500000">+500rb</button>
                                </div>
                            </div>

                            <!-- Pocket Selector & Description -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="block text-[11px] font-bold text-zinc-700 uppercase tracking-wider">
                                        Pilih Kantong
                                    </label>
                                    <select id="demoPocketSelect" class="touch-target-sm w-full px-3.5 py-2.5 text-xs font-medium text-zinc-900 bg-[#F9FAF8] border border-zinc-300 rounded-xl focus:outline-none focus:border-[#312E81] min-h-[44px]">
                                        <option value="Jajan & Kopi">☕ Jajan & Kopi (Rp 450.000)</option>
                                        <option value="Kebutuhan Pokok">🛒 Kebutuhan Pokok (Rp 3.200.000)</option>
                                        <option value="Tabungan Darurat">🛡️ Tabungan Darurat (Rp 10.000.000)</option>
                                        <option value="Transportasi">🛵 Transport & Bensin (Rp 350.000)</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-[11px] font-bold text-zinc-700 uppercase tracking-wider">
                                        Keterangan
                                    </label>
                                    <input type="text" id="demoDescInput" value="Kopi Susu Gula Aren" class="touch-target-sm w-full px-3.5 py-2.5 text-xs text-zinc-900 bg-[#F9FAF8] border border-zinc-300 rounded-xl focus:outline-none focus:border-[#312E81] min-h-[44px]">
                                </div>
                            </div>

                            <!-- Action Button -->
                            <button type="button" id="btnSimulateSave" class="touch-target w-full py-3 px-4 rounded-xl btn-primary text-xs font-bold flex items-center justify-center gap-2 min-h-[48px]">
                                <i class="fa-regular xx fa-plus text-[11px]"></i>
                                <span>Simpan Transaksi Sekarang</span>
                            </button>
                        </div>

                        <!-- 3. KANTONG CARDS SLIDER (ROUNDED-XL NATURAL) -->
                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between pb-1">
                                <h4 class="text-xs font-bold text-zinc-900 tracking-tight flex items-center gap-1.5">
                                    <i class="fa-regular xx fa-boxes-stacked text-[#312E81] text-xs"></i>
                                    <span>Kantong Anggaran Saya</span>
                                </h4>
                                <a href="javascript:void(0)" class="text-[11px] font-bold text-[#312E81] hover:underline">Lihat Semua</a>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <!-- Pocket 1 -->
                                <div class="card-soft p-3.5 rounded-xl border border-zinc-200 bg-white hover:border-[#312E81] transition space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                                            <i class="fa-regular xx fa-mug-hot"></i>
                                        </span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200">Sisa 30%</span>
                                    </div>
                                    <div class="space-y-0.5">
                                        <span class="text-xs font-bold text-zinc-900 block truncate">Jajan & Kopi</span>
                                        <span class="text-xs font-extrabold font-mono-numbers text-zinc-900 block">Rp 450.000</span>
                                        <span class="text-[10px] text-zinc-400 block">dari pagu Rp 1.500.000</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-zinc-100 rounded-full overflow-hidden mt-1">
                                        <div class="h-full bg-amber-500 rounded-full" style="width: 30%;"></div>
                                    </div>
                                </div>

                                <!-- Pocket 2 -->
                                <div class="card-soft p-3.5 rounded-xl border border-zinc-200 bg-white hover:border-[#312E81] transition space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                                            <i class="fa-regular xx fa-cart-shopping"></i>
                                        </span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200">Sehat 72%</span>
                                    </div>
                                    <div class="space-y-0.5">
                                        <span class="text-xs font-bold text-zinc-900 block truncate">Kebutuhan Pokok</span>
                                        <span class="text-xs font-extrabold font-mono-numbers text-zinc-900 block">Rp 3.200.000</span>
                                        <span class="text-[10px] text-zinc-400 block">dari pagu Rp 4.500.000</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-zinc-100 rounded-full overflow-hidden mt-1">
                                        <div class="h-full bg-[#312E81] rounded-full" style="width: 72%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. RECENT TRANSACTIONS (TOUCH-FRIENDLY FEED) -->
                        <div class="card-soft rounded-2xl p-4 sm:p-5 border border-zinc-200 bg-white space-y-3.5 shadow-2xs">
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-2.5">
                                <h4 class="text-xs font-bold text-zinc-900 tracking-tight flex items-center gap-1.5">
                                    <i class="fa-regular xx fa-clock-rotate-left text-zinc-500 text-xs"></i>
                                    <span>Riwayat Transaksi Terkini</span>
                                </h4>
                                <span class="text-[10px] text-zinc-400 font-medium">Hari ini</span>
                            </div>

                            <div class="space-y-2.5" id="simulatedTransactionList">
                                <!-- Transaction 1 -->
                                <div class="p-3 rounded-xl border border-zinc-200/80 bg-[#F9FAF8] flex items-center justify-between gap-3 hover:bg-zinc-50 transition touch-press">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-xs shrink-0">
                                            <i class="fa-regular xx fa-arrow-up-right"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <span class="text-xs font-bold text-zinc-900 block truncate">Kopi Susu Gula Aren</span>
                                            <span class="text-[10px] text-zinc-500 block truncate">Jajan & Kopi &bull; 10:15 WIB</span>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="text-xs font-black font-mono-numbers text-rose-700 block">-Rp 35.000</span>
                                        <span class="text-[9px] text-zinc-400 font-medium">Selesai</span>
                                    </div>
                                </div>

                                <!-- Transaction 2 -->
                                <div class="p-3 rounded-xl border border-zinc-200/80 bg-[#F9FAF8] flex items-center justify-between gap-3 hover:bg-zinc-50 transition touch-press">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs shrink-0">
                                            <i class="fa-regular xx fa-arrow-down-left"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <span class="text-xs font-bold text-zinc-900 block truncate">Transfer Gaji Bulanan</span>
                                            <span class="text-[10px] text-zinc-500 block truncate">Rekening Utama &bull; Kemarin</span>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="text-xs font-black font-mono-numbers text-emerald-700 block">+Rp 10.000.000</span>
                                        <span class="text-[9px] text-emerald-700 font-medium">Pemasukan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- STICKY MOBILE BOTTOM NAVIGATION BAR (THUMB ZONE) -->
                    <div class="simulator-bottom-nav px-4 border-t border-zinc-200/90 bg-white/95 backdrop-blur-md flex items-center justify-around select-none">
                        <!-- Tab 1: Dashboard (Active) -->
                        <a href="javascript:void(0)" class="flex flex-col items-center gap-1 text-[#312E81] font-bold text-[10px] transition touch-press">
                            <div class="w-8 h-8 rounded-xl bg-[#EEF2FF] flex items-center justify-center text-xs">
                                <i class="fa-regular xx fa-house"></i>
                            </div>
                            <span>Beranda</span>
                        </a>

                        <!-- Tab 2: Kantong -->
                        <a href="javascript:void(0)" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-zinc-900 font-medium text-[10px] transition touch-press">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs">
                                <i class="fa-regular xx fa-boxes-stacked"></i>
                            </div>
                            <span>Kantong</span>
                        </a>

                        <!-- Center Thumb Action Button: Catat Cepat (+) -->
                        <div class="-mt-6">
                            <button type="button" id="btnOpenBottomSheetDemo" class="touch-target w-12 h-12 rounded-2xl btn-primary text-white shadow-md flex items-center justify-center text-base hover:scale-105 transition-all touch-press" title="Catat Cepat">
                                <i class="fa-regular xx fa-plus text-sm"></i>
                            </button>
                        </div>

                        <!-- Tab 3: Riwayat -->
                        <a href="javascript:void(0)" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-zinc-900 font-medium text-[10px] transition touch-press">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs">
                                <i class="fa-regular xx fa-receipt"></i>
                            </div>
                            <span>Riwayat</span>
                        </a>

                        <!-- Tab 4: Profil / Pengaturan -->
                        <a href="javascript:void(0)" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-zinc-900 font-medium text-[10px] transition touch-press">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs">
                                <i class="fa-regular xx fa-user"></i>
                            </div>
                            <span>Profil</span>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- 4. ATOMIC UI COMPONENTS & PLAYGROUND -->
        <section class="space-y-6">
            <div class="border-b border-zinc-200/80 pb-3">
                <h2 class="text-base sm:text-lg font-bold text-zinc-900 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                        <i class="fa-regular xx fa-shapes"></i>
                    </span>
                    <span>Hierarki Tombol, Sudut, & Feedback Taktil</span>
                </h2>
                <p class="text-xs text-zinc-500 mt-1">Komponen atomik yang mematuhi batas ergonomis sentuhan tangan dan radius seimbang.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Button Hierarchy -->
                <div class="card-soft p-5 sm:p-6 rounded-2xl border border-zinc-200 bg-white space-y-4">
                    <h3 class="text-xs font-bold text-zinc-900 tracking-wider uppercase border-b border-zinc-100 pb-2.5">
                        Hierarki Tombol (Touch Target Min-44px)
                    </h3>

                    <div class="space-y-3.5">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-bold text-zinc-800 block">Primary (Tailwind Indigo-900)</span>
                                <span class="text-[11px] text-zinc-500">Aksi utama formulir & simpan</span>
                            </div>
                            <button type="button" class="touch-target px-4 py-2.5 rounded-xl btn-primary text-xs font-bold">
                                Simpan Transaksi
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-bold text-zinc-800 block">Secondary (Soft Indigo)</span>
                                <span class="text-[11px] text-zinc-500">Opsi alternatif / cancel</span>
                            </div>
                            <button type="button" class="touch-target px-4 py-2.5 rounded-xl btn-secondary text-xs font-bold">
                                Batalkan Opsi
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-bold text-zinc-800 block">Subtle Ghost</span>
                                <span class="text-[11px] text-zinc-500">Aksi sekunder tabel/list</span>
                            </div>
                            <button type="button" class="touch-target px-3.5 py-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-zinc-700 font-semibold text-xs transition">
                                <i class="fa-regular xx fa-pen text-[10px] mr-1.5 text-zinc-400"></i> Edit Detail
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-bold text-rose-700 block">Destructive (Terracotta)</span>
                                <span class="text-[11px] text-zinc-500">Hapus kantong / transaksi</span>
                            </div>
                            <button type="button" class="touch-target px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-semibold text-xs transition">
                                <i class="fa-regular xx fa-trash-can text-[10px] mr-1.5"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rounded Corner Philosophy & Badges -->
                <div class="card-soft p-5 sm:p-6 rounded-2xl border border-zinc-200 bg-white space-y-4">
                    <h3 class="text-xs font-bold text-zinc-900 tracking-wider uppercase border-b border-zinc-100 pb-2.5">
                        Filosofi Rounded Corner Proporsional
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="p-3.5 sm:p-4 rounded-xl border border-zinc-200 bg-[#F9FAF8] space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-zinc-900"><code class="text-[11px] text-[#312E81]">rounded-xl</code> (12px - 14px)</span>
                                <span class="text-[10px] text-zinc-500 font-semibold">Standar Kartu</span>
                            </div>
                            <p class="text-zinc-600 text-[11px] leading-relaxed">
                                Digunakan untuk seluruh kartu ringkasan, container form, dan list item. Memberi kesan hangat, lembut, namun tetap terstruktur dan rapi.
                            </p>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl border border-zinc-200 bg-[#F9FAF8] space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-zinc-900"><code class="text-[11px] text-[#312E81]">rounded-2xl</code> (16px)</span>
                                <span class="text-[10px] text-zinc-500 font-semibold">Modal & Bottom Sheet</span>
                            </div>
                            <p class="text-zinc-600 text-[11px] leading-relaxed">
                                Digunakan untuk sheet layar penuh dan modal dialog yang muncul di perangkat mobile, sangat cocok dengan sudut lengkung fisik layar smartphone modern.
                            </p>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-lg border border-zinc-200 bg-[#F9FAF8] space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-zinc-900"><code class="text-[11px] text-[#312E81]">rounded-lg</code> (8px)</span>
                                <span class="text-[10px] text-zinc-500 font-semibold">Tombol & Input</span>
                            </div>
                            <p class="text-zinc-600 text-[11px] leading-relaxed">
                                Menghindari bentuk kapsul lonjong ekstrem (<code class="text-[10px]">rounded-full</code>) pada tombol utama agar antarmuka tidak terasa kekanak-kanakan.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 5. NOTIFLIX & TOAST FEEDBACK INTEGRATION -->
        <section class="card-soft p-5 sm:p-6 rounded-2xl border border-zinc-200 bg-white space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-zinc-100 pb-3">
                <div>
                    <h3 class="text-xs font-bold text-zinc-900 tracking-wider uppercase">
                        Integrasi Notifikasi & Modal Konfirmasi (Notiflix Indigo-900)
                    </h3>
                    <p class="text-xs text-zinc-500 mt-1">Umpan balik langsung kepada pengguna dengan palet alami tanpa warna hitam pekat.</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-1">
                <button type="button" id="btnTestNotifySuccess" class="touch-target px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold inline-flex items-center gap-2 transition">
                    <i class="fa-regular xx fa-circle-check text-emerald-600"></i>
                    <span>Notifikasi Sukses</span>
                </button>

                <button type="button" id="btnTestNotifyWarning" class="touch-target px-4 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold inline-flex items-center gap-2 transition">
                    <i class="fa-regular xx fa-triangle-exclamation text-amber-600"></i>
                    <span>Peringatan Saldo</span>
                </button>

                <button type="button" id="btnTestNotifyFailure" class="touch-target px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-800 border border-rose-200 text-xs font-bold inline-flex items-center gap-2 transition">
                    <i class="fa-regular xx fa-circle-exclamation text-rose-600"></i>
                    <span>Notifikasi Gagal</span>
                </button>

                <button type="button" id="btnTestConfirmDialog" class="touch-target px-4 py-2.5 rounded-xl btn-primary text-xs font-bold inline-flex items-center gap-2 transition">
                    <i class="fa-regular xx fa-circle-question"></i>
                    <span>Uji Dialog Konfirmasi</span>
                </button>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="mt-auto border-t border-zinc-200/80 bg-white py-6 text-xs text-zinc-500">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-md bg-[#312E81] text-white flex items-center justify-center text-[11px]">
                    <i class="fa-regular xx fa-wallet text-[10px] text-[#C7D2FE]"></i>
                </div>
                <span class="font-bold text-zinc-800">Budget by AkuOnline</span>
                <span>&bull;</span>
                <span>Mobile-First Soft & Natural Design System</span>
            </div>
            <div class="text-zinc-400">
                &copy; {{ date('Y') }} AkuOnline. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- ========================================================
         MOBILE BOTTOM SHEET MODAL (DEMO INTERAKTIF JEMPOL)
         ======================================================== -->
    <div id="mobileBottomSheetModal" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4 hidden transition-opacity duration-200 opacity-0" role="dialog" aria-modal="true">
        <div id="bottomSheetContent" class="bg-white rounded-t-3xl sm:rounded-2xl w-full max-w-md p-5 sm:p-6 space-y-4.5 shadow-xl border border-zinc-200 transform transition-transform duration-200 translate-y-full sm:translate-y-0 sm:scale-95">
            <!-- Sheet Thumb Drag Bar for Mobile -->
            <div class="w-12 h-1.5 rounded-full bg-zinc-300 mx-auto -mt-1 mb-2 sm:hidden"></div>

            <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-sm">
                        <i class="fa-regular xx fa-pen-to-square"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900">Catat Cepat (Bottom Sheet)</h3>
                        <p class="text-[11px] text-zinc-400 mt-0.5">Ergonomis untuk jangkauan satu jempol</p>
                    </div>
                </div>
                <button type="button" id="btnCloseBottomSheet" class="touch-target w-8 h-8 rounded-lg flex items-center justify-center text-zinc-400 hover:text-zinc-700 hover:bg-zinc-100 transition">
                    <i class="fa-regular xx fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider">Nominal (Rp)</label>
                    <input type="text" id="sheetAmountInput" value="50.000" class="touch-target w-full px-4 py-3 text-base font-bold font-mono-numbers text-zinc-900 bg-[#F9FAF8] border border-zinc-300 rounded-xl focus:outline-none focus:border-[#312E81] min-h-[48px]">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider">Pilih Kantong Sumber</label>
                    <select class="touch-target w-full px-3.5 py-2.5 text-xs font-medium text-zinc-900 bg-[#F9FAF8] border border-zinc-300 rounded-xl min-h-[44px]">
                        <option>☕ Jajan & Kopi (Sisa Rp 450.000)</option>
                        <option>🛒 Kebutuhan Pokok (Sisa Rp 3.200.000)</option>
                        <option>🛡️ Tabungan Darurat (Sisa Rp 10.000.000)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider">Keterangan Singkat</label>
                    <input type="text" value="Beli Makan Siang" class="touch-target w-full px-3.5 py-2.5 text-xs text-zinc-900 bg-[#F9FAF8] border border-zinc-300 rounded-xl min-h-[44px]">
                </div>
            </div>

            <!-- Sheet Footer -->
            <div class="pt-3.5 border-t border-zinc-100 flex items-center gap-3">
                <button type="button" id="btnCancelBottomSheet" class="touch-target flex-1 py-3 rounded-xl btn-secondary text-xs font-bold min-h-[46px]">
                    Batal
                </button>
                <button type="button" id="btnSubmitBottomSheet" class="touch-target flex-1 py-3 rounded-xl btn-primary text-xs font-bold flex items-center justify-center gap-1.5 min-h-[46px]">
                    <i class="fa-regular xx fa-check text-xs"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION SNACKBAR -->
    <div id="designGuideToast" class="fixed bottom-6 right-6 z-50 transform translate-y-12 opacity-0 pointer-events-none transition-all duration-200 flex items-center gap-2.5 px-4 py-3 rounded-xl bg-[#312E81] text-white text-xs font-medium shadow-xl border border-[#3730A3]">
        <i class="fa-regular xx fa-circle-check text-[#C7D2FE] text-sm"></i>
        <span id="designGuideToastMessage">Warna berhasil disalin!</span>
    </div>

    <!-- CLIENT INTERACTIVITY JAVASCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Toast Feedback Helper
            const toast = document.getElementById('designGuideToast');
            const toastMsg = document.getElementById('designGuideToastMessage');
            let toastTimer = null;

            function showToast(message) {
                if (toastTimer) clearTimeout(toastTimer);
                toastMsg.textContent = message;
                toast.classList.remove('translate-y-12', 'opacity-0', 'pointer-events-none');
                toast.classList.add('translate-y-0', 'opacity-100');

                toastTimer = setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-12', 'opacity-0', 'pointer-events-none');
                }, 2200);
            }

            // 2. Swatch Copy Hex Click
            document.querySelectorAll('.copy-color-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const hex = btn.getAttribute('data-hex');
                    const name = btn.getAttribute('data-name');
                    navigator.clipboard.writeText(hex).catch(() => {});
                    showToast(`Kode HEX ${name} (${hex}) berhasil disalin!`);
                });
            });

            // 3. View Switcher: Mobile Frame vs Responsive Full
            const frame = document.getElementById('deviceSimulatorFrame');
            const btnMobile = document.getElementById('btnViewMobile');
            const btnFull = document.getElementById('btnViewFull');

            btnMobile.addEventListener('click', () => {
                frame.className = 'mobile-simulator-frame view-mobile w-full relative';
                btnMobile.className = 'touch-target-sm px-3 py-1.5 rounded-lg bg-white text-[#312E81] shadow-2xs flex items-center gap-1.5 transition font-bold';
                btnFull.className = 'touch-target-sm px-3 py-1.5 rounded-lg text-zinc-600 hover:text-zinc-900 transition flex items-center gap-1.5 font-medium';
            });

            btnFull.addEventListener('click', () => {
                frame.className = 'mobile-simulator-frame view-full w-full relative';
                btnFull.className = 'touch-target-sm px-3 py-1.5 rounded-lg bg-white text-[#312E81] shadow-2xs flex items-center gap-1.5 transition font-bold';
                btnMobile.className = 'touch-target-sm px-3 py-1.5 rounded-lg text-zinc-600 hover:text-zinc-900 transition flex items-center gap-1.5 font-medium';
            });

            // 4. Update Clock in Simulator
            function updateClock() {
                const now = new Date();
                const clockEl = document.getElementById('clockSimulator');
                if (clockEl) {
                    clockEl.textContent = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
                }
            }
            updateClock();
            setInterval(updateClock, 30000);

            // 5. Type Switcher (Pengeluaran vs Pemasukan)
            let currentType = 'out';
            const btnTypeOut = document.getElementById('btnTypeOut');
            const btnTypeIn = document.getElementById('btnTypeIn');

            btnTypeOut.addEventListener('click', () => {
                currentType = 'out';
                btnTypeOut.className = 'touch-target-sm rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 bg-white text-rose-700 shadow-2xs border border-rose-200 min-h-[44px]';
                btnTypeIn.className = 'touch-target-sm rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 text-zinc-600 hover:text-zinc-900 min-h-[44px]';
            });

            btnTypeIn.addEventListener('click', () => {
                currentType = 'in';
                btnTypeIn.className = 'touch-target-sm rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 bg-white text-emerald-700 shadow-2xs border border-emerald-200 min-h-[44px]';
                btnTypeOut.className = 'touch-target-sm rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 text-zinc-600 hover:text-zinc-900 min-h-[44px]';
            });

            // 6. Simulator Chips (+10k, +20k, +50k, etc.)
            const amountInput = document.getElementById('demoAmountInput');
            document.querySelectorAll('#simulatorChips .preset-chip').forEach(chip => {
                chip.addEventListener('click', () => {
                    const toAdd = parseInt(chip.getAttribute('data-add'), 10);
                    let currentVal = parseInt(amountInput.value.replace(/\D/g, '') || '0', 10);
                    currentVal += toAdd;
                    amountInput.value = currentVal.toLocaleString('id-ID');
                });
            });

            // 7. Simulated Save in Mobile Simulator
            let totalBalance = 14850000;
            let totalExpense = 5250000;
            const balanceEl = document.getElementById('simulatedTotalBalance');
            const expenseEl = document.getElementById('simulatedTotalExpense');
            const transList = document.getElementById('simulatedTransactionList');
            const btnSave = document.getElementById('btnSimulateSave');

            btnSave.addEventListener('click', () => {
                const amount = parseInt(amountInput.value.replace(/\D/g, '') || '0', 10);
                if (amount <= 0) {
                    if (window.Notiflix) window.Notiflix.Notify.warning('Masukkan nominal transaksi yang valid.');
                    return;
                }

                const desc = document.getElementById('demoDescInput').value || (currentType === 'in' ? 'Pemasukan Baru' : 'Pengeluaran Baru');
                const pocket = document.getElementById('demoPocketSelect').value.split(' ')[1] || 'Kantong';

                if (currentType === 'out') {
                    totalBalance -= amount;
                    totalExpense += amount;
                } else {
                    totalBalance += amount;
                }

                balanceEl.textContent = 'Rp ' + totalBalance.toLocaleString('id-ID');
                expenseEl.textContent = 'Rp ' + totalExpense.toLocaleString('id-ID');

                // Append new transaction element
                const newRow = document.createElement('div');
                newRow.className = 'p-3 rounded-xl border border-zinc-200/80 bg-[#F9FAF8] flex items-center justify-between gap-3 hover:bg-zinc-50 transition touch-press animate-sheet-up';
                newRow.innerHTML = `
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-9 h-9 rounded-xl ${currentType === 'in' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'} flex items-center justify-center text-xs shrink-0">
                            <i class="fa-regular xx ${currentType === 'in' ? 'fa-arrow-down-left' : 'fa-arrow-up-right'}"></i>
                        </span>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-zinc-900 block truncate">${desc}</span>
                            <span class="text-[10px] text-zinc-500 block truncate">${pocket} &bull; Baru saja</span>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-xs font-black font-mono-numbers ${currentType === 'in' ? 'text-emerald-700' : 'text-rose-700'} block">
                            ${currentType === 'in' ? '+' : '-'}Rp ${amount.toLocaleString('id-ID')}
                        </span>
                        <span class="text-[9px] text-[#312E81] font-semibold">Tersimpan</span>
                    </div>
                `;
                transList.prepend(newRow);

                if (window.Notiflix) {
                    window.Notiflix.Notify.success(`Transaksi ${desc} sebesar Rp ${amount.toLocaleString('id-ID')} berhasil dicatat!`);
                } else {
                    showToast('Transaksi berhasil disimpan!');
                }
            });

            // 8. Mobile Bottom Sheet Modal Logic
            const modalSheet = document.getElementById('mobileBottomSheetModal');
            const sheetContent = document.getElementById('bottomSheetContent');
            const btnOpenSheet = document.getElementById('btnOpenBottomSheetDemo');
            const btnCloseSheet = document.getElementById('btnCloseBottomSheet');
            const btnCancelSheet = document.getElementById('btnCancelBottomSheet');
            const btnSubmitSheet = document.getElementById('btnSubmitBottomSheet');

            function openSheet() {
                modalSheet.classList.remove('hidden');
                setTimeout(() => {
                    modalSheet.classList.remove('opacity-0');
                    sheetContent.classList.remove('translate-y-full', 'scale-95');
                    sheetContent.classList.add('translate-y-0', 'scale-100');
                }, 15);
            }

            function closeSheet() {
                modalSheet.classList.add('opacity-0');
                sheetContent.classList.remove('translate-y-0', 'scale-100');
                sheetContent.classList.add('translate-y-full', 'scale-95');
                setTimeout(() => {
                    modalSheet.classList.add('hidden');
                }, 200);
            }

            btnOpenSheet.addEventListener('click', openSheet);
            btnCloseSheet.addEventListener('click', closeSheet);
            btnCancelSheet.addEventListener('click', closeSheet);
            btnSubmitSheet.addEventListener('click', () => {
                closeSheet();
                if (window.Notiflix) {
                    window.Notiflix.Notify.success('Simulasi Bottom Sheet: Transaksi berhasil dicatat!');
                } else {
                    showToast('Simulasi: Transaksi disimpan!');
                }
            });

            modalSheet.addEventListener('click', (e) => {
                if (e.target === modalSheet) closeSheet();
            });

            // 9. Notiflix Notification & Confirm Buttons
            document.getElementById('btnTestNotifySuccess').addEventListener('click', () => {
                if (window.Notiflix) window.Notiflix.Notify.success('Saldo Kantong berhasil diperbarui.');
            });

            document.getElementById('btnTestNotifyWarning').addEventListener('click', () => {
                if (window.Notiflix) window.Notiflix.Notify.warning('Sisa anggaran kantong Jajan & Kopi tinggal 15%.');
            });

            document.getElementById('btnTestNotifyFailure').addEventListener('click', () => {
                if (window.Notiflix) window.Notiflix.Notify.failure('Gagal mencatat transaksi: Saldo kantong tidak mencukupi.');
            });

            document.getElementById('btnTestConfirmDialog').addEventListener('click', () => {
                if (window.Notiflix) {
                    window.Notiflix.Confirm.show(
                        'Konfirmasi Hapus Transaksi',
                        'Apakah Anda yakin ingin menghapus catatan pengeluaran ini? Saldo kantong akan dikembalikan otomatis.',
                        'Ya, Hapus',
                        'Batal',
                        () => {
                            window.Notiflix.Notify.success('Transaksi berhasil dihapus.');
                        }
                    );
                }
            });
        });
    </script>
</body>
</html>
