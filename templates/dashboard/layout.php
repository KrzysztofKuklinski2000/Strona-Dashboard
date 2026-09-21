<?php
$currentPage = (string) ($params['page'] ?? '');
$isAuthPage = in_array($currentPage, ['login', 'register'], true);
$activeModule = explode('/', $currentPage)[0];

$navigationItems = [
    ['module' => 'overview', 'label' => 'Podsumowanie', 'url' => '/dashboard', 'icon' => 'fa-solid fa-chart-line'],
    ['module' => 'homepage', 'label' => 'Strona główna', 'url' => '/dashboard/homepage', 'icon' => 'fa-solid fa-house'],
    ['module' => 'important_posts', 'label' => 'Ważne informacje', 'url' => '/dashboard/important_posts', 'icon' => 'fa-solid fa-exclamation'],
    ['module' => 'timetable', 'label' => 'Grafik', 'url' => '/dashboard/timetable', 'icon' => 'fa-regular fa-calendar'],
    ['module' => 'news', 'label' => 'Aktualności', 'url' => '/dashboard/news', 'icon' => 'fa-regular fa-newspaper'],
    ['module' => 'gallery', 'label' => 'Galeria', 'url' => '/dashboard/gallery', 'icon' => 'fa-regular fa-image'],
    ['module' => 'camp', 'label' => 'Obozy', 'url' => '/dashboard/camp', 'icon' => 'fa-solid fa-campground'],
    ['module' => 'fees', 'label' => 'Składki', 'url' => '/dashboard/fees', 'icon' => 'fa-solid fa-money-check-dollar'],
    ['module' => 'contact', 'label' => 'Kontakt', 'url' => '/dashboard/contact', 'icon' => 'fa-regular fa-address-book'],
    ['module' => 'subscribers', 'label' => 'Subskrybenci', 'url' => '/dashboard/subscribers', 'icon' => 'fa-regular fa-bell'],
];
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/dashboard/style.css">
    <script src="https://kit.fontawesome.com/062ebc24f8.js" crossorigin="anonymous"></script>
    <title>Panel Administracyjny - Karate Kyokushin</title>
</head>

<body>
<?php if (isset($params['flash_dashboard'])): ?>
    <?php
    $flash = $params['flash_dashboard'];
    ?>
    <?php if (is_string($flash['message'])): ?>
        <div class="flash <?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['message']) ?>
            <i class="flash-close fa-solid fa-xmark"></i>
        </div>
    <?php endif; ?>
<?php endif; ?>
<header class="dashboard-header">
    <a class="dashboard-header__brand" href="/dashboard">
        <span class="dashboard-header__brand-icon" aria-hidden="true">
            <i class="fa-solid fa-gear"></i>
        </span>
        <span>
            <small>Karate Kyokushin</small>
            <strong>Panel administracyjny</strong>
        </span>
    </a>

    <a class="dashboard-header__site-link" href="/" target="_blank" rel="noopener noreferrer">
        <span>Przejdź do strony</span>
        <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
    </a>
</header>
<div class="dashboard-layout">
    <?php if (!$isAuthPage): ?>
        <aside class="dashboard-sidebar">
            <nav class="dashboard-sidebar__navigation" aria-label="Nawigacja panelu administracyjnego">
                <ul class="dashboard-navigation">
                    <?php foreach ($navigationItems as $navigationItem): ?>
                        <?php $isActive = $activeModule === $navigationItem['module']; ?>
                        <li>
                            <a
                                class="dashboard-navigation__link<?= $isActive ? ' is-active' : '' ?>"
                                href="<?= e($navigationItem['url']) ?>"
                                <?= $isActive ? 'aria-current="page"' : '' ?>
                            >
                                <i class="<?= e($navigationItem['icon']) ?>" aria-hidden="true"></i>
                                <span><?= e($navigationItem['label']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <li class="dashboard-navigation__logout">
                        <form action="/auth/logout" method="POST" class="logout-form">
                            <input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">
                            <button class="dashboard-navigation__link" type="submit">
                                <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                                <span>Wyloguj</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>
    <?php endif; ?>
    <main class="dashboard-main<?= $isAuthPage ? ' dashboard-main--auth' : '' ?>">
        <div class="<?= !$isAuthPage ? 'content-container' : '' ?>">
            <?php require_once('templates/dashboard/' . $currentPage . '.php'); ?>
        </div>
    </main>
</div>
</body>
<script src="/public/dashboard/main.js"></script>

</html>
