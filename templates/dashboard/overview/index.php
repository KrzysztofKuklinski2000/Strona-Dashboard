<?php
declare(strict_types=1);

$pageViews = $params['data']['pageViews'] ?? [];
$viewsByPath = $params['data']['viewsByPath'] ?? [];

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
        'value' => (int) ($pageViews['total'] ?? 0),
        'icon' => 'fa-solid fa-chart-line',
        'class' => 'overview-stat-card--featured',
    ],
    [
        'label' => 'Dzisiaj',
        'description' => 'Od północy',
        'value' => (int) ($pageViews['today'] ?? 0),
        'icon' => 'fa-solid fa-calendar-day',
        'class' => '',
    ],
    [
        'label' => 'Ostatnie 7 dni',
        'description' => 'Łącznie z dzisiaj',
        'value' => (int) ($pageViews['last7Days'] ?? 0),
        'icon' => 'fa-solid fa-calendar-week',
        'class' => '',
    ],
    [
        'label' => 'Ostatnie 30 dni',
        'description' => 'Łącznie z dzisiaj',
        'value' => (int) ($pageViews['last30Days'] ?? 0),
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
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <section class="overview-page-views" aria-labelledby="overview-pages-heading">
        <div class="overview-dashboard__heading">
            <div>
                <span>Podstrony</span>
                <h4 id="overview-pages-heading">Odsłony według strony</h4>
            </div>
            <p>Wszystkie zarejestrowane adresy, od najczęściej odwiedzanych.</p>
        </div>

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
    </section>
</section>
