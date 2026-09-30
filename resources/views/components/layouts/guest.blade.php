<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Autentikasi' }} - {{ config('app.name', 'Budget') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-zinc-100/70 text-zinc-900 font-sans antialiased flex flex-col justify-center py-12 sm:px-6 lg:px-8 selection:bg-zinc-900 selection:text-white">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="/" class="inline-flex items-center gap-2.5 text-zinc-900 font-semibold tracking-tight text-lg">
            <span class="w-9 h-9 rounded-lg bg-zinc-900 text-white flex items-center justify-center text-base shadow-xs">
                <i class="fa-solid fa-wallet"></i>
            </span>
            <span>Budget<span class="text-zinc-500 font-normal">Tracker</span></span>
        </a>
        <h2 class="mt-4 text-xl font-bold tracking-tight text-zinc-900">
            {{ $heading ?? 'Kelola Keuangan Lebih Mudah' }}
        </h2>
        <p class="mt-1 text-xs text-zinc-500">
            {{ $subheading ?? 'Sistem Kantong & Expense Tracker Anti Ribet' }}
        </p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
        <div class="bg-white py-8 px-6 sm:px-8 border border-zinc-200/90 rounded-lg shadow-xs">
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
