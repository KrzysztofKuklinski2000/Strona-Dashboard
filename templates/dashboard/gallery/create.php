<?php $errors = $params['flash_dashboard']['message'] ?? []; ?>

<h3 class="dashboard-action-header">Dodawanie zdjęcia do galerii</h3>

<form action="/dashboard/gallery/store" method="POST" enctype="multipart/form-data" class="gallery-editor-form">
    <input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">

    <div class="gallery-editor-form__layout">
        <section class="cards-grid-form__card gallery-editor-form__image-card">
            <header class="cards-grid-form__card-heading">
                <span><i class="fa-regular fa-image" aria-hidden="true"></i></span>
                <strong>Zdjęcie</strong>
            </header>

            <div class="gallery-editor-form__placeholder">
                <i class="fa-regular fa-image" aria-hidden="true"></i>
                <strong>Miejsce na zdjęcie</strong>
                <small>Podgląd pojawi się po zapisaniu zdjęcia.</small>
            </div>

            <label>
                <span>Dodaj zdjęcie</span>
                <input type="file" name="image_name" accept="image/jpeg,image/png,image/gif">
            </label>
            <p class="validation-error"><?= e($errors['image_name'] ?? '') ?></p>
        </section>

        <section class="cards-grid-form__card gallery-editor-form__details-card">
            <header class="cards-grid-form__card-heading">
                <span><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i></span>
                <strong>Informacje o zdjęciu</strong>
            </header>

            <label>
                <span>Kategoria</span>
                <select name="category">
                    <option value="training">Trening</option>
                    <option value="camp">Obóz</option>
                </select>
            </label>
            <p class="validation-error"><?= e($errors['category'] ?? '') ?></p>

            <label>
                <span>Opis</span>
                <input type="text" name="description" maxlength="50" placeholder="Krótko opisz zdjęcie...">
            </label>
            <p class="validation-error"><?= e($errors['description'] ?? '') ?></p>
        </section>
    </div>

    <div class="dashboard-form-actions">
        <input type="submit" value="Stwórz">
        <span>Zdjęcie zostanie dodane do publicznej galerii.</span>
    </div>
</form>
