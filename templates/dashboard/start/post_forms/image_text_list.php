<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);

$image = $payload['image'] ?? [];
$items = $payload['items'] ?? [];
$link = $payload['link'] ?? [];

if (!$items) {
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

        <fieldset class="cards-grid-form__card image-text-list-form__group">
            <legend>
                <span><i class="fa-solid fa-list-check" aria-hidden="true"></i></span>
                Lista punktów
            </legend>
            <?php foreach ($items as $index => $item): ?>
                <label>
                    <span>Punkt <?= (int) $index + 1 ?></span>
                    <input type="text" name="payload[items][<?= (int) $index ?>]" maxlength="160" value="<?= e($item) ?>" placeholder="Treść punktu">
                </label>
                <p class="validation-error"><?= e($errors["payload.items.$index"] ?? '') ?></p>
            <?php endforeach ?>
        </fieldset>

        <fieldset class="cards-grid-form__card image-text-list-form__group">
            <legend>
                <span><i class="fa-solid fa-arrow-pointer" aria-hidden="true"></i></span>
                Przycisk / link
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
    </div>
</div>
