<?php
    $data = $params['data'];
    $action = '/dashboard/gallery/update/' . ($data->id ?? '');
    $errors = $params['flash_dashboard']['message'] ?? [];
?>

<h3 class="dashboard-action-header">Edytowanie zdjęcia</h3>

<form action="<?= e($action) ?>" method="POST" enctype="multipart/form-data" class="gallery-editor-form">
    <input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">
    <input type="hidden" name="id" value="<?= e($data->id) ?>">

    <div class="gallery-editor-form__layout">
        <section class="cards-grid-form__card gallery-editor-form__image-card">
            <header class="cards-grid-form__card-heading">
                <span><i class="fa-regular fa-image" aria-hidden="true"></i></span>
                <strong>Zdjęcie</strong>
            </header>

            <div class="gallery-editor-form__placeholder gallery-editor-form__placeholder--filled">
                <img
                    src="/public/uploads/<?= e(rawurlencode((string) $data->imageName)) ?>"
                    alt="<?= e($data->description) ?>"
                >
            </div>

            <label>
                <span>Zmień zdjęcie (opcjonalnie)</span>
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
                    <option value="training" <?= $data->category === 'training' ? 'selected' : '' ?>>Trening</option>
                    <option value="camp" <?= $data->category === 'camp' ? 'selected' : '' ?>>Obóz</option>
                </select>
            </label>
            <p class="validation-error"><?= e($errors['category'] ?? '') ?></p>

            <label>
                <span>Opis</span>
                <input
                    type="text"
                    name="description"
                    maxlength="50"
                    placeholder="Krótko opisz zdjęcie..."
                    value="<?= e($data->description) ?>"
                >
            </label>
            <p class="validation-error"><?= e($errors['description'] ?? '') ?></p>
        </section>
    </div>

    <div class="dashboard-form-actions">
        <input type="submit" value="Zapisz">
        <span>Możesz zmienić dane zdjęcia bez dodawania nowego pliku.</span>
    </div>
</form>
