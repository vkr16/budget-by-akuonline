<!-- PWA In-App Install Banner (Hidden until beforeinstallprompt fires) -->
<div id="pwa-install-banner" class="hidden items-center justify-between gap-3 px-4 py-3 bg-[#EEF2FF] border-b border-indigo-100 text-xs text-slate-800 transition-all">
    <div class="flex items-center gap-3 min-w-0">
        <img src="{{ asset('icons/icon-48x48.png') }}" alt="Budget Icon" class="w-8 h-8 rounded-lg shrink-0 shadow-2xs">
        <div class="min-w-0">
            <p class="font-bold text-[#312E81] truncate">Pasang Budget by AkuOnline</p>
            <p class="text-[11px] text-slate-500 truncate">Akses cepat & nyaman langsung dari layar perangkat Anda.</p>
        </div>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <button type="button"
                onclick="window.installPwa()"
                class="btn-primary min-h-[34px] px-3 py-1.5 rounded-lg text-xs font-semibold cursor-pointer touch-press shadow-xs inline-flex items-center gap-1.5">
            <i class="fa-regular xx fa-download text-[11px]"></i>
            <span>Pasang</span>
        </button>
        <button type="button"
                onclick="window.dismissPwaInstallBanner()"
                class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-indigo-100/50 cursor-pointer touch-press"
                title="Tutup banner">
            <i class="fa-regular xx fa-xmark text-xs"></i>
        </button>
    </div>
</div>
