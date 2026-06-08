<?php
$currentPage = $params['page'] ?? 'start';

$mainNavItems = [
    'start' => ['label' => 'Strona główna', 'href' => '/'],
    'news' => ['label' => 'Aktualności', 'href' => '/aktualnosci'],
    'timetable' => ['label' => 'Grafik zajęć', 'href' => '/grafik'],
    'gallery' => ['label' => 'Galeria', 'href' => '/galeria'],
    'fees-info' => ['label' => 'Składki', 'href' => '/skladki'],
    'contact' => ['label' => 'Kontakt', 'href' => '/kontakt'],
];

$karatePages = ['oyama', 'dojo-oath', 'requirements', 'statute'];
?>

<div class="nav-container-full-screen site-desktop-nav">
    <a class="site-brand" href="/" aria-label="Strona główna Karate Kyokushin Wejherowo / Reda">
        <span class="site-brand__icons" aria-hidden="true">
            <img class="site-brand__emblem" src="/public/images/logo.png" alt="">
            <img class="site-brand__calligraphy" src="/public/images/logo.gif" alt="">
        </span>
        <span class="site-brand__text">
            <strong>
                <span>Karate</span>
                <span>Kyokushin</span>
            </strong>
            <small>Wejherowo / Reda</small>
        </span>
    </a>

    <nav class="site-desktop-nav__links" aria-label="Główna nawigacja">
        <ul>
            <?php foreach ($mainNavItems as $page => $item): ?>
                <li>
                    <a
                        class="<?= $currentPage === $page ? 'is-active' : '' ?>"
                        href="<?= e($item['href']) ?>"
                    >
                        <?= e($item['label']) ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <li class="site-desktop-nav__dropdown">
                <button
                    class="<?= in_array($currentPage, $karatePages, true) ? 'is-active' : '' ?>"
                    type="button"
                >
                    Karate <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                </button>
                <div class="site-desktop-nav__dropdown-menu">
                    <a href="/oyama">Matsutatsu Oyama</a>
                    <a href="/dojo-oath">Przysięga Dojo</a>
                    <a href="/wymagania-egzaminacyjne">Wymagania egzaminacyjne</a>
                    <a href="/status">Regulamin</a>
                </div>
            </li>
        </ul>
    </nav>

    <a class="site-nav-cta" href="/zapisy">
        Zapisz się <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
    </a>
</div>
