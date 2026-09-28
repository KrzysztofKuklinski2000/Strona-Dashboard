<?php

declare(strict_types=1);

$categories = $categories ?? [];
$errors = $errors ?? [];
$oldInput = $params['flash_dashboard']['context']['oldInput'] ?? [];
$submittedCategoryIds = $oldInput['category_ids'] ?? ($selectedCategoryIds ?? []);

if (!is_array($submittedCategoryIds)) {
    $submittedCategoryIds = [];
}

$selectedCategoryIds = array_map('intval', $submittedCategoryIds);
?>

<fieldset class="gallery-category-field">
    <legend>Kategorie</legend>

    <?php if ($categories === []): ?>
        <div class="gallery-category-field__empty">
            <i class="fa-solid fa-tags" aria-hidden="true"></i>
            <span>Brak aktywnych kategorii do przypisania.</span>
        </div>
    <?php else: ?>
        <div class="gallery-category-options">
            <?php foreach ($categories as $category): ?>
                <label class="gallery-category-option">
                    <input
                        type="checkbox"
                        name="category_ids[]"
                        value="<?= e($category->id) ?>"
                        <?= in_array($category->id, $selectedCategoryIds, true) ? 'checked' : '' ?>
                    >
                    <span class="gallery-category-option__content">
                        <span class="gallery-category-option__icon" aria-hidden="true">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                        <span class="gallery-category-option__name"><?= e($category->name) ?></span>
                        <span class="gallery-category-option__check" aria-hidden="true">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </span>
                </label>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <small class="gallery-category-field__help">Możesz przypisać zdjęcie do kilku kategorii.</small>
</fieldset>
<p class="validation-error"><?= e($errors['category_ids'] ?? '') ?></p>
