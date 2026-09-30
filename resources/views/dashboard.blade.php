<x-layouts.app title="Dashboard">
    <!-- Top Greeting & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900">
                Halo, {{ $user->name }}
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">
                Kelola aliran dana kantong anggaran Anda hari ini.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('pockets.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 text-xs font-medium transition shadow-xs">
                <i class="fa-solid fa-boxes-stacked text-xs text-zinc-500"></i> Kelola Kantong
            </a>
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 text-xs font-medium transition shadow-xs">
                <i class="fa-solid fa-list-ul text-xs text-zinc-500"></i> Semua Riwayat
            </a>
        </div>
    </div>

    <!-- Summary Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Net Balance -->
        <div class="bg-white p-4 rounded-lg border border-zinc-200/90 shadow-xs">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-medium">Total Saldo Semua Kantong</span>
                <span class="w-7 h-7 rounded-md bg-zinc-100 flex items-center justify-center text-zinc-700">
                    <i class="fa-solid fa-wallet text-xs"></i>
                </span>
            </div>
            <div class="mt-2 text-xl font-bold font-mono text-zinc-900 tracking-tight">
                Rp {{ number_format($totalBalance, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-zinc-400 mt-1">
                Akumulasi dari {{ $pockets->count() }} kantong aktif
            </p>
        </div>

        <!-- Month Income -->
        <div class="bg-white p-4 rounded-lg border border-zinc-200/90 shadow-xs">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-medium">Pemasukan Bulan Ini</span>
                <span class="w-7 h-7 rounded-md bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-down-left text-xs"></i>
                </span>
            </div>
            <div class="mt-2 text-xl font-bold font-mono text-emerald-700 tracking-tight">
                Rp {{ number_format($monthIncome, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-zinc-400 mt-1">
                {{ now()->translatedFormat('F Y') }}
            </p>
        </div>

        <!-- Month Expense -->
        <div class="bg-white p-4 rounded-lg border border-zinc-200/90 shadow-xs">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-medium">Pengeluaran Bulan Ini</span>
                <span class="w-7 h-7 rounded-md bg-rose-50 text-rose-700 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-up-right text-xs"></i>
                </span>
            </div>
            <div class="mt-2 text-xl font-bold font-mono text-rose-700 tracking-tight">
                Rp {{ number_format($monthExpense, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-zinc-400 mt-1">
                {{ now()->translatedFormat('F Y') }}
            </p>
        </div>

        <!-- Net Flow -->
        <div class="bg-white p-4 rounded-lg border border-zinc-200/90 shadow-xs">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-medium">Arus Kas Bersih (Net)</span>
                <span class="w-7 h-7 rounded-md bg-zinc-100 text-zinc-700 flex items-center justify-center">
                    <i class="fa-solid fa-scale-balanced text-xs"></i>
                </span>
            </div>
            <div class="mt-2 text-xl font-bold font-mono tracking-tight {{ $netFlow >= 0 ? 'text-zinc-900' : 'text-rose-600' }}">
                Rp {{ number_format($netFlow, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-zinc-400 mt-1">
                {{ $netFlow >= 0 ? 'Surplus bulan ini' : 'Defisit bulan ini' }}
            </p>
        </div>
    </div>

    <!-- Main Section: Left = Fast Input ("Anti-Malas"), Right = Kantong Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <!-- Frictionless Fast Record Box (Anti-Malas Nginput) -->
        <div class="lg:col-span-5">
            <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-xs">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-md bg-zinc-900 text-white flex items-center justify-center text-xs">
                            <i class="fa-solid fa-bolt"></i>
                        </span>
                        <h2 class="text-sm font-bold text-zinc-900">Catat Transaksi Cepat</h2>
                    </div>
                    <span class="text-[11px] text-zinc-400">Anti-Ribet</span>
                </div>

                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- 1. Type In or Out Toggle -->
                    <div>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="out" class="peer sr-only" checked onchange="updateInlinePocketLabel('out')">
                                <div class="py-2 px-3 rounded-md border border-zinc-200 text-center text-xs font-semibold text-zinc-600 peer-checked:bg-rose-50 peer-checked:text-rose-700 peer-checked:border-rose-300 peer-checked:ring-1 peer-checked:ring-rose-300 transition flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-arrow-up-right text-xs"></i>
                                    <span>Pengeluaran (Out)</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="in" class="peer sr-only" onchange="updateInlinePocketLabel('in')">
                                <div class="py-2 px-3 rounded-md border border-zinc-200 text-center text-xs font-semibold text-zinc-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 peer-checked:border-emerald-300 peer-checked:ring-1 peer-checked:ring-emerald-300 transition flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-arrow-down-left text-xs"></i>
                                    <span>Pemasukan (In)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- 2. Nominal Input -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Nominal (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400 font-mono text-sm font-semibold">
                                Rp
                            </span>
                            <input type="text" 
                                   data-currency-input 
                                   data-currency-target="inline-amount-raw" 
                                   placeholder="0" 
                                   required 
                                   autocomplete="off"
                                   class="w-full pl-11 pr-3 py-2.5 text-base font-semibold font-mono bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                            <input type="hidden" name="amount" id="inline-amount-raw">
                        </div>
                        <!-- Quick Add Buttons -->
                        <div class="flex items-center gap-1.5 mt-2 flex-wrap text-xs">
                            <button type="button" data-preset-amount="10000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 font-mono transition text-[11px]">+10k</button>
                            <button type="button" data-preset-amount="20000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 font-mono transition text-[11px]">+20k</button>
                            <button type="button" data-preset-amount="50000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 font-mono transition text-[11px]">+50k</button>
                            <button type="button" data-preset-amount="100000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 font-mono transition text-[11px]">+100k</button>
                            <button type="button" data-preset-amount="500000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 font-mono transition text-[11px]">+500k</button>
                        </div>
                    </div>

                    <!-- 3. Pocket Selector -->
                    <div>
                        <label id="inline-pocket-label" class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Dari Kantong Mana? <span class="text-rose-500">*</span>
                        </label>
                        <select name="pocket_id" required class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                            @foreach($pockets as $pkt)
                                <option value="{{ $pkt->id }}">
                                    {{ $pkt->name }} — Sisa: Rp {{ number_format($pkt->current_balance, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 4. Date & Time (Autofilled to Current Timestamp) -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Waktu Transaksi
                        </label>
                        <input type="datetime-local" 
                               name="date" 
                               data-autofill-now 
                               required 
                               class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                    </div>

                    <!-- 5. Keterangan (Opsional) -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Keterangan <span class="text-zinc-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <input type="text" 
                               name="description" 
                               placeholder="Contoh: Makan siang warteg, bayar pulsa, dll." 
                               class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900 placeholder-zinc-400">
                    </div>

                    <button type="submit" 
                            class="w-full py-2.5 px-4 rounded-md bg-zinc-900 hover:bg-zinc-800 text-white font-medium text-sm transition shadow-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Simpan Transaksi Sekarang</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Kantong Overview (Pockets Grid) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-xs">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-md bg-zinc-100 flex items-center justify-center text-zinc-700 text-xs">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </span>
                        <h2 class="text-sm font-bold text-zinc-900">Kantong Anggaran Saya</h2>
                    </div>
                    <a href="{{ route('pockets.index') }}" class="text-xs font-medium text-zinc-600 hover:text-zinc-900 flex items-center gap-1 transition">
                        <span>Kelola Kantong</span>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @forelse($pockets as $pocket)
                        <div class="p-3.5 rounded-lg border border-zinc-200 hover:border-zinc-300 transition bg-zinc-50/40">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-md bg-zinc-200/70 text-zinc-700 flex items-center justify-center text-xs">
                                        <i class="fa-solid {{ $pocket->icon ?: 'fa-wallet' }}"></i>
                                    </span>
                                    <div>
                                        <a href="{{ route('pockets.show', $pocket) }}" class="text-xs font-semibold text-zinc-900 hover:underline">
                                            {{ $pocket->name }}
                                        </a>
                                        <p class="text-[11px] text-zinc-400">
                                            {{ $pocket->transactions_count }} transaksi
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('pockets.show', $pocket) }}" class="text-zinc-400 hover:text-zinc-700 text-xs p-1" title="Lihat detail kantong">
                                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                                </a>
                            </div>

                            <div class="mt-3 pt-2 border-t border-zinc-100 flex items-baseline justify-between">
                                <span class="text-[11px] text-zinc-500">Saldo saat ini:</span>
                                <span class="text-sm font-bold font-mono text-zinc-900">
                                    Rp {{ number_format($pocket->current_balance, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 py-8 text-center text-zinc-400 text-xs">
                            <i class="fa-solid fa-box-open text-2xl mb-2 text-zinc-300"></i>
                            <p>Belum ada kantong aktif.</p>
                            <a href="{{ route('pockets.index') }}" class="text-zinc-900 font-medium hover:underline mt-1 inline-block">
                                Buat Kantong Pertama
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Tips Card (Clean & Helpful, Not AI slop) -->
            <div class="p-4 rounded-lg border border-zinc-200 bg-white/70 text-xs text-zinc-600 flex items-start gap-3">
                <span class="w-6 h-6 rounded-md bg-zinc-100 text-zinc-700 flex items-center justify-center shrink-0 mt-0.5 text-xs">
                    <i class="fa-solid fa-lightbulb"></i>
                </span>
                <div>
                    <p class="font-semibold text-zinc-800">Tips Penggunaan Kantong:</p>
                    <p class="text-zinc-500 mt-0.5 leading-relaxed">
                        Pisahkan dana harian, tabungan, dan dana darurat ke dalam kantong berbeda. Saat mencatat pengeluaran, cukup pilih kantong sumbernya agar saldo terpotong akurat.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table / List -->
    <div class="bg-white rounded-lg border border-zinc-200/90 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-zinc-100">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-md bg-zinc-100 flex items-center justify-center text-zinc-700 text-xs">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </span>
                <h2 class="text-sm font-bold text-zinc-900">Transaksi Terkini</h2>
            </div>
            <a href="{{ route('transactions.index') }}" class="text-xs font-medium text-zinc-600 hover:text-zinc-900 flex items-center gap-1 transition">
                <span>Lihat Semua Transaksi</span>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50/70 border-b border-zinc-100 text-zinc-500 font-medium">
                    <tr>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Tipe & Keterangan</th>
                        <th class="py-3 px-4">Kantong</th>
                        <th class="py-3 px-4 text-right">Nominal</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-zinc-50/50 transition">
                            <td class="py-3 px-4 whitespace-nowrap text-zinc-500 font-mono text-[11px]">
                                {{ $transaction->date->format('d M Y, H:i') }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] shrink-0 {{ $transaction->type === 'in' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                        <i class="fa-solid {{ $transaction->type === 'in' ? 'fa-arrow-down-left' : 'fa-arrow-up-right' }}"></i>
                                    </span>
                                    <span class="font-medium text-zinc-900">
                                        {{ $transaction->description ?: ($transaction->type === 'in' ? 'Pemasukan' : 'Pengeluaran') }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-zinc-100 text-zinc-700">
                                    <i class="fa-solid fa-wallet text-[9px] opacity-70"></i>
                                    {{ $transaction->pocket->name }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap font-mono font-semibold {{ $transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $transaction->type === 'in' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            data-confirm="Hapus transaksi ini? Saldo kantong {{ $transaction->pocket->name }} akan disesuaikan otomatis." 
                                            data-confirm-title="Hapus Transaksi"
                                            class="p-1 rounded text-zinc-400 hover:text-rose-600 transition" 
                                            title="Hapus Transaksi">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-zinc-400">
                                <p>Belum ada catatan transaksi.</p>
                                <p class="text-[11px] text-zinc-400 mt-1">Gunakan form di atas untuk mencatat pengeluaran atau pemasukan pertama Anda.</p>
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
