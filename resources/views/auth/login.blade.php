<x-layouts.guest title="Masuk ke Akun" heading="Masuk ke Akun" subheading="Pantau dan catat pengeluaran kantong Anda">
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                Alamat Email
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                    <i class="fa-regular xx fa-envelope"></i>
                </span>
                <input id="email"
                       name="email"
                       type="email"
                       autocomplete="email"
                       required
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       class="w-full pl-10 pr-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                Kata Sandi
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                    <i class="fa-regular xx fa-lock"></i>
                </span>
                <input id="password"
                       name="password"
                       type="password"
                       autocomplete="current-password"
                       required
                       placeholder="••••••••"
                       class="w-full pl-10 pr-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
            <label class="flex items-center gap-2 cursor-pointer text-slate-600 select-none">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded-md border-slate-300 text-[#312E81] focus:ring-[#312E81] cursor-pointer">
                <span>Ingat saya di perangkat ini</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="w-full btn-primary min-h-[46px] rounded-xl px-4 py-3 text-sm font-semibold shadow-sm flex items-center justify-center gap-2 cursor-pointer touch-press">
                <span>Masuk Sekarang</span>
                <i class="fa-regular xx fa-arrow-right text-xs"></i>
            </button>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-semibold text-[#312E81] hover:underline cursor-pointer">
                Daftar sekarang
            </a>
        </div>
    </form>
</x-layouts.guest>

