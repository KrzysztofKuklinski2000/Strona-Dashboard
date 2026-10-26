(() => {
    'use strict';

    if (!window.fetch || !window.AbortController) {
        return;
    }

    document.querySelectorAll('form[data-csrf-refresh-url]').forEach((form) => {
        const tokenInput = form.querySelector('input[name="csrf_token"]');

        if (!tokenInput) {
            return;
        }

        let pending = false;
        let activeSubmitter = null;
        let activeController = null;

        const reset = () => {
            const controller = activeController;
            activeController = null;
            pending = false;

            if (controller) {
                controller.abort();
            }

            if (activeSubmitter) {
                activeSubmitter.disabled = false;
                activeSubmitter = null;
            }
        };

        window.addEventListener('pagehide', reset);
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                reset();
            }
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (pending) {
                return;
            }

            pending = true;
            const controller = new AbortController();
            activeController = controller;
            activeSubmitter = event.submitter;
            const timeout = window.setTimeout(() => controller.abort(), 15000);

            if (activeSubmitter) {
                activeSubmitter.disabled = true;
            }

            try {
                const response = await fetch(form.dataset.csrfRefreshUrl, {
                    method: 'GET',
                    mode: 'same-origin',
                    credentials: 'same-origin',
                    cache: 'no-store',
                    redirect: 'error',
                    headers: { Accept: 'application/json' },
                    signal: controller.signal,
                });

                if (!response.ok) {
                    throw new Error('Unable to refresh the form token');
                }

                const data = await response.json();

                if (activeController !== controller) {
                    return;
                }

                if (typeof data.token !== 'string' || data.token === '') {
                    throw new Error('Invalid form token response');
                }

                tokenInput.value = data.token;
                HTMLFormElement.prototype.submit.call(form);
            } catch {
                if (activeController !== controller) {
                    return;
                }

                reset();
                window.alert('Nie udało się przygotować formularza do wysłania. Dane nie zostały wysłane. Sprawdź połączenie i spróbuj ponownie.');
            } finally {
                window.clearTimeout(timeout);
            }
        });
    });
})();
