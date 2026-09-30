<x-layouts.guest title="Daftar Akun Baru" heading="Mulai Kelola Budget" subheading="Gratis, cepat, dan otomatis disiapkan kantong pertama">
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                Nama Lengkap
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 text-xs">
                    <i class="fa-solid fa-user"></i>
                </span>
                <input id="name" 
                       name="name" 
                       type="text" 
                       autocomplete="name" 
                       required 
                       value="{{ old('name') }}"
                       placeholder="Contoh: Fikri Ramadhan"
                       class="w-full pl-9 pr-3 py-2 text-sm bg-zinc-50/50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900 placeholder-zinc-400">
            </div>
            @error('name')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                Alamat Email
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 text-xs">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input id="email" 
                       name="email" 
                       type="email" 
                       autocomplete="email" 
                       required 
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       class="w-full pl-9 pr-3 py-2 text-sm bg-zinc-50/50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900 placeholder-zinc-400">
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                Kata Sandi
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 text-xs">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input id="password" 
                       name="password" 
                       type="password" 
                       autocomplete="new-password" 
                       required 
                       placeholder="Minimal 6 karakter"
                       class="w-full pl-9 pr-3 py-2 text-sm bg-zinc-50/50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900 placeholder-zinc-400">
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 text-xs">
                    <i class="fa-solid fa-lock-open"></i>
                </span>
                <input id="password_confirmation" 
                       name="password_confirmation" 
                       type="password" 
                       autocomplete="new-password" 
                       required 
                       placeholder="Ulangi kata sandi"
                       class="w-full pl-9 pr-3 py-2 text-sm bg-zinc-50/50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900 placeholder-zinc-400">
            </div>
        </div>

        <div class="p-3 bg-zinc-50 rounded-md border border-zinc-200/70 text-xs text-zinc-600 flex items-start gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
            <span>Sistem akan langsung membuatkan <strong>Kantong Utama</strong> secara otomatis saat Anda mendaftar.</span>
        </div>

        <div class="pt-2">
            <button type="submit" 
                    class="w-full py-2.5 px-4 rounded-md bg-zinc-900 hover:bg-zinc-800 text-white font-medium text-sm transition shadow-xs flex items-center justify-center gap-2">
                <span>Daftar Akun Baru</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>

        <div class="mt-4 pt-4 border-t border-zinc-100 text-center text-xs text-zinc-500">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-medium text-zinc-900 hover:underline">
                Masuk ke sini
            </a>
        </div>
    </form>
</x-layouts.guest>
