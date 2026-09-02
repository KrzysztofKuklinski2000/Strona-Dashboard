<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);

$link = is_array($payload['link'] ?? null) ? $payload['link'] : [];
?>

<div class="cards-grid-form news-event-form">
    <fieldset class="cards-grid-form__card news-event-form__schedule">
        <legend>
            <span><i class="fa-regular fa-calendar-days" aria-hidden="true"></i></span>
            <strong>Termin wydarzenia</strong>
        </legend>

        <label>
            <span>Data</span>
            <input
                type="date"
                name="payload[event_date]"
                value="<?= e($payload['event_date'] ?? '') ?>"
            >
        </label>
        <p class="validation-error"><?= e($errors['payload.event_date'] ?? '') ?></p>

        <div class="news-event-form__time-fields">
            <label>
                <span>Godzina rozpoczęcia</span>
                <input
                    type="time"
                    name="payload[start_time]"
                    value="<?= e($payload['start_time'] ?? '') ?>"
                >
            </label>

            <label>
                <span>Godzina zakończenia <small>(opcjonalnie)</small></span>
                <input
                    type="time"
                    name="payload[end_time]"
                    value="<?= e($payload['end_time'] ?? '') ?>"
                >
            </label>
        </div>
        <p class="validation-error"><?= e($errors['payload.start_time'] ?? '') ?></p>
        <p class="validation-error"><?= e($errors['payload.end_time'] ?? '') ?></p>
    </fieldset>

    <div class="news-event-form__content">
        <fieldset class="cards-grid-form__card">
            <legend>
                <span><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i></span>
                <strong>Opis wydarzenia</strong>
            </legend>

            <label>
                <span>Treść</span>
                <textarea
                    name="payload[description]"
                    maxlength="1000"
                    placeholder="Napisz, czego dotyczy wydarzenie..."
                ><?= e($payload['description'] ?? '') ?></textarea>
            </label>
            <p class="validation-error"><?= e($errors['payload.description'] ?? '') ?></p>
        </fieldset>

        <fieldset class="cards-grid-form__card">
            <legend>
                <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                <strong>Miejsce</strong>
            </legend>

            <label>
                <span>Nazwa lub adres miejsca</span>
                <input
                    type="text"
                    name="payload[location]"
                    maxlength="160"
                    value="<?= e($payload['location'] ?? '') ?>"
                    placeholder="np. Hala sportowa w Wejherowie"
                >
            </label>
            <p class="validation-error"><?= e($errors['payload.location'] ?? '') ?></p>
        </fieldset>

        <fieldset class="cards-grid-form__card news-event-form__link">
            <legend>
                <span><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span>
                <strong>Przycisk <small>(opcjonalnie)</small></strong>
            </legend>

            <div class="news-event-form__link-fields">
                <label>
                    <span>Tekst przycisku</span>
                    <input
                        type="text"
                        name="payload[link][label]"
                        maxlength="80"
                        value="<?= e($link['label'] ?? '') ?>"
                        placeholder="np. Zapisz się"
                    >
                </label>

                <label>
                    <span>Adres</span>
                    <input
                        type="text"
                        name="payload[link][url]"
                        maxlength="255"
                        value="<?= e($link['url'] ?? '') ?>"
                        placeholder="np. /zapisy"
                    >
                </label>
            </div>
            <p class="validation-error"><?= e($errors['payload.link.label'] ?? '') ?></p>
            <p class="validation-error"><?= e($errors['payload.link.url'] ?? '') ?></p>
        </fieldset>
    </div>
</div>
