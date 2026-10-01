<x-layouts.app title="Kelola Kantong">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 gap-3">
        <div class="flex items-center gap-3">
            <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] flex items-center justify-center text-[#312E81] text-base shrink-0 shadow-xs">
                <i class="fa-regular xx fa-boxes-stacked"></i>
            </span>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Kantong Anggaran
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Kelompokkan alokasi dana dan sumber transaksi Anda.
                </p>
            </div>
        </div>
        <button type="button"
                onclick="document.getElementById('new-pocket-modal').classList.remove('hidden')"
                class="btn-primary min-h-[44px] rounded-xl px-4 py-2.5 text-sm font-semibold cursor-pointer touch-press shadow-sm inline-flex items-center gap-2 self-start sm:self-auto">
            <i class="fa-regular xx fa-plus text-xs"></i>
            <span>Tambah Kantong Baru</span>
        </button>
    </div>

    <!-- Pockets Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @foreach($pockets as $pocket)
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs hover:border-[#312E81] hover:shadow-md transition p-5 sm:p-6 flex flex-col justify-between group">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-sm font-semibold group-hover:scale-105 transition">
                                <i class="fa-regular xx {{ $pocket->icon ?: 'fa-wallet' }}"></i>
                            </span>
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-[#312E81] transition leading-tight">
                                    {{ $pocket->name }}
                                </h3>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $pocket->transactions_count }} transaksi tercatat
                                </p>
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="flex items-center gap-1">
                            <button type="button"
                                    onclick="openEditModal({{ json_encode($pocket) }})"
                                    title="Edit Kantong"
                                    class="p-2 rounded-xl text-slate-400 hover:text-[#312E81] hover:bg-[#EEF2FF] text-xs transition cursor-pointer touch-target-sm">
                                <i class="fa-regular xx fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('pockets.destroy', $pocket) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        data-confirm="Hapus kantong '{{ $pocket->name }}'? Seluruh catatan transaksi terkait kantong ini juga akan terhapus."
                                        data-confirm-title="Hapus Kantong"
                                        title="Hapus Kantong"
                                        class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 text-xs transition cursor-pointer touch-target-sm">
                                    <i class="fa-regular xx fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($pocket->description)
                        <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                            {{ $pocket->description }}
                        </p>
                    @endif
                </div>

                <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-baseline justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Saldo Saat Ini</span>
                        <div class="text-lg sm:text-xl font-bold font-mono-numbers text-slate-900 group-hover:text-[#312E81] tracking-tight transition">
                            Rp {{ number_format($pocket->current_balance, 0, ',', '.') }}
                        </div>
                    </div>
                    <a href="{{ route('pockets.show', $pocket) }}"
                       class="btn-secondary text-xs px-3.5 py-2 rounded-xl font-semibold cursor-pointer touch-press inline-flex items-center gap-1.5">
                        <span>Detail</span>
                        <i class="fa-regular xx fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Tambah Kantong Baru -->
    <div id="new-pocket-modal" class="fixed inset-0 z-50 hidden overflow-y-auto sm:overflow-hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity cursor-pointer"
             onclick="document.getElementById('new-pocket-modal').classList.add('hidden')"></div>

        <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4 text-center sm:text-left">
            <div class="relative transform overflow-hidden rounded-t-3xl sm:rounded-2xl bg-white text-left shadow-2xl transition-all w-full sm:max-w-md border-t sm:border border-slate-200 animate-sheet-up">
                <!-- Mobile Drag Indicator -->
                <div class="pt-3 pb-1 flex justify-center sm:hidden cursor-pointer"
                     onclick="document.getElementById('new-pocket-modal').classList.add('hidden')">
                    <span class="w-12 h-1.5 bg-slate-300 rounded-full"></span>
                </div>

                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                            <i class="fa-regular xx fa-plus"></i>
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-800">Buat Kantong Anggaran Baru</h3>
                    </div>
                    <button type="button"
                            onclick="document.getElementById('new-pocket-modal').classList.add('hidden')"
                            class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer touch-target-sm">
                        <i class="fa-regular xx fa-xmark text-sm"></i>
                    </button>
                </div>

                <form action="{{ route('pockets.store') }}" method="POST" class="p-5 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Nama Kantong <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               required
                               placeholder="Contoh: Belanja Bulanan, Tabungan Liburan"
                               class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Saldo Awal (Rp)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-mono-numbers text-xs font-bold">
                                Rp
                            </span>
                            <input type="text"
                                   data-currency-input
                                   data-currency-target="new-pocket-amount-raw"
                                   placeholder="0"
                                   autocomplete="off"
                                   class="w-full pl-10 pr-3 py-2.5 min-h-[44px] text-base sm:text-sm font-mono-numbers font-bold bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900">
                            <input type="hidden" name="initial_balance" id="new-pocket-amount-raw" value="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Pilih Ikon
                        </label>
                        <select name="icon" class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 cursor-pointer">
                            <option value="fa-wallet">Dompet / Kas (fa-wallet)</option>
                            <option value="fa-building-columns">Bank / Rekening (fa-building-columns)</option>
                            <option value="fa-piggy-bank">Tabungan (fa-piggy-bank)</option>
                            <option value="fa-credit-card">Kartu / Pembayaran (fa-credit-card)</option>
                            <option value="fa-cart-shopping">Belanja (fa-cart-shopping)</option>
                            <option value="fa-utensils">Makan & Minum (fa-utensils)</option>
                            <option value="fa-gas-pump">Bensin & Kendaraan (fa-gas-pump)</option>
                            <option value="fa-shield-halved">Dana Darurat (fa-shield-halved)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Keterangan <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <input type="text"
                               name="description"
                               placeholder="Catatan tujuan atau batas kantong ini"
                               class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
                    </div>

                    <div class="pt-3 pb-2 sm:pb-0 flex items-center justify-end gap-2.5 border-t border-slate-100">
                        <button type="button"
                                onclick="document.getElementById('new-pocket-modal').classList.add('hidden')"
                                class="btn-secondary cursor-pointer min-h-[44px] rounded-xl px-4 py-2.5 text-sm font-semibold touch-press">
                            Batal
                        </button>
                        <button type="submit"
                                class="btn-primary cursor-pointer min-h-[44px] rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm touch-press">
                            Simpan Kantong
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kantong -->
    <div id="edit-pocket-modal" class="fixed inset-0 z-50 hidden overflow-y-auto sm:overflow-hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity cursor-pointer"
             onclick="document.getElementById('edit-pocket-modal').classList.add('hidden')"></div>

        <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4 text-center sm:text-left">
            <div class="relative transform overflow-hidden rounded-t-3xl sm:rounded-2xl bg-white text-left shadow-2xl transition-all w-full sm:max-w-md border-t sm:border border-slate-200 animate-sheet-up">
                <!-- Mobile Drag Indicator -->
                <div class="pt-3 pb-1 flex justify-center sm:hidden cursor-pointer"
                     onclick="document.getElementById('edit-pocket-modal').classList.add('hidden')">
                    <span class="w-12 h-1.5 bg-slate-300 rounded-full"></span>
                </div>

                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-[#EEF2FF] text-[#312E81] flex items-center justify-center text-xs">
                            <i class="fa-regular xx fa-pen-to-square"></i>
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-800">Edit Kantong Anggaran</h3>
                    </div>
                    <button type="button"
                            onclick="document.getElementById('edit-pocket-modal').classList.add('hidden')"
                            class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer touch-target-sm">
                        <i class="fa-regular xx fa-xmark text-sm"></i>
                    </button>
                </div>

                <form id="edit-pocket-form" method="POST" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Nama Kantong <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="edit-name"
                               name="name"
                               required
                               class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Saldo Awal (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-mono-numbers text-xs font-bold">
                                Rp
                            </span>
                            <input type="text"
                                   id="edit-initial-balance-display"
                                   data-currency-input
                                   data-currency-target="edit-initial-balance-raw"
                                   required
                                   autocomplete="off"
                                   class="w-full pl-10 pr-3 py-2.5 min-h-[44px] text-base sm:text-sm font-mono-numbers font-bold bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900">
                            <input type="hidden" name="initial_balance" id="edit-initial-balance-raw">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Saldo saat ini akan dihitung ulang secara otomatis.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Pilih Ikon
                        </label>
                        <select id="edit-icon" name="icon" class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 cursor-pointer">
                            <option value="fa-wallet">Dompet / Kas (fa-wallet)</option>
                            <option value="fa-building-columns">Bank / Rekening (fa-building-columns)</option>
                            <option value="fa-piggy-bank">Tabungan (fa-piggy-bank)</option>
                            <option value="fa-credit-card">Kartu / Pembayaran (fa-credit-card)</option>
                            <option value="fa-cart-shopping">Belanja (fa-cart-shopping)</option>
                            <option value="fa-utensils">Makan & Minum (fa-utensils)</option>
                            <option value="fa-gas-pump">Bensin & Kendaraan (fa-gas-pump)</option>
                            <option value="fa-shield-halved">Dana Darurat (fa-shield-halved)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">
                            Keterangan <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <input type="text"
                               id="edit-description"
                               name="description"
                               class="w-full px-3 py-2.5 min-h-[44px] text-base sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:ring-2 focus:ring-[#312E81]/20 focus:border-[#312E81] focus:bg-white transition text-slate-900 placeholder-slate-400">
                    </div>

                    <div class="pt-3 pb-2 sm:pb-0 flex items-center justify-end gap-2.5 border-t border-slate-100">
                        <button type="button"
                                onclick="document.getElementById('edit-pocket-modal').classList.add('hidden')"
                                class="btn-secondary cursor-pointer min-h-[44px] rounded-xl px-4 py-2.5 text-sm font-semibold touch-press">
                            Batal
                        </button>
                        <button type="submit"
                                class="btn-primary cursor-pointer min-h-[44px] rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm touch-press">
                            Perbarui Kantong
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function openEditModal(pocket) {
        const form = document.getElementById('edit-pocket-form');
        form.action = `/kantong/${pocket.id}`;

        document.getElementById('edit-name').value = pocket.name;
        document.getElementById('edit-initial-balance-raw').value = parseInt(pocket.initial_balance, 10);
        document.getElementById('edit-initial-balance-display').value = parseInt(pocket.initial_balance, 10).toLocaleString('id-ID');
        document.getElementById('edit-icon').value = pocket.icon || 'fa-wallet';
        document.getElementById('edit-description').value = pocket.description || '';

        document.getElementById('edit-pocket-modal').classList.remove('hidden');
    }
    </script>
    @endpush
</x-layouts.app>
