<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : [];

$savedPayload = json_decode((string) ($data->payload ?? ''), true) ?: [];
$savedImage = $savedPayload['image'] ?? [];
$image = $payload['image'] ?? [];
$imageSrc = $image['src'] ?? $savedImage['src'] ?? '';
$imageAlt = $image['alt'] ?? $savedImage['alt'] ?? '';
$removeImage = ($oldInput['removeImage'] ?? null) === '1';
?>

<div class="image-text-list-form news-article-form">
    <section class="cards-grid-form__card image-text-list-form__image">
        <header class="cards-grid-form__card-heading">
            <span><i class="fa-regular fa-image" aria-hidden="true"></i></span>
            <strong>Obraz opcjonalny</strong>
        </header>

        <div class="image-text-list-form__placeholder">
            <?php if ($imageSrc !== ''): ?>
                <img
                    src="<?= e($imageSrc) ?>"
                    alt="<?= e($imageAlt !== '' ? $imageAlt : ($titleValue ?? '')) ?>"
                >
            <?php else: ?>
                <i class="fa-regular fa-image" aria-hidden="true"></i>
                <strong>Miejsce na obraz</strong>
                <small>Możesz opublikować artykuł bez zdjęcia</small>
            <?php endif ?>
        </div>

        <?php if ($imageSrc !== ''): ?>
            <label class="news-article-form__remove">
                <input
                    type="checkbox"
                    name="removeImage"
                    value="1"
                    <?= $removeImage ? 'checked' : '' ?>
                >
                <span>Usuń obecny obraz</span>
            </label>
        <?php endif ?>

        <label>
            <span><?= $imageSrc !== '' ? 'Zmień obraz' : 'Dodaj obraz' ?></span>
            <input type="file" name="postImage" accept="image/jpeg,image/png,image/gif">
        </label>
        <p class="validation-error"><?= e($errors['postImage'] ?? '') ?></p>

        <label>
            <span>Opis alternatywny</span>
            <input
                type="text"
                name="payload[image][alt]"
                maxlength="160"
                value="<?= e($imageAlt) ?>"
                placeholder="Krótko opisz zawartość obrazu"
            >
        </label>
        <p class="validation-error"><?= e($errors['payload.image.alt'] ?? '') ?></p>
    </section>

    <section class="cards-grid-form__card image-text-list-form__content news-article-form__content">
        <header class="cards-grid-form__card-heading">
            <span><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i></span>
            <strong>Treść aktualności</strong>
        </header>

        <label class="homepage-post-form__description-field">
            <span>Treść aktualności</span>
            <textarea
                name="payload[description]"
                maxlength="1000"
                placeholder="Wpisz treść aktualności..."
            ><?= e($payload['description'] ?? '') ?></textarea>
        </label>
        <p class="validation-error"><?= e($errors['payload.description'] ?? '') ?></p>
    </section>
</div>
