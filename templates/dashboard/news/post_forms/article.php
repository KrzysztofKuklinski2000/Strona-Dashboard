<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : [];

$image = $payload['image'] ?? null;
?>

<label class="homepage-post-form__description-field">
    <span>Treść aktualności</span>
    <textarea
        name="payload[description]"
        maxlength="1000"
        placeholder="Wpisz treść aktualności..."
    ><?= e($payload['description'] ?? '') ?></textarea>
</label>
<p class="validation-error"><?= e($errors['payload.description'] ?? '') ?></p>

<fieldset class="cards-grid-form__card image-text-list-form__image">
    <legend>
        <span><i class="fa-regular fa-image" aria-hidden="true"></i></span>
        Obraz
    </legend>

    <div class="image-text-list-form__placeholder">
        <?php if (!empty($image['src'])): ?>
            <img src="<?= e($image['src']) ?>" alt="">
            <label>
                <input type="checkbox" name="removeImage" value="1">
                Usuń obecny obraz
            </label>        <?php else: ?>
            <i class="fa-regular fa-image" aria-hidden="true"></i>
            <strong>Miejsce na obraz</strong>
        <?php endif ?>
    </div>

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

