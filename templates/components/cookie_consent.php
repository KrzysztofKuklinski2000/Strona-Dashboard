<section
    id="cookie-consent"
    class="cookie-consent"
    data-cookie-consent
    aria-labelledby="cookie-consent-title"
    <?= ($params['analytics_consent'] ?? null) !== null ? 'hidden' : '' ?>
>
    <div class="cookie-consent__content">
        <h2 id="cookie-consent-title">Ustawienia cookies</h2>

        <p>
            Niezbędne cookies zapewniają działanie strony.
            Wybierz, czy akceptujesz dodatkowe cookies do statystyk odwiedzin
            i rozpoznawania powracającej przeglądarki.
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
</section>
