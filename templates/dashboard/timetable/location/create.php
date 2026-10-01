<?php

declare(strict_types=1);

$flash = $params['flash_dashboard'] ?? [];
$errors = is_array($flash['message'] ?? null) ? $flash['message'] : [];
$oldInput = $flash['context']['oldInput'] ?? [];
$csrf = $params['csrf_token'] ?? '';
$status = (string) ($oldInput['status'] ?? '1');
?>

<h3 class="dashboard-action-header">Dodawanie lokalizacji zajęć</h3>

<form
    action="/dashboard/timetable/location/store"
    method="POST"
    class="dashboard-editor-form dashboard-editor-form--full location-editor-form"
>
    <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
            </span>
            <span class="dashboard-form-section__title">
                <strong>Dane lokalizacji</strong>
                <small>Podaj nazwę obiektu, miasto i dokładny adres miejsca treningu.</small>
            </span>
        </header>

        <div class="dashboard-form-grid">
            <label for="location-name">
                <span>Nazwa lokalizacji</span>
                <input
                    id="location-name"
                    type="text"
                    name="name"
                    maxlength="100"
                    placeholder="np. Szkoła Podstawowa nr 6"
                    value="<?= e($oldInput['name'] ?? '') ?>"
                    aria-describedby="location-name-error"
                    required
                >
                <span class="validation-error" id="location-name-error"><?= e($errors['name'] ?? '') ?></span>
            </label>

            <label for="location-city">
                <span>Miasto</span>
                <input
                    id="location-city"
                    type="text"
                    name="city"
                    maxlength="50"
                    autocomplete="address-level2"
                    placeholder="np. Reda"
                    value="<?= e($oldInput['city'] ?? '') ?>"
                    aria-describedby="location-city-error"
                    required
                >
                <span class="validation-error" id="location-city-error"><?= e($errors['city'] ?? '') ?></span>
            </label>
        </div>

        <label for="location-address">
            <span>Adres</span>
            <input
                id="location-address"
                type="text"
                name="address"
                maxlength="200"
                autocomplete="street-address"
                placeholder="Ulica, numer budynku i kod pocztowy"
                value="<?= e($oldInput['address'] ?? '') ?>"
                aria-describedby="location-address-error"
                required
            >
        </label>
        <p class="validation-error" id="location-address-error"><?= e($errors['address'] ?? '') ?></p>

        <label for="location-description">
            <span>Dodatkowe informacje (opcjonalnie)</span>
            <textarea
                id="location-description"
                name="description"
                placeholder="np. Sala gimnastyczna, wejście od parkingu."
                aria-describedby="location-description-error"
                maxlength="255"
            ><?= e($oldInput['description'] ?? '') ?></textarea>
        </label>
        <p class="validation-error" id="location-description-error"><?= e($errors['description'] ?? '') ?></p>
    </section>

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon">
                <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
            </span>
            <span class="dashboard-form-section__title">
                <strong>Mapa Google (opcjonalnie)</strong>
                <small>Dodaj mapę wskazującą dokładne położenie miejsca treningu.</small>
            </span>
        </header>

        <label for="location-map-url">
            <span>Link do osadzenia mapy</span>
            <input
                id="location-map-url"
                type="url"
                name="map_embed_url"
                placeholder="https://www.google.com/maps/embed?pb=..."
                value="<?= e($oldInput['map_embed_url'] ?? '') ?>"
                aria-describedby="location-map-help location-map-error"
            >
            <small id="location-map-help">
                W Google Maps wybierz „Udostępnij” → „Umieść mapę”.
                Wklej sam adres z src="...", bez całego kodu iframe.
            </small>
        </label>
        <p class="validation-error" id="location-map-error"><?= e($errors['map_embed_url'] ?? '') ?></p>
    </section>

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon">
                <i class="fa-solid fa-toggle-on" aria-hidden="true"></i>
            </span>
            <span class="dashboard-form-section__title">
                <strong>Dostępność lokalizacji</strong>
                <small>Aktywna lokalizacja będzie dostępna do wyboru podczas tworzenia zajęć.</small>
            </span>
        </header>

        <label for="location-status">
            <span>Status</span>
            <select id="location-status" name="status" aria-describedby="location-status-error">
                <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Aktywna</option>
                <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Nieaktywna</option>
            </select>
        </label>
        <p class="validation-error" id="location-status-error"><?= e($errors['status'] ?? '') ?></p>
    </section>

    <div class="dashboard-form-actions">
        <input type="submit" value="Dodaj lokalizację">
        <span>Dane lokalizacji będą wykorzystywane w przypisanych do niej zajęciach.</span>
    </div>
</form>
