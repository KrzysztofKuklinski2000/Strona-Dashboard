<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);
?>

<div class="cards-grid-form news-funding-form">
    <fieldset class="cards-grid-form__card news-funding-form__summary">
        <legend>
            <span><i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i></span>
            <strong>Dane dofinansowania</strong>
        </legend>

        <label>
            <span>Źródło finansowania</span>
            <input
                type="text"
                name="payload[funding_source]"
                maxlength="160"
                value="<?= e($payload['funding_source'] ?? '') ?>"
                placeholder="np. Gmina Miasta Wejherowa"
            >
        </label>
        <p class="validation-error"><?= e($errors['payload.funding_source'] ?? '') ?></p>

        <label>
            <span>Kwota <small>(opcjonalnie)</small></span>
            <input
                type="text"
                name="payload[amount]"
                maxlength="80"
                value="<?= e($payload['amount'] ?? '') ?>"
                placeholder="np. 2 500 zł lub do 80% kosztów"
            >
        </label>
        <p class="validation-error"><?= e($errors['payload.amount'] ?? '') ?></p>
    </fieldset>

    <fieldset class="cards-grid-form__card news-funding-form__description">
        <legend>
            <span><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i></span>
            <strong>Opis dofinansowania</strong>
        </legend>

        <label>
            <span>Treść</span>
            <textarea
                name="payload[description]"
                maxlength="1000"
                placeholder="Opisz dofinansowanie i sposób wykorzystania środków..."
            ><?= e($payload['description'] ?? '') ?></textarea>
        </label>
        <p class="validation-error"><?= e($errors['payload.description'] ?? '') ?></p>
    </fieldset>
</div>
