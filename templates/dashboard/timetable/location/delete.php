<?php

declare(strict_types=1);

$data = $params['data'];
$action = '/dashboard/timetable/location/delete/' . $data->id;
$formTitle = 'Usuwanie lokalizacji zajęć';
$csrf = $params['csrf_token'] ?? '';
$description = trim($data->description);
$isActive = $data->status === 1;


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
            <dd class="<?= $isActive ? 'is-public' : 'is-private' ?>">
                <?= $isActive ? 'Aktywna' : 'Nieaktywna' ?>
            </dd>
        </div>
        <div>
            <dt>Data utworzenia</dt>
            <dd><?= e($data->createdAt) ?></dd>
        </div>
    </dl>

    <?php require 'templates/dashboard/timetable/location/_assigned_timetable.php'; ?>

    <p>
        Lokalizacji przypisanej do zajęć nie można usunąć.
        Najpierw zmień lokalizację w tych zajęciach lub usuń jej przypisanie.
        Jeśli chcesz tylko ukryć lokalizację na liście wyboru, zmień jej status na nieaktywny.
    </p>
</article>

<?php
$postDetailsHtml = ob_get_clean();

require 'templates/dashboard/_partials/_delete_form.php';
