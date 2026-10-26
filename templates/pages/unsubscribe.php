<section class="contact-page">
    <div class="contact-page__inner">
        <section
            class="contact-panel unsubscribe-confirmation"
            aria-labelledby="unsubscribe-confirmation-title"
        >
            <div class="contact-panel__top">
                <h2 id="unsubscribe-confirmation-title">
                    Potwierdź swoją decyzję
                </h2>
            </div>

            <p class="unsubscribe-confirmation__description">
                Po wypisaniu przestaniesz otrzymywać e-maile o zmianach
                grafiku. Samo otwarcie tej strony nie zmienia subskrypcji.
            </p>

            <form action="/unsubscribe" method="POST" class="contact-actions" data-csrf-refresh-url="/subscription/csrf-token">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e($params['csrf_token'] ?? '') ?>"
                >

                <input
                    type="hidden"
                    name="token"
                    value="<?= e($params['unsubscribe_token'] ?? '') ?>"
                >

                <button
                    type="submit"
                    class="contact-action contact-action--primary"
                >
                    Wyłącz powiadomienia
                </button>

                <a href="/" class="contact-action contact-action--secondary">
                    Zostaw powiadomienia
                </a>
            </form>
        </section>
    </div>
</section>
