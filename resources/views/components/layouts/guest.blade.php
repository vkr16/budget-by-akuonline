<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $title ?? 'Autentikasi' }} - {{ config('app.name', 'Budget') }}</title>

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
<body class="h-full bg-[#F8FAFC] text-[#1F2937] font-sans antialiased flex flex-col justify-center py-10 sm:py-12 sm:px-6 lg:px-8 selection:bg-[#312E81] selection:text-white">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="/" class="inline-flex items-center gap-2.5 text-slate-900 font-bold tracking-tight text-lg group cursor-pointer">
            <span class="w-10 h-10 rounded-xl bg-[#312E81] text-white flex items-center justify-center text-base shadow-xs transition-transform group-hover:scale-105">
                <i class="fa-regular xx fa-wallet text-[#C7D2FE]"></i>
            </span>
            <span class="leading-tight font-bold">
                Budget <span class="text-[#312E81] font-semibold text-xs px-2 py-0.5 rounded-full bg-[#EEF2FF]">by AkuOnline</span>
            </span>
        </a>
        <h2 class="mt-4 text-xl font-black tracking-tight text-slate-900">
            {{ $heading ?? 'Kelola Keuangan Lebih Mudah' }}
        </h2>
        <p class="mt-1 text-xs text-slate-500">
            {{ $subheading ?? 'Sistem Kantong & Expense Tracker Anti Ribet' }}
        </p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
        <div class="card-soft rounded-2xl py-7 px-6 sm:px-8 border border-slate-200/90 shadow-sm bg-white">
            {{ $slot }}
        </div>
    </div>

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
</body>
</html>
