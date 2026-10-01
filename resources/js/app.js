// Initialize local Notiflix AIO with Tailwind Indigo-900 Theme
function initNotiflixConfig() {
    const Notiflix = window.Notiflix;
    if (!Notiflix) return;

    Notiflix.Notify.init({
        width: '320px',
        position: 'right-top',
        distance: '16px',
        opacity: 1,
        borderRadius: '10px',
        timeout: 3500,
        messageMaxLength: 200,
        backOverlay: false,
        plainText: true,
        showOnlyTheLastOne: false,
        fontFamily: 'Plus Jakarta Sans, Instrument Sans, ui-sans-serif, system-ui, sans-serif',
        fontSize: '13px',
        cssAnimation: true,
        cssAnimationDuration: 250,
        cssAnimationStyle: 'fade',
        success: {
            background: '#312E81',
            textColor: '#ffffff',
            childClassName: 'notiflix-notify-success',
            notiflixIconColor: '#C7D2FE',
        },
        failure: {
            background: '#DC2626',
            textColor: '#ffffff',
            childClassName: 'notiflix-notify-failure',
            notiflixIconColor: '#ffffff',
        },
        warning: {
            background: '#D97706',
            textColor: '#ffffff',
            childClassName: 'notiflix-notify-warning',
            notiflixIconColor: '#ffffff',
        },
        info: {
            background: '#1F2937',
            textColor: '#ffffff',
            childClassName: 'notiflix-notify-info',
            notiflixIconColor: '#ffffff',
        },
    });

    Notiflix.Confirm.init({
        className: 'notiflix-confirm',
        width: '360px',
        zindex: 4003,
        position: 'center',
        distance: '10px',
        backgroundColor: '#ffffff',
        borderRadius: '16px',
        backOverlay: true,
        backOverlayColor: 'rgba(49, 46, 129, 0.35)',
        fontFamily: 'Plus Jakarta Sans, Instrument Sans, ui-sans-serif, system-ui, sans-serif',
        titleColor: '#312E81',
        titleFontSize: '16px',
        messageColor: '#4B5563',
        messageFontSize: '13.5px',
        buttonsFontSize: '13px',
        okButtonColor: '#ffffff',
        okButtonBackground: '#312E81',
        cancelButtonColor: '#1F2937',
        cancelButtonBackground: '#EEF2FF',
    });
}

// Run config on load
initNotiflixConfig();

// Helper: Format Rupiah numbers for display
export function formatRupiah(number) {
    if (isNaN(number) || number === null || number === '') return 'Rp 0';
    return 'Rp ' + Number(number).toLocaleString('id-ID');
}
window.formatRupiah = formatRupiah;

// Format amount inputs with thousands separator
function setupCurrencyInputs() {
    const currencyInputs = document.querySelectorAll('[data-currency-input]');
    currencyInputs.forEach((input) => {
        const targetHiddenId = input.getAttribute('data-currency-target');
        const hiddenInput = targetHiddenId ? document.getElementById(targetHiddenId) : null;

        function updateFormattedValue() {
            // Keep only digits
            let rawValue = input.value.replace(/\D/g, '');
            if (!rawValue) {
                input.value = '';
                if (hiddenInput) hiddenInput.value = '';
                return;
            }

            const numericValue = parseInt(rawValue, 10);
            input.value = numericValue.toLocaleString('id-ID');
            if (hiddenInput) {
                hiddenInput.value = numericValue;
            }
        }

        input.addEventListener('input', updateFormattedValue);

        // Pre-fill initial value if present
        if (input.value) {
            updateFormattedValue();
        }
    });
}

// Autofill datetime-local inputs with current local timestamp if empty
function setupDateTimeDefaults() {
    const dateInputs = document.querySelectorAll('input[type="datetime-local"][data-autofill-now]');
    dateInputs.forEach((input) => {
        if (!input.value) {
            const now = new Date();
            // Format to YYYY-MM-DDTHH:MM local time
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            input.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    });
}

// Global confirm action using Notiflix Confirm
function setupConfirmActions() {
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-confirm]');
        if (!trigger) return;

        event.preventDefault();
        const message = trigger.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
        const title = trigger.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
        const okText = trigger.getAttribute('data-confirm-ok') || 'Ya, Lanjutkan';
        const cancelText = trigger.getAttribute('data-confirm-cancel') || 'Batal';

        if (window.Notiflix?.Confirm) {
            window.Notiflix.Confirm.show(
                title,
                message,
                okText,
                cancelText,
                () => {
                    if (trigger.tagName === 'A') {
                        window.location.href = trigger.href;
                    } else if (trigger.tagName === 'BUTTON' && trigger.type === 'submit') {
                        trigger.closest('form').submit();
                    } else if (trigger.closest('form')) {
                        trigger.closest('form').submit();
                    }
                },
                () => {
                    // Cancelled - do nothing
                }
            );
        } else if (confirm(message)) {
            if (trigger.tagName === 'A') {
                window.location.href = trigger.href;
            } else if (trigger.closest('form')) {
                trigger.closest('form').submit();
            }
        }
    });
}

// Preset Quick Amount Buttons (+10k, +50k, +100k, etc.)
function setupPresetAmountButtons() {
    document.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-preset-amount]');
        if (!btn) return;

        const amountToAdd = parseInt(btn.getAttribute('data-preset-amount'), 10);
        const form = btn.closest('form');
        if (!form) return;

        const displayInput = form.querySelector('[data-currency-input]');
        const hiddenInput = form.querySelector('input[name="amount"]');

        if (displayInput && hiddenInput) {
            let current = parseInt(hiddenInput.value || '0', 10);
            if (isNaN(current)) current = 0;
            const updated = current + amountToAdd;
            hiddenInput.value = updated;
            displayInput.value = updated.toLocaleString('id-ID');
        }
    });
}

// Run initializers on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    initNotiflixConfig();
    setupCurrencyInputs();
    setupDateTimeDefaults();
    setupConfirmActions();
    setupPresetAmountButtons();
});

// Import Progressive Web App (PWA) client handler
import './pwa.js';

