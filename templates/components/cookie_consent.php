<dialog
    id="cookie-consent"
    class="cookie-consent"
    data-cookie-consent
    aria-labelledby="cookie-consent-title"
    aria-describedby="cookie-consent-description"
    <?php if (($params['analytics_consent'] ?? null) === null && ($params['page'] ?? '') !== 'subscription-privacy'): ?>
        data-cookie-consent-auto-open
    <?php endif; ?>
>
    <div class="cookie-consent__header">
        <h2 id="cookie-consent-title">Ustawienia cookies</h2>
        <button class="cookie-consent__close" type="button" data-cookie-consent-close aria-label="Zamknij bez zmiany ustawień" autofocus>
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <div class="cookie-consent__content">
        <p id="cookie-consent-description">
            Niezbędne cookies zapewniają działanie strony.
            Za Twoją zgodą używamy dodatkowych cookies, żeby liczyć odwiedziny.
            Możesz odmówić i nadal korzystać ze strony.
            Decyzję możesz zmienić w każdej chwili w ustawieniach w stopce.
            <a href="<?= e(\App\Privacy\SubscriptionPrivacy::PATH . '#privacy-cookies') ?>">Więcej o cookies i prywatności</a>.
        </p>
    </div>

    <form
        action="/cookies/consent"
        method="POST"
        class="cookie-consent__form"
        data-cookie-consent-form
    >
        <input
            type="hidden"
            name="csrf_token"
            value="<?= e($params['csrf_token'] ?? '') ?>"
        >

        <div class="cookie-consent__actions">
            <button type="submit" name="analytics_consent" value="accepted">
                Akceptuję
            </button>

            <button type="submit" name="analytics_consent" value="rejected">
                Odrzucam
            </button>
        </div>

        <p data-cookie-consent-error role="alert" hidden></p>
    </form>
</dialog>
