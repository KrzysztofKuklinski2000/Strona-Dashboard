<?php
$dayLabels = [
    'PON' => 'Poniedziałek',
    'WT' => 'Wtorek',
    'ŚR' => 'Środa',
    'CZW' => 'Czwartek',
    'PT' => 'Piątek',
    'SOB' => 'Sobota',
    'NIEDZ' => 'Niedziela',
];

$dayCode = trim((string) ($feedPost->day ?? ''));
$dayLabel = $dayLabels[$dayCode] ?? $dayCode;
$start = substr(trim((string) ($feedPost->start ?? '')), 0, 5);
$end = substr(trim((string) ($feedPost->end ?? '')), 0, 5);
$group = trim((string) ($feedPost->advancementGroup ?? ''));
$city = trim((string) ($feedPost->city ?? ''));
$place = trim((string) ($feedPost->place ?? ''));
?>

<article class="important-card module-feed-timetable-card">
    <header class="module-feed-timetable-card__header">
        <span class="module-feed-timetable-card__day">
            <i class="fa-regular fa-calendar-days" aria-hidden="true"></i>
            <?= e($dayLabel !== '' ? $dayLabel : 'Dzień treningu') ?>
        </span>

        <span class="module-feed-timetable-card__label">Grafik zajęć</span>
    </header>

    <div
        class="module-feed-timetable-card__time"
        aria-label="Godziny zajęć: od <?= e($start) ?> do <?= e($end) ?>"
    >
        <time datetime="<?= e($start) ?>"><?= e($start) ?></time>
        <span aria-hidden="true">
            <i class="fa-solid fa-arrow-right-long"></i>
        </span>
        <time datetime="<?= e($end) ?>"><?= e($end) ?></time>
    </div>

    <div class="module-feed-timetable-card__content">
        <p>Grupa treningowa</p>
        <h3><?= e($group !== '' ? $group : 'Trening karate') ?></h3>

        <div class="module-feed-timetable-card__location">
            <span aria-hidden="true">
                <i class="fa-solid fa-location-dot"></i>
            </span>

            <div>
                <strong><?= e($city !== '' ? $city : 'Lokalizacja') ?></strong>

                <?php if ($place !== ''): ?>
                    <small><?= e($place) ?></small>
                <?php endif ?>
            </div>
        </div>
    </div>
</article>
