<?php

declare(strict_types=1);

/** @var \App\DTO\Dashboard\Location\LocationDto $data */
$data = $params['data'];
$flash = $params['flash_dashboard'] ?? [];
$errors = is_array($flash['message'] ?? null) ? $flash['message'] : [];
$oldInput = $flash['context']['oldInput'] ?? [];
$csrf = $params['csrf_token'] ?? '';
$action = '/dashboard/timetable/location/update/' . $data->id;
$status = (string) ($oldInput['status'] ?? $data->status);
?>

<h3 class="dashboard-action-header">Edytowanie lokalizacji zajęć</h3>

<form
    action="<?= e($action) ?>"
    method="POST"
    class="dashboard-editor-form dashboard-editor-form--full location-editor-form"
>
    <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
    <input type="hidden" name="id" value="<?= e($data->id) ?>">

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
            </span>
            <span class="dashboard-form-section__title">
                <strong>Dane lokalizacji</strong>
                <small>Zmień nazwę obiektu, miasto lub dokładny adres miejsca treningu.</small>
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
                    value="<?= e($oldInput['name'] ?? $data->name) ?>"
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
                    value="<?= e($oldInput['city'] ?? $data->city) ?>"
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
                value="<?= e($oldInput['address'] ?? $data->address) ?>"
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
                maxlength="255"
                placeholder="np. Sala gimnastyczna, wejście od parkingu."
                aria-describedby="location-description-error"
            ><?= e($oldInput['description'] ?? $data->description) ?></textarea>
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
                <small>Zmień link do mapy lub usuń go, aby ukryć mapę lokalizacji.</small>
            </span>
        </header>

        <label for="location-map-url">
            <span>Link do osadzenia mapy</span>
            <input
                id="location-map-url"
                type="url"
                name="map_embed_url"
                placeholder="https://www.google.com/maps/embed?pb=..."
                value="<?= e($oldInput['map_embed_url'] ?? $data->mapEmbedUrl) ?>"
                aria-describedby="location-map-help location-map-error"
            >
            <small id="location-map-help">
                W Google Maps wybierz "Udostępnij" → "Umieść mapę".
                Wklej sam adres z src="...", bez całego kodu iframe.
            </small>
        </label>
        <p class="validation-error" id="location-map-error"><?= e($errors['map_embed_url'] ?? '') ?></p>
    </section>

    <div class="dashboard-form-actions">
        <input type="submit" value="Zapisz zmiany">
        <span>Zmiany danych lokalizacji będą widoczne w przypisanych do niej zajęciach.</span>
    </div>
</form>
