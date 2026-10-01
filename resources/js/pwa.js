/**
 * Progressive Web App (PWA) Client Controller
 * Mengelola pendaftaran Service Worker, instalasi banner, dan lifecycle PWA.
 */

let deferredPrompt = null;

// 1. Registrasi Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then((registration) => {
                // Deteksi update service worker
                registration.onupdatefound = () => {
                    const installingWorker = registration.installing;
                    if (installingWorker) {
                        installingWorker.onstatechange = () => {
                            if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                if (window.Notiflix && window.Notiflix.Notify) {
                                    window.Notiflix.Notify.info('Versi terbaru Budget by AkuOnline tersedia. Muat ulang untuk memperbarui.');
                                }
                            }
                        };
                    }
                };
            })
            .catch((err) => {
                console.warn('[PWA] Gagal meregistrasi Service Worker:', err);
            });
    });
}

// 2. Tangani Prompt Instalasi Aplikasi (beforeinstallprompt)
window.addEventListener('beforeinstallprompt', (e) => {
    // Cegah banner mini bawaan browser
    e.preventDefault();
    deferredPrompt = e;

    // Tampilkan tombol / banner instal jika belum di-dismiss di session ini
    const isDismissed = sessionStorage.getItem('pwa_install_dismissed');
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

    if (!isDismissed && !isStandalone) {
        showPwaInstallPrompt();
    }
});

// 3. Tampilkan Banner Instalasi
function showPwaInstallPrompt() {
    const banner = document.getElementById('pwa-install-banner');
    if (banner) {
        banner.classList.remove('hidden');
        banner.classList.add('flex');
    }

    const installButtons = document.querySelectorAll('.pwa-install-btn');
    installButtons.forEach((btn) => {
        btn.classList.remove('hidden');
    });
}

// 4. Eksekusi Instalasi saat Tombol Diklik
window.installPwa = function() {
    if (!deferredPrompt) {
        if (window.Notiflix && window.Notiflix.Notify) {
            window.Notiflix.Notify.info('Untuk menginstal di browser ini, gunakan menu "Add to Home screen" atau tombol instal di address bar.');
        }
        return;
    }

    deferredPrompt.prompt();

    deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
            console.log('[PWA] Pengguna menyetujui instalasi aplikasi');
        } else {
            console.log('[PWA] Pengguna menolak instalasi aplikasi');
        }
        deferredPrompt = null;
        dismissPwaInstallBanner();
    });
};

// 5. Tutup Banner Instalasi
window.dismissPwaInstallBanner = function() {
    const banner = document.getElementById('pwa-install-banner');
    if (banner) {
        banner.classList.add('hidden');
        banner.classList.remove('flex');
    }
    sessionStorage.setItem('pwa_install_dismissed', 'true');
};

// 6. Tangani Event Setelah Aplikasi Terpasang
window.addEventListener('appinstalled', () => {
    deferredPrompt = null;
    dismissPwaInstallBanner();

    if (window.Notiflix && window.Notiflix.Notify) {
        window.Notiflix.Notify.success('Budget by AkuOnline berhasil dipasang di perangkat Anda!');
    }
});
