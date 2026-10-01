<x-layouts.app title="Riwayat Transaksi">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 gap-3">
        <div class="flex items-center gap-3">
            <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] flex items-center justify-center text-[#312E81] text-base shrink-0 shadow-xs">
                <i class="fa-regular xx fa-receipt"></i>
            </span>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Riwayat Transaksi
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Daftar semua arus transaksi masuk dan keluar dari kantong Anda.
                </p>
            </div>
        </div>
        <button class="btn-primary min-h-[44px] rounded-xl px-4 py-2.5 text-sm font-semibold cursor-pointer touch-press shadow-sm inline-flex items-center gap-2 self-start sm:self-auto" type="button" onclick="document.getElementById('quick-transaction-modal').classList.remove('hidden')">
            <i class="fa-regular xx fa-plus text-xs"></i>
            <span>Catat Transaksi Baru</span>
        </button>
    </div>

    @php
        $activeFiltersCount = count(array_filter($filters));
    @endphp

    <!-- Filter Bar Card -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs mb-6">
        <form class="space-y-4 text-xs" method="GET" action="{{ route('transactions.index') }}">

            <!-- Baris 1: Parameter Filter Spesifik (4 Kolom Proporsional) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 pt-3.5 border-t border-slate-100">
                <!-- Filter Tipe -->
                <div>
                    <label class="block font-semibold text-slate-600 mb-1.5 uppercase text-[10px] tracking-wider">Tipe Transaksi</label>
                    <select class="w-full px-3 py-2 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white text-slate-800 cursor-pointer" name="type">
                        <option value="">Semua Tipe</option>
                        <option value="in" {{ ($filters['type'] ?? '') === 'in' ? 'selected' : '' }}>Pemasukan (In)</option>
                        <option value="out" {{ ($filters['type'] ?? '') === 'out' ? 'selected' : '' }}>Pengeluaran (Out)</option>
                    </select>
                </div>

                <!-- Filter Kantong -->
                <div>
                    <label class="block font-semibold text-slate-600 mb-1.5 uppercase text-[10px] tracking-wider">Kantong</label>
                    <select class="w-full px-3 py-2 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white text-slate-800 cursor-pointer" name="pocket_id">
                        <option value="">Semua Kantong</option>
                        @foreach ($pockets as $pkt)
                            <option value="{{ $pkt->id }}" {{ ($filters['pocket_id'] ?? '') == $pkt->id ? 'selected' : '' }}>
                                {{ $pkt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tanggal Dari -->
                <div>
                    <label class="block font-semibold text-slate-600 mb-1.5 uppercase text-[10px] tracking-wider">Dari Tanggal</label>
                    <input class="w-full px-3 py-2 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white text-slate-800 cursor-pointer" name="date_from" type="date" value="{{ $filters['date_from'] ?? '' }}">
                </div>

                <!-- Filter Tanggal Sampai -->
                <div>
                    <label class="block font-semibold text-slate-600 mb-1.5 uppercase text-[10px] tracking-wider">Sampai Tanggal</label>
                    <input class="w-full px-3 py-2 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white text-slate-800 cursor-pointer" name="date_to" type="date" value="{{ $filters['date_to'] ?? '' }}">
                </div>
            </div>

            <!-- Baris 2: Kolom Cari Keterangan (Luas & Nyaman) + Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block font-semibold text-slate-600 uppercase text-[10px] tracking-wider">
                            Cari Keterangan
                        </label>
                    </div>
                    <div class="relative">
                        <i class="fa-regular xx fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input class="w-full pl-9 pr-4 py-2 min-h-[44px] bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white text-slate-800 placeholder-slate-400 text-base sm:text-sm transition-colors" name="search" type="text" value="{{ $filters['search'] ?? '' }}" placeholder="Cari berdasarkan keterangan transaksi (contoh: Kopi, Makan Siang, Gaji...)">
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @if ($activeFiltersCount > 0)
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#312E81] bg-[#EEF2FF] px-3.5 py-2 min-h-[44px] rounded-xl border border-indigo-100">
                            <i class="fa-regular xx fa-filter text-[11px]"></i>
                            <span>{{ $activeFiltersCount }} filter aktif</span>
                        </span>
                    @endif
                    <button class="btn-primary min-h-[44px] px-4.5 rounded-xl text-sm font-semibold cursor-pointer touch-press shadow-sm inline-flex items-center justify-center gap-2 flex-1 sm:flex-none" type="submit">
                        <i class="fa-regular xx fa-filter text-xs"></i>
                        <span>Terapkan Filter</span>
                    </button>
                    @if ($activeFiltersCount > 0)
                        <a class="btn-secondary min-h-[44px] px-3.5 rounded-xl text-sm font-semibold cursor-pointer touch-press inline-flex items-center justify-center gap-1.5 text-slate-700" href="{{ route('transactions.index') }}" title="Reset Semua Filter">
                            <i class="fa-regular xx fa-rotate-left text-[#312E81]"></i>
                            <span>Reset</span>
                        </a>
                    @else
                        <a class="btn-secondary min-h-[44px] px-3.5 rounded-xl text-sm font-semibold cursor-pointer touch-press inline-flex items-center justify-center gap-1.5 text-slate-400" href="{{ route('transactions.index') }}" title="Reset Filter">
                            <i class="fa-regular xx fa-rotate-left"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Filter Totals Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-6 text-xs">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex items-center justify-between">
            <span class="text-slate-500 font-medium">Total Masuk (Terfilter)</span>
            <span class="text-sm sm:text-base font-bold font-mono-numbers text-emerald-700">
                + Rp {{ number_format($totalFilteredIn, 0, ',', '.') }}
            </span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex items-center justify-between">
            <span class="text-slate-500 font-medium">Total Keluar (Terfilter)</span>
            <span class="text-sm sm:text-base font-bold font-mono-numbers text-rose-700">
                - Rp {{ number_format($totalFilteredOut, 0, ',', '.') }}
            </span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex items-center justify-between">
            <span class="text-slate-500 font-medium">Selisih Bersih</span>
            <span class="text-sm sm:text-base font-bold font-mono-numbers {{ $totalFilteredIn - $totalFilteredOut >= 0 ? 'text-slate-900' : 'text-rose-600' }}">
                Rp {{ number_format($totalFilteredIn - $totalFilteredOut, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <!-- Transactions Table / Mobile Feed -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <!-- Mobile Stacked Card Feed -->
        <div class="block sm:hidden divide-y divide-slate-100">
            @forelse($transactions as $transaction)
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

                            <!-- Baris 2: Kantong Link & Aksi Hapus -->
                            <div class="flex items-center justify-between gap-2 mt-1.5 pt-0.5">
                                <a href="{{ route('pockets.show', $transaction->pocket) }}"
                                   class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 hover:bg-indigo-50 text-slate-700 hover:text-[#312E81] font-medium text-[10px] truncate max-w-[200px] transition cursor-pointer">
                                    <i class="fa-regular xx {{ $transaction->pocket->icon ?: 'fa-wallet' }} text-[9px] text-slate-400"></i>
                                    <span class="truncate">{{ $transaction->pocket->name }}</span>
                                </a>

                                <form class="inline shrink-0" action="{{ route('transactions.destroy', $transaction) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-1 rounded-md text-slate-300 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer touch-target-sm inline-flex items-center justify-center"
                                            data-confirm="Hapus catatan transaksi ini? Saldo kantong {{ $transaction->pocket->name }} akan disesuaikan otomatis."
                                            data-confirm-title="Hapus Transaksi"
                                            type="submit"
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
                <div class="py-12 text-center text-slate-400">
                    <i class="fa-regular xx fa-receipt text-3xl mb-2 text-slate-300"></i>
                    <p class="text-xs">Tidak ada transaksi yang sesuai dengan filter.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Clean Table View -->
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
                    @forelse($transactions as $transaction)
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
                                <a class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-[#EEF2FF] text-[#312E81] hover:bg-indigo-100 transition cursor-pointer" href="{{ route('pockets.show', $transaction->pocket) }}">
                                    <i class="fa-regular xx fa-wallet text-[9px] opacity-80"></i>
                                    {{ $transaction->pocket->name }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap font-mono-numbers font-bold text-xs {{ $transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $transaction->type === 'in' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <form class="inline" action="{{ route('transactions.destroy', $transaction) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 transition cursor-pointer touch-target-sm" data-confirm="Hapus catatan transaksi ini? Saldo kantong {{ $transaction->pocket->name }} akan disesuaikan otomatis." data-confirm-title="Hapus Transaksi" type="submit" title="Hapus Transaksi">
                                        <i class="fa-regular xx fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-12 text-center text-slate-400" colspan="5">
                                <i class="fa-regular xx fa-receipt text-3xl mb-2 text-slate-300"></i>
                                <p class="text-xs">Tidak ada transaksi yang sesuai dengan filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($transactions->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
