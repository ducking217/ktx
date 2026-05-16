import './bootstrap';

import Alpine from 'alpinejs';
import 'flowbite';

window.Alpine = Alpine;

Alpine.start();

const initSubmitLoadingStates = () => {
    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }
        if ((form.method || 'get').toLowerCase() === 'get' || form.dataset.noLoading === 'true') {
            return;
        }

        const submitter = event.submitter || form.querySelector('button[type="submit"], input[type="submit"]');
        if (!submitter || submitter.dataset.noLoading === 'true' || submitter.disabled) {
            return;
        }

        const loadingText = submitter.dataset.loadingText || 'Đang xử lý...';
        const loadingMode = submitter.dataset.loading || 'text';
        submitter.disabled = true;
        submitter.setAttribute('aria-busy', 'true');
        submitter.classList.add('linear-btn-loading');
        if (submitter instanceof HTMLInputElement) {
            if (!submitter.dataset.originalValue) {
                submitter.dataset.originalValue = submitter.value;
            }
            submitter.value = loadingText;
        } else {
            if (!submitter.dataset.originalText) {
                submitter.dataset.originalText = submitter.innerHTML;
            }
            if (loadingMode === 'spinner') {
                submitter.innerHTML = `<span class="sr-only">${loadingText}</span><svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path></svg>`;
            } else {
                submitter.innerHTML = `<span class="whitespace-nowrap">${loadingText}</span>`;
            }
        }
    });
};

const initModalAnimations = () => {
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-modal-toggle], [data-modal-target]');
        if (!trigger) {
            return;
        }

        const modalId = trigger.getAttribute('data-modal-toggle') || trigger.getAttribute('data-modal-target');
        const modal = modalId ? document.getElementById(modalId) : null;
        if (!modal) {
            return;
        }

        requestAnimationFrame(() => {
            const panel = modal.querySelector('.mx-auto, .relative.max-h-full, .relative.rounded-lg, .linear-modal-card');
            if (!panel) {
                return;
            }
            panel.classList.remove('animate-pop-in');
            void panel.offsetWidth;
            panel.classList.add('animate-pop-in');
        });
    });
};

const initLegacyModalBridge = () => {
    document.addEventListener(
        'click',
        (event) => {
            const hideTrigger = event.target.closest('[data-modal-hide]');
            if (hideTrigger) {
                const modalId = hideTrigger.getAttribute('data-modal-hide');
                const modal = modalId ? document.getElementById(modalId) : null;
                // Only bridge to Alpine for modals that use x-data (Alpine-based <x-modal>).
                if (modal && (modal.hasAttribute('x-data') || modal.querySelector('[x-data]'))) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    window.dispatchEvent(new CustomEvent('close-modal', { detail: modalId }));
                }
                return;
            }

            const openTrigger = event.target.closest('[data-modal-toggle], [data-modal-target]');
            if (!openTrigger) {
                return;
            }

            const modalId = openTrigger.getAttribute('data-modal-toggle') || openTrigger.getAttribute('data-modal-target');
            const modal = modalId ? document.getElementById(modalId) : null;

            // Only bridge to Alpine for modals that use x-data (Alpine-based <x-modal>).
            // Native Flowbite modals should be handled by Flowbite's own listener.
            if (modal && (modal.hasAttribute('x-data') || modal.querySelector('[x-data]'))) {
                event.preventDefault();
                event.stopImmediatePropagation();
                window.dispatchEvent(new CustomEvent('open-modal', { detail: modalId }));
            }
            // Otherwise: let Flowbite handle it natively
        },
        true,
    );
};

initSubmitLoadingStates();
initLegacyModalBridge();
initModalAnimations();
