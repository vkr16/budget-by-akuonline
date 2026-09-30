<x-layouts.app title="Riwayat Transaksi">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900">
                Riwayat Transaksi
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">
                Daftar semua arus transaksi masuk dan keluar dari kantong Anda.
            </p>
        </div>
        <button type="button" 
                onclick="document.getElementById('quick-transaction-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-zinc-900 text-white text-xs font-medium hover:bg-zinc-800 transition shadow-xs">
            <i class="fa-solid fa-plus text-xs"></i> Catat Transaksi Baru
        </button>
    </div>

    <!-- Filter Bar Card -->
    <div class="bg-white p-4 rounded-lg border border-zinc-200/90 shadow-xs mb-6">
        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
            <!-- Filter Tipe -->
            <div>
                <label class="block font-semibold text-zinc-600 mb-1">Tipe Transaksi</label>
                <select name="type" class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded-md focus:ring-1 focus:ring-zinc-900 focus:bg-white text-zinc-800">
                    <option value="">Semua Tipe</option>
                    <option value="in" {{ ($filters['type'] ?? '') === 'in' ? 'selected' : '' }}>Pemasukan (In)</option>
                    <option value="out" {{ ($filters['type'] ?? '') === 'out' ? 'selected' : '' }}>Pengeluaran (Out)</option>
                </select>
            </div>

            <!-- Filter Kantong -->
            <div>
                <label class="block font-semibold text-zinc-600 mb-1">Kantong</label>
                <select name="pocket_id" class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded-md focus:ring-1 focus:ring-zinc-900 focus:bg-white text-zinc-800">
                    <option value="">Semua Kantong</option>
                    @foreach($pockets as $pkt)
                        <option value="{{ $pkt->id }}" {{ ($filters['pocket_id'] ?? '') == $pkt->id ? 'selected' : '' }}>
                            {{ $pkt->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tanggal Dari -->
            <div>
                <label class="block font-semibold text-zinc-600 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded-md focus:ring-1 focus:ring-zinc-900 focus:bg-white text-zinc-800">
            </div>

            <!-- Filter Tanggal Sampai -->
            <div>
                <label class="block font-semibold text-zinc-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded-md focus:ring-1 focus:ring-zinc-900 focus:bg-white text-zinc-800">
            </div>

            <!-- Search & Submit -->
            <div class="flex items-end gap-1.5">
                <div class="flex-1">
                    <label class="block font-semibold text-zinc-600 mb-1">Cari Keterangan</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Ketik kata kunci..." class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded-md focus:ring-1 focus:ring-zinc-900 focus:bg-white text-zinc-800">
                </div>
                <button type="submit" class="px-3 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white rounded-md font-medium transition shadow-xs" title="Terapkan Filter">
                    <i class="fa-solid fa-filter"></i>
                </button>
                <a href="{{ route('transactions.index') }}" class="px-2.5 py-1.5 border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-600 rounded-md font-medium transition" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Filter Totals Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6 text-xs">
        <div class="bg-white p-3.5 rounded-lg border border-zinc-200/90 shadow-xs flex items-center justify-between">
            <span class="text-zinc-500 font-medium">Total Masuk (Terfilter)</span>
            <span class="text-sm font-bold font-mono text-emerald-700">
                + Rp {{ number_format($totalFilteredIn, 0, ',', '.') }}
            </span>
        </div>
        <div class="bg-white p-3.5 rounded-lg border border-zinc-200/90 shadow-xs flex items-center justify-between">
            <span class="text-zinc-500 font-medium">Total Keluar (Terfilter)</span>
            <span class="text-sm font-bold font-mono text-rose-700">
                - Rp {{ number_format($totalFilteredOut, 0, ',', '.') }}
            </span>
        </div>
        <div class="bg-white p-3.5 rounded-lg border border-zinc-200/90 shadow-xs flex items-center justify-between">
            <span class="text-zinc-500 font-medium">Selisih Bersih</span>
            <span class="text-sm font-bold font-mono {{ ($totalFilteredIn - $totalFilteredOut) >= 0 ? 'text-zinc-900' : 'text-rose-600' }}">
                Rp {{ number_format($totalFilteredIn - $totalFilteredOut, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg border border-zinc-200/90 shadow-xs overflow-hidden">
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
                    @forelse($transactions as $transaction)
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
                                <a href="{{ route('pockets.show', $transaction->pocket) }}" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-zinc-100 text-zinc-700 hover:bg-zinc-200 transition">
                                    <i class="fa-solid fa-wallet text-[9px] opacity-70"></i>
                                    {{ $transaction->pocket->name }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap font-mono font-semibold {{ $transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $transaction->type === 'in' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            data-confirm="Hapus catatan transaksi ini? Saldo kantong {{ $transaction->pocket->name }} akan disesuaikan otomatis." 
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
                            <td colspan="5" class="py-12 text-center text-zinc-400">
                                <i class="fa-solid fa-receipt text-3xl mb-2 text-zinc-300"></i>
                                <p>Tidak ada transaksi yang sesuai dengan filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 border-t border-zinc-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
