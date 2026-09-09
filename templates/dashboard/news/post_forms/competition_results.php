<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);

$results = is_array($payload['results'] ?? null) ? $payload['results'] : [];
$link = is_array($payload['link'] ?? null) ? $payload['link'] : [];

if ($results === []) {
    $results = array_fill(0, 3, [
        'place' => '',
        'competitor' => '',
        'category' => '',
    ]);
}
?>

<div class="cards-grid-form news-results-form">
    <fieldset class="cards-grid-form__card news-results-form__summary">
        <legend>
            <span><i class="fa-solid fa-trophy" aria-hidden="true"></i></span>
            <strong>Zawody</strong>
        </legend>

        <label>
            <span>Data zawodów</span>
            <input
                type="date"
                name="payload[competition_date]"
                value="<?= e($payload['competition_date'] ?? '') ?>"
            >
        </label>
        <p class="validation-error"><?= e($errors['payload.competition_date'] ?? '') ?></p>

        <label>
            <span>Miejsce zawodów</span>
            <input
                type="text"
                name="payload[location]"
                maxlength="160"
                value="<?= e($payload['location'] ?? '') ?>"
                placeholder="np. Gdańsk"
            >
        </label>
        <p class="validation-error"><?= e($errors['payload.location'] ?? '') ?></p>
    </fieldset>

    <div class="news-results-form__content">
        <fieldset class="cards-grid-form__card">
            <legend>
                <span><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i></span>
                <strong>Podsumowanie</strong>
            </legend>

            <label>
                <span>Krótki opis zawodów</span>
                <textarea
                    name="payload[description]"
                    maxlength="1000"
                    placeholder="Napisz krótkie podsumowanie zawodów..."
                ><?= e($payload['description'] ?? '') ?></textarea>
            </label>
            <p class="validation-error"><?= e($errors['payload.description'] ?? '') ?></p>
        </fieldset>

        <fieldset class="cards-grid-form__card news-results-form__results">
            <legend>
                <span><i class="fa-solid fa-medal" aria-hidden="true"></i></span>
                <strong>Wyniki zawodników</strong>
            </legend>

            <div class="news-results-form__list" data-results-list data-max-results="20">
                <?php foreach ($results as $index => $result): ?>
                    <?php
                    $result = is_array($result) ? $result : [];
                    $place = is_scalar($result['place'] ?? null) ? (string) $result['place'] : '';
                    $competitor = is_scalar($result['competitor'] ?? null) ? (string) $result['competitor'] : '';
                    $category = is_scalar($result['category'] ?? null) ? (string) $result['category'] : '';
                    ?>

                    <div class="news-results-form__result" data-result-row>
                        <div class="news-results-form__result-heading">
                            <strong data-result-label>Wynik <?= (int) $index + 1 ?></strong>
                            <button
                                type="button"
                                class="cards-grid-form__remove"
                                data-remove-result
                                aria-label="Usuń wynik <?= (int) $index + 1 ?>"
                            >
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="news-results-form__result-fields">
                            <label>
                                <span>Miejsce</span>
                                <input
                                    type="text"
                                    name="payload[results][<?= (int) $index ?>][place]"
                                    data-result-field="place"
                                    maxlength="30"
                                    value="<?= e($place) ?>"
                                    placeholder="np. 1. miejsce"
                                >
                            </label>

                            <label>
                                <span>Zawodnik lub drużyna</span>
                                <input
                                    type="text"
                                    name="payload[results][<?= (int) $index ?>][competitor]"
                                    data-result-field="competitor"
                                    maxlength="120"
                                    value="<?= e($competitor) ?>"
                                    placeholder="Imię i nazwisko"
                                >
                            </label>

                            <label>
                                <span>Kategoria</span>
                                <input
                                    type="text"
                                    name="payload[results][<?= (int) $index ?>][category]"
                                    data-result-field="category"
                                    maxlength="120"
                                    value="<?= e($category) ?>"
                                    placeholder="np. Kumite juniorów"
                                >
                            </label>
                        </div>

                        <p class="validation-error"><?= e($errors["payload.results.$index.place"] ?? '') ?></p>
                        <p class="validation-error"><?= e($errors["payload.results.$index.competitor"] ?? '') ?></p>
                        <p class="validation-error"><?= e($errors["payload.results.$index.category"] ?? '') ?></p>
                    </div>
                <?php endforeach ?>
            </div>

            <p class="validation-error"><?= e($errors['payload.results'] ?? '') ?></p>

            <button type="button" class="cards-grid-form__add" data-add-result>
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                Dodaj wynik
            </button>
        </fieldset>

        <fieldset class="cards-grid-form__card news-results-form__link">
            <legend>
                <span><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span>
                <strong>Przycisk <small>(opcjonalnie)</small></strong>
            </legend>

            <div class="news-results-form__link-fields">
                <label>
                    <span>Tekst przycisku</span>
                    <input
                        type="text"
                        name="payload[link][label]"
                        maxlength="80"
                        value="<?= e($link['label'] ?? '') ?>"
                        placeholder="np. Pełne wyniki"
                    >
                </label>

                <label>
                    <span>Adres</span>
                    <input
                        type="text"
                        name="payload[link][url]"
                        maxlength="255"
                        value="<?= e($link['url'] ?? '') ?>"
                        placeholder="np. /aktualnosci"
                    >
                </label>
            </div>
            <p class="validation-error"><?= e($errors['payload.link.label'] ?? '') ?></p>
            <p class="validation-error"><?= e($errors['payload.link.url'] ?? '') ?></p>
        </fieldset>
    </div>
</div>

<template data-result-template>
    <div class="news-results-form__result" data-result-row>
        <div class="news-results-form__result-heading">
            <strong data-result-label></strong>
            <button type="button" class="cards-grid-form__remove" data-remove-result aria-label="Usuń wynik">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="news-results-form__result-fields">
            <label>
                <span>Miejsce</span>
                <input type="text" data-result-field="place" maxlength="30" placeholder="np. 1. miejsce">
            </label>
            <label>
                <span>Zawodnik lub drużyna</span>
                <input type="text" data-result-field="competitor" maxlength="120" placeholder="Imię i nazwisko">
            </label>
            <label>
                <span>Kategoria</span>
                <input type="text" data-result-field="category" maxlength="120" placeholder="np. Kumite juniorów">
            </label>
        </div>
    </div>
</template>
