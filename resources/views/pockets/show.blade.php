<x-layouts.app :title="'Kantong ' . $pocket->name">
    <!-- Breadcrumb & Back -->
    <div class="mb-4">
        <a href="{{ route('pockets.index') }}" class="btn-secondary inline-flex items-center gap-2 text-xs font-semibold px-3.5 py-2 min-h-[40px] rounded-xl cursor-pointer touch-press">
            <i class="fa-regular xx fa-arrow-left text-[11px] text-[#312E81]"></i>
            <span>Kembali ke Semua Kantong</span>
        </a>
    </div>

    <!-- Pocket Header Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-xs mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <span class="w-12 h-12 rounded-2xl bg-[#EEF2FF] flex items-center justify-center text-[#312E81] text-xl shrink-0 shadow-xs">
                    <i class="fa-regular xx {{ $pocket->icon ?: 'fa-wallet' }}"></i>
                </span>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">{{ $pocket->name }}</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        {{ $pocket->description ?: 'Kantong anggaran aktif' }}
                    </p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Saldo Saat Ini</span>
                <div class="text-2xl sm:text-3xl font-extrabold font-mono-numbers text-slate-900 tracking-tight">
                    Rp {{ number_format($pocket->current_balance, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mt-6 pt-6 border-t border-slate-100 text-xs">
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                <span class="text-slate-400 font-semibold block text-[11px]">Saldo Awal</span>
                <p class="text-sm font-bold font-mono-numbers text-slate-800 mt-1">
                    Rp {{ number_format($pocket->initial_balance, 0, ',', '.') }}
                </p>
            </div>
            <div class="p-3.5 bg-emerald-50/50 rounded-xl border border-emerald-100/80">
                <span class="text-emerald-700 font-semibold block text-[11px]">Total Masuk (In)</span>
                <p class="text-sm font-bold font-mono-numbers text-emerald-800 mt-1">
                    + Rp {{ number_format($totalIn, 0, ',', '.') }}
                </p>
            </div>
            <div class="p-3.5 bg-rose-50/50 rounded-xl border border-rose-100/80">
                <span class="text-rose-700 font-semibold block text-[11px]">Total Keluar (Out)</span>
                <p class="text-sm font-bold font-mono-numbers text-rose-800 mt-1">
                    - Rp {{ number_format($totalOut, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Transactions List for this Pocket -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-xl bg-[#EEF2FF] flex items-center justify-center text-[#312E81] text-xs">
                    <i class="fa-regular xx fa-list"></i>
                </span>
                <h2 class="text-sm font-bold text-slate-800">Riwayat Transaksi Kantong Ini</h2>
            </div>
            <span class="text-xs text-slate-400 font-mono-numbers font-medium">{{ $transactions->total() }} catatan</span>
        </div>

        <!-- Mobile Stacked Card View -->
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

                            <!-- Baris 2: Tanggal & Aksi Hapus -->
                            <div class="flex items-center justify-between gap-2 mt-1.5 pt-0.5">
                                <span class="font-mono-numbers text-slate-400 text-[10px] whitespace-nowrap">
                                    <i class="fa-regular xx fa-calendar-day text-[9px] text-slate-400 mr-1"></i>
                                    {{ $transaction->date->format('d M Y, H:i') }}
                                </span>

                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            data-confirm="Hapus transaksi ini? Saldo kantong akan disesuaikan otomatis."
                                            data-confirm-title="Hapus Transaksi"
                                            class="p-1 rounded-md text-slate-300 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer touch-target-sm inline-flex items-center justify-center"
                                            title="Hapus Transaksi">
                                        <i class="fa-regular xx fa-trash-can text-[11px]"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 text-xs">
                    <p>Belum ada catatan transaksi di kantong ini.</p>
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
                            <td class="py-3 px-4 text-right whitespace-nowrap font-mono-numbers font-bold text-xs {{ $transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $transaction->type === 'in' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            data-confirm="Hapus transaksi ini? Saldo kantong akan disesuaikan otomatis."
                                            data-confirm-title="Hapus Transaksi"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 transition cursor-pointer touch-target-sm"
                                            title="Hapus">
                                        <i class="fa-regular xx fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">
                                <p>Belum ada catatan transaksi di kantong ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>

