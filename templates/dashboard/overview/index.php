<?php
declare(strict_types=1);

$pageViews = $params['data']['pageViews'] ?? [];
$viewsByPath = $params['data']['viewsByPath'] ?? [];
$viewsByDay = $params['data']['viewsByDay'] ?? [];

$pageLabels = [
        '/' => 'Strona główna',
        '/aktualnosci' => 'Aktualności',
        '/grafik' => 'Grafik zajęć',
        '/galeria' => 'Galeria',
        '/galeria/training' => 'Galeria treningów',
        '/galeria/camp' => 'Galeria obozów',
        '/obozy' => 'Obozy',
        '/skladki' => 'Składki',
        '/zapisy' => 'Zapisy',
        '/kontakt' => 'Kontakt',
        '/status' => 'Statut',
        '/oyama' => 'Masutatsu Oyama',
        '/dojo-oath' => 'Przysięga dojo',
        '/wymagania-egzaminacyjne' => 'Wymagania egzaminacyjne',
];

$highestPathViewCount = $viewsByPath === [] ? 0 : (int) max($viewsByPath);

$statistics = [
        [
                'label' => 'Wszystkie odsłony',
                'description' => 'Od początku pomiaru',
                'value' => (int) ($pageViews['total']['views'] ?? 0),
                'percentageChange' => $pageViews['total']['percentageChange'] ?? null,
                'comparisonLabel' => null,
                'icon' => 'fa-solid fa-chart-line',
                'class' => 'overview-stat-card--featured',
        ],
        [
                'label' => 'Dzisiaj',
                'description' => 'Od północy',
                'value' => (int) ($pageViews['today']['views'] ?? 0),
                'percentageChange' => $pageViews['today']['percentageChange'] ?? null,
                'comparisonLabel' => 'Względem wczoraj',
                'icon' => 'fa-solid fa-calendar-day',
                'class' => '',
        ],
        [
                'label' => 'Ostatnie 7 dni',
                'description' => 'Łącznie z dzisiaj',
                'value' => (int) ($pageViews['last7Days']['views'] ?? 0),
                'percentageChange' => $pageViews['last7Days']['percentageChange'] ?? null,
                'comparisonLabel' => 'Względem poprzednich 7 dni',
                'icon' => 'fa-solid fa-calendar-week',
                'class' => '',
        ],
        [
                'label' => 'Ostatnie 30 dni',
                'description' => 'Łącznie z dzisiaj',
                'value' => (int) ($pageViews['last30Days']['views'] ?? 0),
                'percentageChange' => $pageViews['last30Days']['percentageChange'] ?? null,
                'comparisonLabel' => 'Względem poprzednich 30 dni',
                'icon' => 'fa-solid fa-calendar-days',
                'class' => '',
        ],
];
?>

<h3 class="dashboard-action-header">Podsumowanie</h3>

