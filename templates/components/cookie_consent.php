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
            Używamy niezbędnych cookies do działania strony.
            Za Twoją zgodą dodatkowe cookie pozwoli nam rozpoznawać
            powracającą przeglądarkę i mierzyć statystyki odwiedzin.
            Ustawienia możesz zmienić w każdej chwili w stopce.
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
            <button type="submit" name="analytics_consent" value="rejected">
                Tylko niezbędne
            </button>

            <button type="submit" name="analytics_consent" value="accepted">
                Zezwól na statystyki
            </button>
        </div>

        <p data-cookie-consent-error role="alert" hidden></p>
    </form>
</section>