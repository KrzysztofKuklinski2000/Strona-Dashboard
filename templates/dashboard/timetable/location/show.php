<?php

declare(strict_types=1);

$data = $params['data'];
$action = '/dashboard/timetable/location/published/' . $data->id;
$csrf = $params['csrf_token'] ?? '';
$formTitle = 'Szczegóły lokalizacji';
$statusLegend = 'Dostępność lokalizacji';
$enabledStatusTitle = 'Aktywna';
$enabledStatusDescription = 'Lokalizacja jest dostępna do wyboru podczas tworzenia zajęć.';
$disabledStatusTitle = 'Nieaktywna';
$disabledStatusDescription = 'Lokalizacja nie jest dostępna do nowych przypisań. Istniejące przypisania do zajęć pozostają bez zmian.';
$isActive = $data->status === 1;
$statusClass = $isActive ? 'is-public' : 'is-private';
$statusText = $isActive ? 'Aktywna' : 'Nieaktywna';
$description = trim($data->description);
$mapUrl = trim($data->mapEmbedUrl);
$mapParts = parse_url($mapUrl) ?: [];
$mapPath = $mapParts['path'] ?? '';
$hasValidMap = filter_var($mapUrl, FILTER_VALIDATE_URL) !== false
    && ($mapParts['scheme'] ?? '') === 'https'
    && in_array(strtolower($mapParts['host'] ?? ''), ['www.google.com', 'maps.google.com'], true)
    && ($mapPath === '/maps/embed' || str_starts_with($mapPath, '/maps/embed/'));

ob_start();
?>

        <article class="homepage-post-details">
            <section class="homepage-post-details__content">
                <p class="homepage-post-details__eyebrow">Lokalizacja zajęć</p>
                <h4><?= e($data->name) ?></h4>
                <p class="homepage-post-details__description">
                    <?= $description !== '' ? e_br($description) : 'Brak dodatkowego opisu.' ?>
                </p>
            </section>

            <dl class="homepage-post-details__meta">
                <div>
                    <dt>Miasto</dt>
                    <dd><?= e($data->city) ?></dd>
                </div>
                <div>
                    <dt>Adres</dt>
                    <dd><?= e($data->address) ?></dd>
                </div>
                <div>
                    <dt>Status</dt>
                    <dd class="<?= e($statusClass) ?>"><?= e($statusText) ?></dd>
                </div>
                <div>
                    <dt>Identyfikator</dt>
                    <dd><?= e($data->id) ?></dd>
                </div>
                <div>
                    <dt>Data utworzenia</dt>
                    <dd><?= e($data->createdAt) ?></dd>
                </div>
                <div>
                    <dt>Ostatnia aktualizacja</dt>
                    <dd><?= e($data->updatedAt) ?></dd>
                </div>
            </dl>

            <section class="dashboard-post-preview" aria-labelledby="location-map-title">
                <div class="dashboard-post-preview__heading">
                    <span class="dashboard-post-preview__icon" aria-hidden="true">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </span>
                    <div>
                        <h4 id="location-map-title">Mapa lokalizacji</h4>
                        <p>Dokładne położenie miejsca treningu.</p>
                    </div>
                </div>

                <?php if ($hasValidMap): ?>
                    <iframe
                        class="dashboard-post-preview__frame"
                        src="<?= e($mapUrl) ?>"
                        title="<?= e('Mapa lokalizacji: ' . $data->name) ?>"
                        width="100%"
                        height="320"
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                    ></iframe>
                <?php else: ?>
                    <div class="dashboard-post-preview__empty">
                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                        <p><?= $mapUrl === '' ? 'Nie dodano mapy dla tej lokalizacji.' : 'Link do mapy jest nieprawidłowy. Wymagany jest link osadzania z Google Maps.' ?></p>
                    </div>
                <?php endif; ?>
            </section>
        </article>

<?php
$postDetailsHtml = ob_get_clean();

require 'templates/dashboard/_partials/_show_form.php';
