<x-layouts.app :title="'Kantong ' . $pocket->name">
    <!-- Breadcrumb & Back -->
    <div class="mb-4">
        <a href="{{ route('pockets.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-zinc-500 hover:text-zinc-900 transition">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Kembali ke Semua Kantong</span>
        </a>
    </div>

    <!-- Pocket Header Card -->
    <div class="bg-white p-6 rounded-lg border border-zinc-200/90 shadow-xs mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="w-12 h-12 rounded-lg bg-zinc-100 flex items-center justify-center text-zinc-800 text-lg">
                    <i class="fa-solid {{ $pocket->icon ?: 'fa-wallet' }}"></i>
                </span>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-zinc-900">{{ $pocket->name }}</h1>
                    <p class="text-xs text-zinc-500 mt-0.5">
                        {{ $pocket->description ?: 'Kantong anggaran aktif' }}
                    </p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-xs uppercase font-semibold text-zinc-400 tracking-wider">Saldo Saat Ini</span>
                <div class="text-2xl font-bold font-mono text-zinc-900 tracking-tight">
                    Rp {{ number_format($pocket->current_balance, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-zinc-100 text-xs">
            <div class="p-3 bg-zinc-50 rounded-md border border-zinc-100">
                <span class="text-zinc-400 font-medium">Saldo Awal</span>
                <p class="text-sm font-semibold font-mono text-zinc-800 mt-1">
                    Rp {{ number_format($pocket->initial_balance, 0, ',', '.') }}
                </p>
            </div>
            <div class="p-3 bg-emerald-50/50 rounded-md border border-emerald-100">
                <span class="text-emerald-700 font-medium">Total Masuk (In)</span>
                <p class="text-sm font-semibold font-mono text-emerald-800 mt-1">
                    + Rp {{ number_format($totalIn, 0, ',', '.') }}
                </p>
            </div>
            <div class="p-3 bg-rose-50/50 rounded-md border border-rose-100">
                <span class="text-rose-700 font-medium">Total Keluar (Out)</span>
                <p class="text-sm font-semibold font-mono text-rose-800 mt-1">
                    - Rp {{ number_format($totalOut, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Transactions List for this Pocket -->
    <div class="bg-white rounded-lg border border-zinc-200/90 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-zinc-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-md bg-zinc-100 flex items-center justify-center text-zinc-700 text-xs">
                    <i class="fa-solid fa-list"></i>
                </span>
                <h2 class="text-sm font-bold text-zinc-900">Riwayat Transaksi Kantong Ini</h2>
            </div>
            <span class="text-xs text-zinc-400 font-mono">{{ $transactions->total() }} total catatan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50/70 border-b border-zinc-100 text-zinc-500 font-medium">
                    <tr>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Tipe & Keterangan</th>
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
                            <td class="py-3 px-4 text-right whitespace-nowrap font-mono font-semibold {{ $transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $transaction->type === 'in' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            data-confirm="Hapus transaksi ini? Saldo kantong akan disesuaikan otomatis." 
                                            data-confirm-title="Hapus Transaksi"
                                            class="p-1 rounded text-zinc-400 hover:text-rose-600 transition" 
                                            title="Hapus">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-zinc-400">
                                <p>Belum ada catatan transaksi di kantong ini.</p>
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
