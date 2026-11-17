(() => {
    'use strict';

    const panel = document.querySelector('[data-cookie-consent]');
    const form = panel?.querySelector('[data-cookie-consent-form]');
    const error = panel?.querySelector('[data-cookie-consent-error]');

    if (!panel || !form || !error) {
        return;
    }

    const buttons = form.querySelectorAll('button[type="submit"]');
    const settings = document.querySelectorAll('[data-cookie-settings]');
    let pending = false;
    let returnFocus = null;

    const setExpanded = () => {
        settings.forEach((button) => {
            button.setAttribute('aria-expanded', String(!panel.hidden));
        });
    };

    const hidePanel = () => {
        panel.hidden = true;
        setExpanded();
        returnFocus?.focus({ preventScroll: true });
        returnFocus = null;
    };

    settings.forEach((button) => {
        button.addEventListener('click', () => {
            if (pending) {
                return;
            }

            returnFocus = button;
            panel.hidden = false;
            error.hidden = true;
            setExpanded();
            buttons[0]?.focus({ preventScroll: true });
        });
    });

    panel.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && returnFocus && !pending) {
            hidePanel();
        }
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

            hidePanel();
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

    setExpanded();
})();
