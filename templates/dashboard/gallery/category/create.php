<?php

declare(strict_types=1);

$errors = $params['flash_dashboard']['message'] ?? [];
$oldInput = $params['flash_dashboard']['context']['oldInput'] ?? [];

?>

<h3 class="dashboard-action-header">Tworzenie kategorii galerii</h3>

<form action="/dashboard/gallery/categories/store" method="POST" class="dashboard-editor-form dashboard-editor-form--full">
    <input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon">
                <i class="fa-solid fa-tags" aria-hidden="true"></i>
            </span>
            <span class="dashboard-form-section__title">
                <strong>Dane kategorii</strong>
                <small>Podaj czytelną nazwę. Slug zostanie utworzony automatycznie na jej podstawie.</small>
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
                value="<?= e($oldInput['name'] ?? '') ?>"
            >
        </label>
        <p class="validation-error"><?= e($errors['name'] ?? '') ?></p>
    </section>

    <div class="dashboard-form-actions">
        <span>Po utworzeniu kategoria będzie dostępna podczas przypisywania zdjęć.</span>
        <input type="submit" value="Dodaj kategorię">
    </div>
</form>
