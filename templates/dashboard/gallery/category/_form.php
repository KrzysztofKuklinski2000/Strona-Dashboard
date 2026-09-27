<?php

declare(strict_types=1);

$errors = $params['flash_dashboard']['message'] ?? [];
$oldInput = $params['flash_dashboard']['context']['oldInput'] ?? [];
$csrf = $params['csrf_token'] ?? '';
$categoryId = $data?->id;
$nameValue = $oldInput['name'] ?? ($data?->name ?? '');

?>

<h3 class="dashboard-action-header"><?= e($formTitle) ?></h3>

<form action="<?= e($action) ?>" method="POST" class="dashboard-editor-form dashboard-editor-form--full">
    <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">

    <?php if ($categoryId !== null): ?>
        <input type="hidden" name="id" value="<?= e($categoryId) ?>">
    <?php endif; ?>

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon">
                <i class="fa-solid fa-tags" aria-hidden="true"></i>
            </span>
            <span class="dashboard-form-section__title">
                <strong>Dane kategorii</strong>
                <small><?= e($sectionDescription) ?></small>
            </span>
        </header>

        <label>
            <span>Nazwa kategorii</span>
            <input
                type="text"
                name="name"
                maxlength="100"
                placeholder="np. Obozy 2026"
                autocomplete="off"
                value="<?= e($nameValue) ?>"
            >
        </label>
        <p class="validation-error"><?= e($errors['name'] ?? '') ?></p>
    </section>

    <div class="dashboard-form-actions">
        <span><?= e($actionDescription) ?></span>
        <input type="submit" value="<?= e($buttonTitle) ?>">
    </div>
</form>
