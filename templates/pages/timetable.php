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

$dayOrder = array_flip(array_keys($dayLabels));
$publishedItems = array_values(array_filter(
    $params['content'] ?? [],
    static fn($item): bool => (bool) ($item->status ?? false)
));

usort($publishedItems, static function ($first, $second) use ($dayOrder): int {
    return [
        $dayOrder[trim((string) ($first->day ?? ''))] ?? 99,
        trim((string) ($first->start ?? '')),
        trim($first->locationCity),
        trim($first->locationAddress),
    ] <=> [
        $dayOrder[trim((string) ($second->day ?? ''))] ?? 99,
        trim((string) ($second->start ?? '')),
        trim($second->locationCity),
        trim($second->locationAddress),
    ];
});

$days = [];
$locations = [];

foreach ($publishedItems as $item) {
    $dayCode = trim((string) ($item->day ?? ''));

    if ($dayCode === '') {
        continue;
    }

    $locationKey = $item->locationId;

    $days[$dayCode] ??= [
        'label' => $dayLabels[$dayCode] ?? $dayCode,
        'items' => [],
    ];

    $days[$dayCode]['items'][] = $item;

    if (!isset($locations[$locationKey])) {
        $mapUrl = trim($item->locationMapEmbedUrl);
        $mapParts = parse_url($mapUrl) ?: [];
        $mapPath = $mapParts['path'] ?? '';
        $hasValidMap = filter_var($mapUrl, FILTER_VALIDATE_URL) !== false
            && ($mapParts['scheme'] ?? '') === 'https'
            && in_array(strtolower($mapParts['host'] ?? ''), ['www.google.com', 'maps.google.com'], true)
            && ($mapPath === '/maps/embed' || str_starts_with($mapPath, '/maps/embed/'));

        $locations[$locationKey] = [
            'name' => trim($item->locationName),
            'details' => implode(', ', array_filter(
                [trim($item->locationCity), trim($item->locationAddress)],
                static fn(string $value): bool => $value !== '',
            )),
            'map_url' => $hasValidMap ? $mapUrl : '',
            'count' => 0,
        ];
    }

    $locations[$locationKey]['count']++;
}

uksort($days, static fn(string $first, string $second): int => ($dayOrder[$first] ?? 99) <=> ($dayOrder[$second] ?? 99));
?>

<section class="timetable-page" aria-labelledby="timetable-title">
    <div class="timetable-page__inner">
        <?php if ($days): ?>
            <header class="timetable-intro">
                <p>Grafik zajęć</p>
                <h2 id="timetable-title">Wybierz dzień treningu</h2>
                <span>Aktualne godziny, grupy i miejsca zajęć są pobierane z opublikowanego grafiku klubu.</span>
            </header>

            <div class="timetable-board">
                <?php foreach ($days as $day): ?>
                    <article class="timetable-day">
                        <header class="timetable-day__header">
                            <div>
                                <span>Dzień</span>
                                <h3><?= e($day['label']) ?></h3>
                            </div>
                            <strong><?= count($day['items']) ?></strong>
                        </header>

                        <div class="timetable-day__sessions">
                            <?php foreach ($day['items'] as $item): ?>
                                <article class="timetable-session">
                                    <time><?= e($item->start . ' - ' . $item->end) ?></time>

                                    <div class="timetable-session__body">
                                        <h4><?= e($item->advancementGroup) ?></h4>

                                        <p>
                                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                            <?= e($item->locationName ?: 'Lokalizacja') ?>
                                        </p>

                                        <?php if ($locations[$item->locationId]['details'] !== ''): ?>
                                            <span><?= e($locations[$item->locationId]['details']) ?></span>
                                        <?php endif ?>

                                        <?php
                                        $mapLocation = $locations[$item->locationId];
                                        require 'templates/components/location_map_link.php';
                                        ?>
                                    </div>
                                </article>
                            <?php endforeach ?>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>

            <div class="timetable-support">
                <section class="timetable-places" aria-labelledby="timetable-places-title">
                    <div class="timetable-section-heading">
                        <p>Lokalizacje</p>
                        <h2 id="timetable-places-title">Gdzie trenujemy?</h2>
                    </div>

                    <div class="timetable-places__grid">
                        <?php foreach ($locations as $location): ?>
                            <article class="timetable-place">
                                <span aria-hidden="true">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>
                                <div>
                                    <h3><?= e($location['name'] ?: 'Lokalizacja') ?></h3>

                                    <?php if ($location['details'] !== ''): ?>
                                        <p><?= e($location['details']) ?></p>
                                    <?php endif ?>

                                    <small><?= (int) $location['count'] ?> <?= ((int) $location['count']) === 1 ? 'trening' : 'treningi' ?> w grafiku</small>

                                    <?php
                                    $mapLocation = $location;
                                    require 'templates/components/location_map_link.php';
                                    ?>
                                </div>
                            </article>
                        <?php endforeach ?>
                    </div>
                </section>

                <aside class="timetable-notes" aria-labelledby="timetable-notes-title">
                    <div class="timetable-section-heading">
                        <p>Przed treningiem</p>
                        <h2 id="timetable-notes-title">Kilka ważnych informacji</h2>
                    </div>

                    <div class="timetable-notes__grid">
                        <div class="timetable-note">
                            <i class="fa-regular fa-clock" aria-hidden="true"></i>
                            <div>
                                <h3>Bądź na czas</h3>
                                <p>Przyjdź około 10 minut przed rozpoczęciem zajęć.</p>
                            </div>
                        </div>

                        <div class="timetable-note">
                            <i class="fa-solid fa-shirt" aria-hidden="true"></i>
                            <div>
                                <h3>Strój</h3>
                                <p>Weź wygodny strój sportowy albo karate-gi.</p>
                            </div>
                        </div>

                        <div class="timetable-note">
                            <i class="fa-solid fa-bottle-water" aria-hidden="true"></i>
                            <div>
                                <h3>Woda</h3>
                                <p>Pamiętaj o zabraniu wody na trening.</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        <?php else: ?>
            <div class="timetable-empty">
                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                <h2>Brak aktywnego grafiku</h2>
                <p>Aktualne godziny treningów pojawią się tutaj po opublikowaniu ich przez klub.</p>
            </div>
        <?php endif ?>
    </div>
</section>
