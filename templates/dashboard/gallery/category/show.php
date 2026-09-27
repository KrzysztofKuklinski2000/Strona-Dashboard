<?php

declare(strict_types=1);

$data = $params['data'];
$isActive = $data->status === 1;
$statusClass = $isActive ? 'is-public' : 'is-private';
$statusText = $isActive ? 'Aktywna' : 'Nieaktywna';
?>

<h3 class="dashboard-action-header">Szczegóły kategorii galerii</h3>

<div class="dashboard-action-page">
    <div class="post-content">
        <article class="homepage-post-details">
            <section class="homepage-post-details__content">
                <p class="homepage-post-details__eyebrow">Kategoria galerii</p>
                <h4><?= e($data->name) ?></h4>
            </section>

            <dl class="homepage-post-details__meta">
                <div>
                    <dt>Slug</dt>
                    <dd><?= e($data->slug) ?></dd>
                </div>
                <div>
                    <dt>Status</dt>
                    <dd class="<?= e($statusClass) ?>"><?= e($statusText) ?></dd>
                </div>
                <div>
                    <dt>Pozycja</dt>
                    <dd><?= e($data->position) ?></dd>
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
        </article>
    </div>
</div>
