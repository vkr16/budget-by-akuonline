<x-layouts.app title="Dashboard">
    <!-- Top Greeting & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 gap-3">
        <div class="flex items-center gap-3">
            <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] flex items-center justify-center text-[#312E81] text-base shrink-0 shadow-xs">
                <i class="fa-regular xx fa-wallet"></i>
            </span>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Halo, {{ $user->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Kelola aliran dana kantong anggaran Anda hari ini.
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('pockets.index') }}" class="btn-secondary text-xs px-3.5 py-2 rounded-xl cursor-pointer touch-press inline-flex items-center gap-1.5">
                <i class="fa-regular xx fa-boxes-stacked text-xs text-[#312E81]"></i>
                <span>Kelola Kantong</span>
            </a>
            <a href="{{ route('transactions.index') }}" class="btn-secondary text-xs px-3.5 py-2 rounded-xl cursor-pointer touch-press inline-flex items-center gap-1.5">
                <i class="fa-regular xx fa-list-ul text-xs text-[#312E81]"></i>
                <span>Semua Riwayat</span>
            </a>
        </div>
    </div>

    <!-- Hero Balance & Metrics Card -->
    <div class="mb-8">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#5b57cf] via-[#292671] to-[#3b3684] text-white p-6 sm:p-7 shadow-lg">
            <!-- Decorative Glow Circles -->
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-indigo-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-1/4 -bottom-16 w-56 h-56 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-xs font-semibold uppercase tracking-wider text-indigo-200">
                            Total Saldo Semua Kantong
                        </span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-xs text-xs font-medium text-indigo-100 border border-white/10 self-start sm:self-auto">
                        <i class="fa-regular xx fa-boxes-stacked text-[11px]"></i>
                        <span>{{ $pockets->count() }} Kantong Aktif</span>
                    </span>
                </div>

                <!-- Big Main Balance -->
                <div class="mt-3 sm:mt-4 text-3xl sm:text-4xl lg:text-5xl font-extrabold font-mono-numbers tracking-tight text-white">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </div>

                <!-- Three Stat Columns in Card Footer -->
                <div class="mt-6 pt-5 border-t border-white/15 grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <!-- Income -->
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0">
                            <i class="fa-regular xx fa-arrow-down-left text-xs"></i>
                        </span>
                        <div>
                            <span class="text-indigo-200 text-[11px] block">Pemasukan Bulan Ini</span>
                            <span class="text-sm sm:text-base font-bold font-mono-numbers text-emerald-300">
                                + Rp {{ number_format($monthIncome, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Expense -->
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-300 flex items-center justify-center shrink-0">
                            <i class="fa-regular xx fa-arrow-up-right text-xs"></i>
                        </span>
                        <div>
                            <span class="text-indigo-200 text-[11px] block">Pengeluaran Bulan Ini</span>
                            <span class="text-sm sm:text-base font-bold font-mono-numbers text-rose-300">
                                - Rp {{ number_format($monthExpense, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Net Flow -->
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-white/10 text-indigo-200 flex items-center justify-center shrink-0">
                            <i class="fa-regular xx fa-scale-balanced text-xs"></i>
                        </span>
                        <div>
                            <span class="text-indigo-200 text-[11px] block">Arus Bersih ({{ $netFlow >= 0 ? 'Surplus' : 'Defisit' }})</span>
                            <span class="text-sm sm:text-base font-bold font-mono-numbers {{ $netFlow >= 0 ? 'text-white' : 'text-rose-300' }}">
                                Rp {{ number_format($netFlow, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Section: Left = Fast Input ("Anti-Malas"), Right = Kantong Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <!-- Frictionless Fast Record Box (Anti-Malas Nginput) -->
        <div class="lg:col-span-5">
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-xl bg-[#312E81] text-white flex items-center justify-center text-xs shadow-xs">
                            <i class="fa-regular xx fa-bolt"></i>
                        </span>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Catat Transaksi Cepat</h2>
                            <p class="text-[11px] text-slate-400">Anti-malas, langsung update saldo</p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-[#EEF2FF] text-[#312E81] text-[10px] font-semibold">
                        Instant
                    </span>
                </div>

                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- 1. Type In or Out Toggle -->
                    <div>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="out" class="peer sr-only" checked onchange="updateInlinePocketLabel('out')">
                                <div class="py-2.5 px-3 min-h-[44px] rounded-xl border border-slate-200 text-center text-xs font-semibold text-slate-600 peer-checked:bg-rose-50 peer-checked:text-rose-700 peer-checked:border-rose-300 peer-checked:ring-1 peer-checked:ring-rose-300 transition flex items-center justify-center gap-1.5 cursor-pointer touch-press">
                                    <i class="fa-regular xx fa-arrow-up-right text-xs"></i>
                                    <span>Pengeluaran (Out)</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="in" class="peer sr-only" onchange="updateInlinePocketLabel('in')">
                                <div class="py-2.5 px-3 min-h-[44px] rounded-xl border border-slate-200 text-center text-xs font-semibold text-slate-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 peer-checked:border-emerald-300 peer-checked:ring-1 peer-checked:ring-emerald-300 transition flex items-center justify-center gap-1.5 cursor-pointer touch-press">
                                    <i class="fa-regular xx fa-arrow-down-left text-xs"></i>
                                    <span>Pemasukan (In)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- 2. Nominal Input -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Nominal (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-mono-numbers text-sm font-bold">
                                Rp
                            </span>
                            <input type="text"
                                   data-currency-input
                                   data-currency-target="inline-amount-raw"
                                   placeholder="0"
                                   required
                                   autocomplete="off"
                                   class="w-full pl-11 pr-3 py-2.5 sm:py-3 min-h-[46px] text-lg font-bold font-mono-numbers bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900">
                            <input type="hidden" name="amount" id="inline-amount-raw">
                        </div>
                        <!-- Quick Add Buttons -->
                        <div class="flex items-center gap-1.5 mt-2 flex-wrap text-xs">
                            <button type="button" data-preset-amount="10000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+10k</button>
                            <button type="button" data-preset-amount="20000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+20k</button>
                            <button type="button" data-preset-amount="50000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+50k</button>
                            <button type="button" data-preset-amount="100000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+100k</button>
                            <button type="button" data-preset-amount="500000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+500k</button>
                        </div>
                    </div>

                    <!-- 3. Pocket Selector -->
                    <div>
                        <label id="inline-pocket-label" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Dari Kantong Mana? <span class="text-rose-500">*</span>
                        </label>
                        <select name="pocket_id" required class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 cursor-pointer">
                            @foreach($pockets as $pkt)
                                <option value="{{ $pkt->id }}">
                                    {{ $pkt->name }} — Sisa: Rp {{ number_format($pkt->current_balance, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 4. Date & Time (Autofilled to Current Timestamp) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Waktu Transaksi
                        </label>
                        <input type="datetime-local"
                               name="date"
                               data-autofill-now
                               required
                               class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 cursor-pointer">
                    </div>

                    <!-- 5. Keterangan (Opsional) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Keterangan <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <input type="text"
                               name="description"
                               placeholder="Contoh: Makan siang warteg, bayar pulsa, dll."
                               class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
                    </div>

                    <button type="submit"
                            class="w-full btn-primary min-h-[44px] rounded-xl px-4 py-2.5 text-sm font-semibold shadow-sm flex items-center justify-center gap-2 cursor-pointer touch-press">
                        <i class="fa-regular xx fa-plus text-xs"></i>
                        <span>Simpan Transaksi Sekarang</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Kantong Overview (Pockets Grid) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-xl bg-[#EEF2FF] flex items-center justify-center text-[#312E81] text-xs">
                            <i class="fa-regular xx fa-boxes-stacked"></i>
                        </span>
                        <h2 class="text-sm font-bold text-slate-800">Kantong Anggaran Saya</h2>
                    </div>
                    <a href="{{ route('pockets.index') }}" class="text-xs font-semibold text-[#312E81] hover:text-[#1E1B4B] flex items-center gap-1.5 transition cursor-pointer">
                        <span>Semua Kantong</span>
                        <i class="fa-regular xx fa-chevron-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    @forelse($pockets as $pocket)
                        <a href="{{ route('pockets.show', $pocket) }}"
                           class="block p-4 rounded-xl border border-slate-200 hover:border-[#312E81] hover:shadow-xs transition bg-slate-50/50 hover:bg-white group cursor-pointer touch-press">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-sm group-hover:scale-105 transition">
                                        <i class="fa-regular xx {{ $pocket->icon ?: 'fa-wallet' }}"></i>
                                    </span>
                                    <div>
                                        <h3 class="text-xs font-bold text-slate-800 group-hover:text-[#312E81] transition">
                                            {{ $pocket->name }}
                                        </h3>
                                        <p class="text-[11px] text-slate-400">
                                            {{ $pocket->transactions_count }} transaksi
                                        </p>
                                    </div>
                                </div>
                                <span class="text-slate-300 group-hover:text-[#312E81] text-xs transition">
                                    <i class="fa-regular xx fa-arrow-right text-[11px]"></i>
                                </span>
                            </div>

                            <div class="mt-3.5 pt-2.5 border-t border-slate-100 flex items-baseline justify-between">
                                <span class="text-[11px] text-slate-400 font-medium">Saldo:</span>
                                <span class="text-sm font-bold font-mono-numbers text-slate-900 group-hover:text-[#312E81] transition">
                                    Rp {{ number_format($pocket->current_balance, 0, ',', '.') }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-2 py-8 text-center text-slate-400 text-xs">
                            <i class="fa-regular xx fa-box-open text-2xl mb-2 text-slate-300"></i>
                            <p>Belum ada kantong aktif.</p>
                            <a href="{{ route('pockets.index') }}" class="text-[#312E81] font-semibold hover:underline mt-1 inline-block cursor-pointer">
                                Buat Kantong Pertama
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Tips Card -->
            <div class="p-4 rounded-2xl border border-indigo-100 bg-[#EEF2FF]/40 text-xs text-slate-600 flex items-start gap-3">
                <span class="w-7 h-7 rounded-xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center shrink-0 mt-0.5 text-xs">
                    <i class="fa-regular xx fa-lightbulb"></i>
                </span>
                <div>
                    <p class="font-bold text-slate-800">Tips Mengatur Kantong:</p>
                    <p class="text-slate-500 mt-0.5 leading-relaxed">
                        Pisahkan dana harian, tabungan, dan dana darurat ke kantong berbeda. Saat mencatat pengeluaran, pilih kantong sumbernya agar saldo terpotong akurat.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table / List -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-xl bg-[#EEF2FF] flex items-center justify-center text-[#312E81] text-xs">
                    <i class="fa-regular xx fa-clock-rotate-left"></i>
                </span>
                <h2 class="text-sm font-bold text-slate-800">Transaksi Terkini</h2>
            </div>
            <a href="{{ route('transactions.index') }}" class="text-xs font-semibold text-[#312E81] hover:text-[#1E1B4B] flex items-center gap-1 transition cursor-pointer">
                <span>Lihat Semua</span>
                <i class="fa-regular xx fa-chevron-right text-[10px]"></i>
            </a>
        </div>

        <!-- Mobile Stacked Card View (Block on sm:hidden) -->
        <div class="block sm:hidden divide-y divide-slate-100">
            @forelse($recentTransactions as $transaction)
                <div class="p-3.5 hover:bg-slate-50/70 transition">
                    <div class="flex items-start gap-3">
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center text-xs shrink-0 mt-0.5 {{ $transaction->type === 'in' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                            <i class="fa-regular xx {{ $transaction->type === 'in' ? 'fa-arrow-down-left' : 'fa-arrow-up-right' }}"></i>
                        </span>

                        <div class="flex-1 min-w-0">
                            <!-- Baris 1: Keterangan Transaksi & Nominal -->
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-xs font-bold text-slate-900 leading-snug break-words">
                                    {{ $transaction->description ?: ($transaction->type === 'in' ? 'Pemasukan' : 'Pengeluaran') }}
                                </p>
                                <span class="text-xs font-bold font-mono-numbers whitespace-nowrap shrink-0 text-right {{ $transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                    {{ $transaction->type === 'in' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Baris 2: Kantong & Aksi Hapus -->
                            <div class="flex items-center justify-between gap-2 mt-1.5 pt-0.5">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-medium text-[10px] truncate max-w-[200px]">
                                    <i class="fa-regular xx {{ $transaction->pocket->icon ?: 'fa-wallet' }} text-[9px] text-slate-400"></i>
                                    <span class="truncate">{{ $transaction->pocket->name }}</span>
                                </span>

                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            data-confirm="Hapus transaksi ini? Saldo kantong {{ $transaction->pocket->name }} akan disesuaikan otomatis."
                                            data-confirm-title="Hapus Transaksi"
                                            class="p-1 rounded-md text-slate-300 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer touch-target-sm inline-flex items-center justify-center"
                                            title="Hapus Transaksi">
                                        <i class="fa-regular xx fa-trash-can text-[11px]"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Baris 3: Tanggal & Waktu Transaksi -->
                            <div class="mt-1">
                                <span class="font-mono-numbers text-slate-400 text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                    <i class="fa-regular xx fa-calendar-day text-[9px] text-slate-400"></i>
                                    {{ $transaction->date->format('d M Y, H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 text-xs">
                    <p>Belum ada catatan transaksi.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Clean Table View (Hidden on mobile, block on sm+) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-500 font-medium">
                    <tr>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Tipe & Keterangan</th>
                        <th class="py-3 px-4">Kantong</th>
                        <th class="py-3 px-4 text-right">Nominal</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-4 whitespace-nowrap text-slate-500 font-mono-numbers text-[11px]">
                                {{ $transaction->date->format('d M Y, H:i') }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-lg flex items-center justify-center text-[10px] shrink-0 {{ $transaction->type === 'in' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                        <i class="fa-regular xx {{ $transaction->type === 'in' ? 'fa-arrow-down-left' : 'fa-arrow-up-right' }}"></i>
                                    </span>
                                    <span class="font-semibold text-slate-800">
                                        {{ $transaction->description ?: ($transaction->type === 'in' ? 'Pemasukan' : 'Pengeluaran') }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-[#EEF2FF] text-[#312E81]">
                                    <i class="fa-regular xx fa-wallet text-[9px] opacity-80"></i>
                                    {{ $transaction->pocket->name }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap font-mono-numbers font-bold text-xs {{ $transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $transaction->type === 'in' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            data-confirm="Hapus transaksi ini? Saldo kantong {{ $transaction->pocket->name }} akan disesuaikan otomatis."
                                            data-confirm-title="Hapus Transaksi"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 transition cursor-pointer touch-target-sm"
                                            title="Hapus Transaksi">
                                        <i class="fa-regular xx fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                <p>Belum ada catatan transaksi.</p>
                                <p class="text-[11px] text-slate-400 mt-1">Gunakan formulir di atas untuk mencatat transaksi pertama Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
    function updateInlinePocketLabel(type) {
        const label = document.getElementById('inline-pocket-label');
        if (!label) return;
        if (type === 'in') {
            label.innerHTML = 'Tujuan ke Kantong Mana? <span class="text-rose-500">*</span>';
        } else {
            label.innerHTML = 'Dari Kantong Mana? <span class="text-rose-500">*</span>';
        }
    }
    </script>
    @endpush
</x-layouts.app>