<section class="overview-dashboard" aria-labelledby="overview-page-views-heading">
    <div class="overview-dashboard__heading">
        <div>
            <span>Ruch na stronie</span>
            <h4 id="overview-page-views-heading">Statystyki odwiedzin</h4>
        </div>
        <p>Dane zarejestrowane na publicznej części strony.</p>
    </div>

    <div class="overview-stats-grid">
        <?php foreach ($statistics as $statistic): ?>
            <article class="overview-stat-card <?= $statistic['class'] ?>">
                <div class="overview-stat-card__top">
                    <div class="overview-stat-card__icon" aria-hidden="true">
                        <i class="<?= $statistic['icon'] ?>"></i>
                    </div>
                    <span class="overview-stat-card__label"><?= $statistic['label'] ?></span>
                </div>

                <div>
                    <strong class="overview-stat-card__value">
                        <?= number_format($statistic['value'], 0, ',', ' ') ?>
                    </strong>
                    <p class="overview-stat-card__description"><?= $statistic['description'] ?></p>
                    <?php if($statistic['comparisonLabel'] !== null): ?>
                        <?php $change = $statistic['percentageChange']; ?>

                        <?php if($change === null): ?>
                            <div class="overview-stat-card__trend overview-stat-card__trend--unavailable">
                                Brak danych do porównania
                            </div>
                        <?php else: ?>
                            <?php
                                if($change > 0) {
                                    $trendClass = 'overview-stat-card__trend--positive';
                                    $trendIcon = 'fa-arrow-trend-up';
                                }else if ($change < 0) {
                                    $trendClass = 'overview-stat-card__trend--negative';
                                    $trendIcon = 'fa-arrow-trend-down';
                                }else {
                                    $trendClass = 'overview-stat-card__trend--neutral';
                                    $trendIcon = 'fa-minus';
                                }
                            ?>

                            <div class="overview-stat-card__trend <?= $trendClass ?>">
                                <i class="fa-solid <?= $trendIcon ?>" aria-hidden="true"></i>

                                <strong>
                                    <?= $change > 0 ? '+' : '' ?>
                                    <?= number_format($change, 1, ',', ' ') ?>%
                                </strong>

                                <span><?= $statistic['comparisonLabel'] ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <section class="overview-chart" aria-labelledby="overview-chart-title">
        <div class="overview-dashboard__heading overview-chart__heading">
            <div>
                <span>Ostatnie 30 dni</span>
                <h4 id="overview-chart-title">Odsłony w czasie</h4>
            </div>
            <p>Dzienna liczba odsłon publicznej części strony.</p>
        </div>

        <div class="overview-chart__canvas">
            <canvas
                    id="overview-views-chart"
                    role="img"
                    aria-label="Wykres dziennej liczby odsłon z ostatnich 30 dni"
            >
                Twoja przeglądarka nie obsługuje wykresów
            </canvas>
        </div>
    </section>


    <details class="overview-page-views" data-overview-page-views open>
        <summary class="overview-page-views__summary" data-overview-page-views-toggle>
            <span class="overview-page-views__heading">
                <span>Podstrony</span>
                <strong>Odsłony według strony</strong>
            </span>
            <span class="overview-page-views__description">
                Wszystkie zarejestrowane adresy, od najczęściej odwiedzanych.
            </span>
            <span class="overview-page-views__toggle" aria-hidden="true">
                <i class="fa-solid fa-chevron-down"></i>
            </span>
        </summary>

        <div class="overview-page-views__content" data-overview-page-views-content>
            <?php if ($viewsByPath === []): ?>
                <div class="overview-page-views__empty">
                    <i class="fa-regular fa-chart-bar" aria-hidden="true"></i>
                    <p>Brak zarejestrowanych odsłon podstron.</p>
                </div>
            <?php else: ?>
                <div class="overview-page-views__list">
                    <?php foreach ($viewsByPath as $path => $count): ?>
                        <?php
                        $count = (int) $count;
                        $share = $highestPathViewCount > 0
                                ? (int) round(($count / $highestPathViewCount) * 100)
                                : 0;
                        ?>
                        <article class="overview-page-view">
                            <div class="overview-page-view__identity">
                                <span class="overview-page-view__icon" aria-hidden="true">
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                </span>
                                <div>
                                    <strong><?= e($pageLabels[$path] ?? $path) ?></strong>
                                    <span><?= e($path) ?></span>
                                </div>
                            </div>

                            <div class="overview-page-view__bar" aria-hidden="true">
                                <span style="width: <?= $share ?>%"></span>
                            </div>

                            <div class="overview-page-view__count">
                                <strong><?= number_format($count, 0, ',', ' ') ?></strong>
                                <span>odsłon</span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </details>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.1/chart.umd.min.js"
        integrity="sha512-WoViKhKD4qI2WruSZqv9+kvM4WfFhUMQCLN4QlDTt5aU56fLQy2gYoxWIqlEnXqJy/+Ac5q/hk1oWfqnMDhwMA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="application/json" id="overview-views-data">
        <?=
    json_encode($viewsByDay, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)
    ?>

</script>

<script src="/public/dashboard/overview-chart.js"></script>
