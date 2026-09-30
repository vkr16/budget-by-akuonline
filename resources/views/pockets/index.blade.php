<x-layouts.app title="Kelola Kantong">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900">
                Kantong Anggaran
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">
                Kelompokkan alokasi dana dan sumber transaksi Anda.
            </p>
        </div>
        <button type="button" 
                onclick="document.getElementById('new-pocket-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-zinc-900 text-white text-xs font-medium hover:bg-zinc-800 transition shadow-xs">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Kantong Baru
        </button>
    </div>

    <!-- Pockets Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @foreach($pockets as $pocket)
            <div class="bg-white rounded-lg border border-zinc-200/90 shadow-xs p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-9 h-9 rounded-md bg-zinc-100 flex items-center justify-center text-zinc-700 text-sm">
                                <i class="fa-solid {{ $pocket->icon ?: 'fa-wallet' }}"></i>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-zinc-900 leading-tight">
                                    {{ $pocket->name }}
                                </h3>
                                <p class="text-[11px] text-zinc-400">
                                    {{ $pocket->transactions_count }} transaksi tercatat
                                </p>
                            </div>
                        </div>

                        <!-- Action dropdown / buttons -->
                        <div class="flex items-center gap-1">
                            <button type="button" 
                                    onclick="openEditModal({{ json_encode($pocket) }})" 
                                    title="Edit Kantong"
                                    class="p-1.5 rounded text-zinc-400 hover:text-zinc-700 hover:bg-zinc-50 text-xs transition">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('pockets.destroy', $pocket) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        data-confirm="Hapus kantong '{{ $pocket->name }}'? Seluruh catatan transaksi terkait kantong ini juga akan terhapus." 
                                        data-confirm-title="Hapus Kantong"
                                        title="Hapus Kantong"
                                        class="p-1.5 rounded text-zinc-400 hover:text-rose-600 hover:bg-zinc-50 text-xs transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($pocket->description)
                        <p class="mt-3 text-xs text-zinc-500 leading-relaxed">
                            {{ $pocket->description }}
                        </p>
                    @endif
                </div>

                <div class="mt-5 pt-3 border-t border-zinc-100 flex items-baseline justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-semibold text-zinc-400 tracking-wider">Saldo Saat Ini</span>
                        <div class="text-lg font-bold font-mono text-zinc-900 tracking-tight">
                            Rp {{ number_format($pocket->current_balance, 0, ',', '.') }}
                        </div>
                    </div>
                    <a href="{{ route('pockets.show', $pocket) }}" 
                       class="inline-flex items-center gap-1 text-xs font-medium text-zinc-600 hover:text-zinc-900 transition">
                        <span>Detail</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Tambah Kantong Baru -->
    <div id="new-pocket-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-zinc-900/50 backdrop-blur-xs transition-opacity" 
             onclick="document.getElementById('new-pocket-modal').classList.add('hidden')"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-zinc-200">
                <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100">
                    <h3 class="text-sm font-semibold text-zinc-900">Buat Kantong Anggaran Baru</h3>
                    <button type="button" 
                            onclick="document.getElementById('new-pocket-modal').classList.add('hidden')"
                            class="text-zinc-400 hover:text-zinc-600 transition p-1 text-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('pockets.store') }}" method="POST" class="p-5 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Nama Kantong <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               required 
                               placeholder="Contoh: Belanja Bulanan, Tabungan Liburan, Dana Darurat"
                               class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Saldo Awal (Rp)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 font-mono text-xs font-semibold">
                                Rp
                            </span>
                            <input type="text" 
                                   data-currency-input 
                                   data-currency-target="new-pocket-amount-raw" 
                                   placeholder="0"
                                   class="w-full pl-10 pr-3 py-2 text-sm font-mono bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                            <input type="hidden" name="initial_balance" id="new-pocket-amount-raw" value="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Pilih Ikon
                        </label>
                        <select name="icon" class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
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
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Keterangan <span class="text-zinc-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <input type="text" 
                               name="description" 
                               placeholder="Catatan tujuan atau batas kantong ini"
                               class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900 placeholder-zinc-400">
                    </div>

                    <div class="pt-2 flex items-center justify-end gap-2 border-t border-zinc-100">
                        <button type="button" 
                                onclick="document.getElementById('new-pocket-modal').classList.add('hidden')"
                                class="px-4 py-2 rounded-md border border-zinc-200 text-xs font-medium text-zinc-600 hover:bg-zinc-50 transition">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-md bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-medium transition shadow-xs">
                            Simpan Kantong
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kantong -->
    <div id="edit-pocket-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-zinc-900/50 backdrop-blur-xs transition-opacity" 
             onclick="document.getElementById('edit-pocket-modal').classList.add('hidden')"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-zinc-200">
                <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100">
                    <h3 class="text-sm font-semibold text-zinc-900">Edit Kantong Anggaran</h3>
                    <button type="button" 
                            onclick="document.getElementById('edit-pocket-modal').classList.add('hidden')"
                            class="text-zinc-400 hover:text-zinc-600 transition p-1 text-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form id="edit-pocket-form" method="POST" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Nama Kantong <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               id="edit-name" 
                               name="name" 
                               required 
                               class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Saldo Awal (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 font-mono text-xs font-semibold">
                                Rp
                            </span>
                            <input type="text" 
                                   id="edit-initial-balance-display"
                                   data-currency-input 
                                   data-currency-target="edit-initial-balance-raw" 
                                   required
                                   class="w-full pl-10 pr-3 py-2 text-sm font-mono bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                            <input type="hidden" name="initial_balance" id="edit-initial-balance-raw">
                        </div>
                        <p class="text-[11px] text-zinc-400 mt-1">Saldo saat ini akan dihitung ulang secara otomatis.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Pilih Ikon
                        </label>
                        <select id="edit-icon" name="icon" class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
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
                        <label class="block text-xs font-semibold text-zinc-700 uppercase tracking-wider mb-1">
                            Keterangan <span class="text-zinc-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <input type="text" 
                               id="edit-description" 
                               name="description" 
                               class="w-full px-3 py-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md focus:outline-hidden focus:ring-2 focus:ring-zinc-900 focus:bg-white transition text-zinc-900">
                    </div>

                    <div class="pt-2 flex items-center justify-end gap-2 border-t border-zinc-100">
                        <button type="button" 
                                onclick="document.getElementById('edit-pocket-modal').classList.add('hidden')"
                                class="px-4 py-2 rounded-md border border-zinc-200 text-xs font-medium text-zinc-600 hover:bg-zinc-50 transition">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-md bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-medium transition shadow-xs">
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
