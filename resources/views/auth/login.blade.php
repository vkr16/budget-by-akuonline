<x-layouts.guest title="Masuk ke Akun" heading="Masuk ke Akun" subheading="Pantau dan catat pengeluaran kantong Anda">
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

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
                       autocomplete="current-password" 
                       required 
                       placeholder="••••••••"
                       class="w-full pl-9 pr-3 py-2 text-sm bg-zinc-50/50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900 placeholder-zinc-400">
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
            <label class="flex items-center gap-2 cursor-pointer text-zinc-600 select-none">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900">
                <span>Ingat saya di perangkat ini</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" 
                    class="w-full py-2.5 px-4 rounded-md bg-zinc-900 hover:bg-zinc-800 text-white font-medium text-sm transition shadow-xs flex items-center justify-center gap-2">
                <span>Masuk Sekarang</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>

        <div class="mt-4 pt-4 border-t border-zinc-100 text-center text-xs text-zinc-500">
            Belum memiliki akun? 
            <a href="{{ route('register') }}" class="font-medium text-zinc-900 hover:underline">
                Daftar sekarang
            </a>
        </div>
    </form>
</x-layouts.guest>
