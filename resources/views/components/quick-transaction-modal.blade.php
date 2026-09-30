<!-- Quick Transaction Modal -->
<div id="quick-transaction-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-zinc-900/50 backdrop-blur-xs transition-opacity" 
         onclick="document.getElementById('quick-transaction-modal').classList.add('hidden')"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-zinc-200">
            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-md bg-zinc-100 flex items-center justify-center text-zinc-700 text-xs">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>
                    <h3 class="text-sm font-semibold text-zinc-900" id="modal-title">Catat Transaksi Cepat</h3>
                </div>
                <button type="button" 
                        onclick="document.getElementById('quick-transaction-modal').classList.add('hidden')"
                        class="text-zinc-400 hover:text-zinc-600 transition p-1 text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('transactions.store') }}" method="POST" class="p-5 space-y-4">
                @csrf

                <!-- Type Selector (In or Out) -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 uppercase tracking-wider mb-1.5">
                        Tipe Transaksi
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="out" class="peer sr-only" checked onchange="updateModalFormMode('out')">
                            <div class="py-2.5 px-3 rounded-md border border-zinc-200 text-center text-xs font-medium text-zinc-600 peer-checked:bg-rose-50 peer-checked:text-rose-700 peer-checked:border-rose-300 peer-checked:ring-1 peer-checked:ring-rose-300 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-arrow-up-right text-xs"></i>
                                <span>Pengeluaran (Out)</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="in" class="peer sr-only" onchange="updateModalFormMode('in')">
                            <div class="py-2.5 px-3 rounded-md border border-zinc-200 text-center text-xs font-medium text-zinc-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 peer-checked:border-emerald-300 peer-checked:ring-1 peer-checked:ring-emerald-300 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-arrow-down-left text-xs"></i>
                                <span>Pemasukan (In)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Nominal Amount -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 uppercase tracking-wider mb-1">
                        Nominal (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400 font-mono text-sm font-semibold">
                            Rp
                        </span>
                        <input type="text" 
                               data-currency-input 
                               data-currency-target="modal-amount-raw"
                               placeholder="0" 
                               required
                               class="w-full pl-11 pr-3 py-2.5 text-base font-semibold font-mono bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                        <input type="hidden" name="amount" id="modal-amount-raw">
                    </div>

                    <!-- Quick amount increments -->
                    <div class="flex items-center gap-1.5 mt-2 flex-wrap text-xs">
                        <button type="button" data-preset-amount="10000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 transition font-mono">+10rb</button>
                        <button type="button" data-preset-amount="20000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 transition font-mono">+20rb</button>
                        <button type="button" data-preset-amount="50000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 transition font-mono">+50rb</button>
                        <button type="button" data-preset-amount="100000" class="px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-700 transition font-mono">+100rb</button>
                    </div>
                </div>

                <!-- Kantong Target / Source -->
                <div>
                    <label id="modal-pocket-label" class="block text-xs font-semibold text-zinc-600 uppercase tracking-wider mb-1">
                        Dari Kantong Mana? <span class="text-rose-500">*</span>
                    </label>
                    <select name="pocket_id" required class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                        @if(Auth::check() && Auth::user()->pockets)
                            @foreach(Auth::user()->pockets()->where('is_active', true)->orderBy('name')->get() as $pkt)
                                <option value="{{ $pkt->id }}">
                                    {{ $pkt->name }} (Sisa: Rp {{ number_format($pkt->current_balance, 0, ',', '.') }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Tanggal Transaksi (Autofilled to Current Time) -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 uppercase tracking-wider mb-1">
                        Tanggal & Waktu
                    </label>
                    <div class="relative">
                        <input type="datetime-local" 
                               name="date" 
                               data-autofill-now 
                               required
                               class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                    </div>
                </div>

                <!-- Keterangan (Opsional) -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 uppercase tracking-wider mb-1">
                        Keterangan <span class="text-zinc-400 font-normal lowercase">(opsional)</span>
                    </label>
                    <input type="text" 
                           name="description" 
                           placeholder="Contoh: Beli kopi siang, bayar wifi, dll." 
                           class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900 placeholder-zinc-400">
                </div>

                <div class="pt-2 flex items-center justify-end gap-2 border-t border-zinc-100">
                    <button type="button" 
                            onclick="document.getElementById('quick-transaction-modal').classList.add('hidden')"
                            class="px-4 py-2 rounded-md border border-zinc-200 text-xs font-medium text-zinc-600 hover:bg-zinc-50 transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 rounded-md bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-medium transition shadow-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Transaksi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateModalFormMode(type) {
    const label = document.getElementById('modal-pocket-label');
    if (!label) return;
    if (type === 'in') {
        label.innerHTML = 'Tujuan ke Kantong Mana? <span class="text-rose-500">*</span>';
    } else {
        label.innerHTML = 'Dari Kantong Mana? <span class="text-rose-500">*</span>';
    }
}
</script>
