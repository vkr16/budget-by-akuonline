<x-layouts.guest title="Daftar Akun Baru" heading="Mulai Kelola Budget" subheading="Gratis, cepat, dan otomatis disiapkan kantong pertama">
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                Nama Lengkap
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                    <i class="fa-regular xx fa-user"></i>
                </span>
                <input id="name"
                       name="name"
                       type="text"
                       autocomplete="name"
                       required
                       value="{{ old('name') }}"
                       placeholder="Contoh: Fikri Ramadhan"
                       class="w-full pl-10 pr-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
            </div>
            @error('name')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

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
                       autocomplete="new-password"
                       required
                       placeholder="Minimal 6 karakter"
                       class="w-full pl-10 pr-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                    <i class="fa-regular xx fa-lock-open"></i>
                </span>
                <input id="password_confirmation"
                       name="password_confirmation"
                       type="password"
                       autocomplete="new-password"
                       required
                       placeholder="Ulangi kata sandi"
                       class="w-full pl-10 pr-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
            </div>
        </div>

        <div class="p-3.5 bg-[#EEF2FF]/60 rounded-xl border border-indigo-100 text-xs text-slate-600 flex items-start gap-2.5">
            <i class="fa-regular xx fa-circle-check text-emerald-600 mt-0.5 text-sm shrink-0"></i>
            <span>Sistem akan langsung membuatkan <strong>Kantong Utama</strong> secara otomatis saat Anda mendaftar.</span>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="w-full btn-primary min-h-[46px] rounded-xl px-4 py-3 text-sm font-semibold shadow-sm flex items-center justify-center gap-2 cursor-pointer touch-press">
                <span>Daftar Akun Baru</span>
                <i class="fa-regular xx fa-arrow-right text-xs"></i>
            </button>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-semibold text-[#312E81] hover:underline cursor-pointer">
                Masuk ke sini
            </a>
        </div>
    </form>
</x-layouts.guest>

