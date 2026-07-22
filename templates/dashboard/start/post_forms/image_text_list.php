<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);

$image = $payload['image'] ?? [];
$items = is_array($payload['items'] ?? null) ? $payload['items'] : [];
$link = is_array($payload['link'] ?? null) ? $payload['link'] : [];
$hasSavedPayload = !empty($data->payload);
$hasItems = array_key_exists('items', $payload) ? !empty($items) : !$hasSavedPayload;
$hasLink = array_key_exists('link', $payload)
    ? !empty($link['label']) || !empty($link['url'])
    : !$hasSavedPayload;

if ($hasItems && !$items) {
    $items = ['', '', ''];
}
?>

<div class="cards-grid-form image-text-list-form">
    <fieldset class="cards-grid-form__card image-text-list-form__image">
        <legend>
            <span><i class="fa-regular fa-image" aria-hidden="true"></i></span>
            Obraz
        </legend>

        <div class="image-text-list-form__placeholder">
            <?php if (!empty($image['src'])): ?>
                <img src="<?= e($image['src']) ?>" alt="">
            <?php else: ?>
                <i class="fa-regular fa-image" aria-hidden="true"></i>
                <strong>Miejsce na obraz</strong>
                <small>Obraz będzie wyświetlany po lewej stronie posta</small>
            <?php endif ?>
        </div>

        <input type="hidden" name="payload[image][src]" value="<?= e($image['src'] ?? '') ?>">

        <label>
            <span><?= !empty($image['src']) ? 'Zmień obraz' : 'Dodaj obraz' ?></span>
            <input type="file" name="postImage" accept="image/jpeg,image/png,image/gif">
        </label>
        <p class="validation-error"><?= e($errors['postImage'] ?? '') ?></p>

        <label>
            <span>Opis alternatywny</span>
            <input type="text" name="payload[image][alt]" maxlength="160" value="<?= e($image['alt'] ?? '') ?>" placeholder="Opis obrazka">
        </label>
        <p class="validation-error"><?= e($errors['payload.image.alt'] ?? '') ?></p>
    </fieldset>

    <div class="image-text-list-form__content">
        <div class="image-text-list-form__eyebrow">
            <label>
                <span>Nadtytuł</span>
                <input type="text" name="payload[eyebrow]" maxlength="80" value="<?= e($payload['eyebrow'] ?? '') ?>" placeholder="np. Trening dla całej rodziny">
            </label>
            <p class="validation-error"><?= e($errors['payload.eyebrow'] ?? '') ?></p>
        </div>

        <div class="image-text-list-form__description">
            <label class="homepage-post-form__description-field">
                <span>Opis sekcji</span>
                <textarea
                    name="payload[description]"
                    maxlength="1000"
                    placeholder="Krótki opis sekcji..."
                ><?= e($payload['description'] ?? '') ?></textarea>
            </label>
            <p class="validation-error"><?= e($errors['payload.description'] ?? '') ?></p>
        </div>

        <div class="image-text-list-form__optional-slot image-text-list-form__list-slot">
            <fieldset class="cards-grid-form__card image-text-list-form__group" data-list-section <?= !$hasItems ? 'hidden' : '' ?>>
                <legend>
                    <span><i class="fa-solid fa-list-check" aria-hidden="true"></i></span>
                    Lista punktów
                    <button type="button" class="cards-grid-form__remove" data-remove-list aria-label="Usuń całą listę">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </legend>

                <div class="image-text-list-form__items" data-list-items data-max-items="20">
                    <?php foreach ($items as $index => $item): ?>
                        <div class="image-text-list-form__item" data-list-item>
                            <label>
                                <span data-list-item-label>Punkt <?= (int) $index + 1 ?></span>
                                <input
                                    type="text"
                                    data-list-item-input
                                    name="payload[items][<?= (int) $index ?>]"
                                    maxlength="160"
                                    value="<?= e($item) ?>"
                                    placeholder="Treść punktu"
                                >
                            </label>
                            <button type="button" class="image-text-list-form__item-remove" data-remove-list-item aria-label="Usuń punkt <?= (int) $index + 1 ?>">
                                <i class="fa-solid fa-trash" aria-hidden="true"></i>
                            </button>
                            <p class="validation-error"><?= e($errors["payload.items.$index"] ?? '') ?></p>
                        </div>
                    <?php endforeach ?>
                </div>
                <p class="validation-error"><?= e($errors['payload.items'] ?? '') ?></p>

                <button type="button" class="cards-grid-form__add image-text-list-form__add-item" data-add-list-item>
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    Dodaj punkt
                </button>
            </fieldset>

            <button type="button" class="cards-grid-form__add" data-add-list <?= $hasItems ? 'hidden' : '' ?>>
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                Dodaj listę punktów
            </button>
        </div>

        <div class="image-text-list-form__optional-slot image-text-list-form__link-slot">
            <fieldset class="cards-grid-form__card image-text-list-form__group" data-link-section <?= !$hasLink ? 'hidden' : '' ?>>
                <legend>
                    <span><i class="fa-solid fa-arrow-pointer" aria-hidden="true"></i></span>
                    Przycisk / link
                    <button type="button" class="cards-grid-form__remove" data-remove-link aria-label="Usuń przycisk">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </legend>
                <div class="image-text-list-form__link">
                    <label>
                        <span>Tekst</span>
                        <input type="text" name="payload[link][label]" maxlength="80" value="<?= e($link['label'] ?? '') ?>" placeholder="Etykieta linku">
                    </label>
                    <label>
                        <span>Adres</span>
                        <input type="text" name="payload[link][url]" maxlength="255" value="<?= e($link['url'] ?? '') ?>" placeholder="Adres linku">
                    </label>
                </div>
                <p class="validation-error"><?= e($errors['payload.link.label'] ?? '') ?></p>
                <p class="validation-error"><?= e($errors['payload.link.url'] ?? '') ?></p>
            </fieldset>

            <button type="button" class="cards-grid-form__add" data-add-link <?= $hasLink ? 'hidden' : '' ?>>
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                Dodaj przycisk
            </button>
        </div>
    </div>
</div>

<template data-list-item-template>
    <div class="image-text-list-form__item" data-list-item>
        <label>
            <span data-list-item-label></span>
            <input type="text" data-list-item-input maxlength="160" placeholder="Treść punktu">
        </label>
        <button type="button" class="image-text-list-form__item-remove" data-remove-list-item aria-label="Usuń punkt">
            <i class="fa-solid fa-trash" aria-hidden="true"></i>
        </button>
    </div>
</template>
