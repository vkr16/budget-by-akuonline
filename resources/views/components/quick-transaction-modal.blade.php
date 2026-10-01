<!-- Quick Transaction Modal / Bottom Sheet -->
<div id="quick-transaction-modal" class="fixed inset-0 z-50 hidden overflow-y-auto sm:overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity cursor-pointer"
         onclick="document.getElementById('quick-transaction-modal').classList.add('hidden')"></div>

    <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4 text-center sm:text-left">
        <div class="relative transform overflow-hidden rounded-t-3xl sm:rounded-2xl bg-white text-left shadow-2xl transition-all w-full sm:max-w-lg border-t sm:border border-slate-200 animate-sheet-up max-h-[92vh] flex flex-col">
            <!-- Mobile Drag Indicator Handle -->
            <div class="pt-3 pb-1 flex justify-center sm:hidden cursor-pointer"
                 onclick="document.getElementById('quick-transaction-modal').classList.add('hidden')">
                <span class="w-12 h-1.5 bg-slate-300 rounded-full"></span>
            </div>

            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-3.5 sm:py-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-[#EEF2FF] flex items-center justify-center text-[#312E81] text-xs">
                        <i class="fa-regular xx fa-pen-to-square"></i>
                    </span>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-800" id="modal-title">Catat Transaksi Cepat</h3>
                        <p class="text-[11px] text-slate-400 hidden sm:block">Simpan pengeluaran atau pemasukan langsung ke kantong</p>
                    </div>
                </div>
                <button type="button"
                        onclick="document.getElementById('quick-transaction-modal').classList.add('hidden')"
                        class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer touch-target-sm">
                    <i class="fa-regular xx fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Form Body with Scroll -->
            <form action="{{ route('transactions.store') }}" method="POST" class="p-5 space-y-4 overflow-y-auto">
                @csrf

                <!-- Type Selector (In or Out) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Tipe Transaksi
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="out" class="peer sr-only" checked onchange="updateModalFormMode('out')">
                            <div class="py-2.5 px-3 min-h-[44px] rounded-xl border border-slate-200 text-center text-xs font-semibold text-slate-600 peer-checked:bg-rose-50 peer-checked:text-rose-700 peer-checked:border-rose-300 peer-checked:ring-1 peer-checked:ring-rose-300 transition flex items-center justify-center gap-2 cursor-pointer touch-press">
                                <i class="fa-regular xx fa-arrow-up-right text-xs"></i>
                                <span>Pengeluaran (Out)</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="in" class="peer sr-only" onchange="updateModalFormMode('in')">
                            <div class="py-2.5 px-3 min-h-[44px] rounded-xl border border-slate-200 text-center text-xs font-semibold text-slate-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 peer-checked:border-emerald-300 peer-checked:ring-1 peer-checked:ring-emerald-300 transition flex items-center justify-center gap-2 cursor-pointer touch-press">
                                <i class="fa-regular xx fa-arrow-down-left text-xs"></i>
                                <span>Pemasukan (In)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Nominal Amount -->
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
                               data-currency-target="modal-amount-raw"
                               placeholder="0"
                               required
                               autocomplete="off"
                               class="w-full pl-11 pr-3 py-2.5 sm:py-3 min-h-[46px] text-lg font-bold font-mono-numbers bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900">
                        <input type="hidden" name="amount" id="modal-amount-raw">
                    </div>

                    <!-- Quick amount presets -->
                    <div class="flex items-center gap-1.5 mt-2 flex-wrap text-xs">
                        <button type="button" data-preset-amount="10000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+10k</button>
                        <button type="button" data-preset-amount="20000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+20k</button>
                        <button type="button" data-preset-amount="50000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+50k</button>
                        <button type="button" data-preset-amount="100000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+100k</button>
                        <button type="button" data-preset-amount="500000" class="preset-chip cursor-pointer touch-press px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#EEF2FF] hover:text-[#312E81] text-slate-700 transition font-mono-numbers text-xs font-semibold border border-slate-200/60 touch-target-sm">+500k</button>
                    </div>
                </div>

                <!-- Kantong Target / Source -->
                <div>
                    <label id="modal-pocket-label" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                        Dari Kantong Mana? <span class="text-rose-500">*</span>
                    </label>
                    <select name="pocket_id" required class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 cursor-pointer">
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
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                        Tanggal & Waktu
                    </label>
                    <input type="datetime-local"
                           name="date"
                           data-autofill-now
                           required
                           class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 cursor-pointer">
                </div>

                <!-- Keterangan (Opsional) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                        Keterangan <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                    </label>
                    <input type="text"
                           name="description"
                           placeholder="Contoh: Beli kopi siang, bayar wifi, dll."
                           class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
                </div>

                <!-- Action Buttons -->
                <div class="pt-3 pb-2 sm:pb-0 flex items-center justify-end gap-2.5 border-t border-slate-100">
                    <button type="button"
                            onclick="document.getElementById('quick-transaction-modal').classList.add('hidden')"
                            class="btn-secondary cursor-pointer min-h-[44px] rounded-xl px-4 py-2.5 text-sm font-semibold touch-press">
                        Batal
                    </button>
                    <button type="submit"
                            class="btn-primary cursor-pointer min-h-[44px] rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm flex items-center justify-center gap-1.5 touch-press">
                        <i class="fa-regular xx fa-check text-xs"></i>
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

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('quick-transaction-modal');
        if (modal && !modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
        }
    }
});
</script>
