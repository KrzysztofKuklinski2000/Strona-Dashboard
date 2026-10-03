<?php

/** @var \App\DTO\Dashboard\Timetable\TimetableDto $data */
$dayLabels = [
    'PON' => 'Poniedziałek',
    'WT' => 'Wtorek',
    'ŚR' => 'Środa',
    'CZW' => 'Czwartek',
    'PT' => 'Piątek',
    'SOB' => 'Sobota',
    'NIEDZ' => 'Niedziela',
];
$dayLabel = $dayLabels[$data->day] ?? $data->day;
$locationName = trim($data->locationName);
$locationDetails = implode(', ', array_filter(
    [trim($data->locationCity), trim($data->locationAddress)],
    static fn(string $value): bool => $value !== '',
));
$isPublic = $data->status === 1;
?>

<article class="homepage-post-details">
    <section class="homepage-post-details__content">
        <p class="homepage-post-details__eyebrow">Zajęcia karate</p>
        <h4><?= e($dayLabel) ?></h4>
        <p class="homepage-post-details__description">Grupa: <?= e($data->advancementGroup) ?></p>
    </section>

    <dl class="homepage-post-details__meta">
        <div>
            <dt>Rozpoczęcie</dt>
            <dd><?= e(substr($data->start, 0, 5)) ?></dd>
        </div>
        <div>
            <dt>Zakończenie</dt>
            <dd><?= e(substr($data->end, 0, 5)) ?></dd>
        </div>
        <div>
            <dt>Status</dt>
            <dd class="<?= $isPublic ? 'is-public' : 'is-private' ?>">
                <?= $isPublic ? 'Publiczny' : 'Niepubliczny' ?>
            </dd>
        </div>
        <div>
            <dt>Identyfikator</dt>
            <dd><?= e($data->id) ?></dd>
        </div>
    </dl>

    <section class="homepage-post-details__content">
        <p class="homepage-post-details__eyebrow">Lokalizacja zajęć</p>
        <h4>
            <a href="/dashboard/timetable/location/show/<?= e($data->locationId) ?>">
                <?= e($locationName !== '' ? $locationName : 'Lokalizacja #' . $data->locationId) ?>
            </a>
        </h4>
        <?php if ($locationDetails !== ''): ?>
            <p class="homepage-post-details__description"><?= e($locationDetails) ?></p>
        <?php endif ?>
    </section>
</article>
