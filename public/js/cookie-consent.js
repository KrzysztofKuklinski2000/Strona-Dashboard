(() => {
    'use strict';

    const panel = document.querySelector('[data-cookie-consent]');
    const form = panel?.querySelector('[data-cookie-consent-form]');
    const error = panel?.querySelector('[data-cookie-consent-error]');
    const closeButton = panel?.querySelector('[data-cookie-consent-close]');

    if (typeof panel?.showModal !== 'function' || !form || !error || !closeButton) {
        return;
    }

    const buttons = form.querySelectorAll('button[type="submit"]');
    const settings = document.querySelectorAll('[data-cookie-settings]');
    let pending = false;
    let returnFocus = null;

    const setExpanded = () => {
        settings.forEach((button) => {
            button.setAttribute('aria-expanded', String(panel.open));
        });
    };

    const openPanel = () => {
        error.hidden = true;
        panel.showModal();
        setExpanded();
    };

    closeButton.addEventListener('click', () => panel.close());

    panel.addEventListener('close', () => {
        setExpanded();
        returnFocus?.focus({ preventScroll: true });
        returnFocus = null;
    });

    settings.forEach((button) => {
        button.addEventListener('click', () => {
            if (pending || panel.open) {
                return;
            }

            returnFocus = button;
            openPanel();
        });
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (pending) {
            return;
        }

        const decision = event.submitter?.value;

        if (!['accepted', 'rejected'].includes(decision)) {
            error.textContent = 'Wybierz jedną z opcji ustawień cookies.';
            error.hidden = false;
            return;
        }

        const body = new FormData(form);
        body.set('analytics_consent', decision);

        if (decision === 'accepted') {
            body.set('page_path', window.location.pathname);
        }

        const controller = new AbortController();
        const timeout = window.setTimeout(() => controller.abort(), 15000);

        pending = true;
        error.hidden = true;
        form.setAttribute('aria-busy', 'true');
        buttons.forEach((button) => { button.disabled = true; });

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                mode: 'same-origin',
                credentials: 'same-origin',
                cache: 'no-store',
                redirect: 'error',
                headers: { Accept: 'application/json' },
                body,
                signal: controller.signal,
            });

            const data = await response.json();

            if (!response.ok || data.success !== true || data.decision !== decision) {
                error.textContent = typeof data.message === 'string'
                    ? data.message
                    : 'Nie udało się zapisać ustawień cookies. Spróbuj ponownie.';
                error.hidden = false;
                return;
            }

            panel.close();
        } catch (failure) {
            error.textContent = failure.name === 'AbortError'
                ? 'Zapisywanie trwało zbyt długo. Sprawdź połączenie i spróbuj ponownie.'
                : 'Nie udało się zapisać ustawień cookies. Sprawdź połączenie i spróbuj ponownie.';
            error.hidden = false;
        } finally {
            window.clearTimeout(timeout);
            pending = false;
            form.removeAttribute('aria-busy');
            buttons.forEach((button) => { button.disabled = false; });
        }
    });

    if (panel.hasAttribute('data-cookie-consent-auto-open')) {
        openPanel();
    } else {
        setExpanded();
    }
})();
