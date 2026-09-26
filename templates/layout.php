<!DOCTYPE html>
<html lang='pl'>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Szkoła sztuk walki zaprasza na naukę karate kyokushin oraz samoobronę dla kobiet. Organizujemy obozy sportowe i kolonie dla dzieci i młodzieży - Wejherowo - Reda - Prowadzi zajęcia Pilates - Organizujemy warsztaty taneczne - Prowadzimy szkolenia dla firm - Pomorskie">
	<link rel="stylesheet" type="text/css" href="/public/style.css">
	<link rel="stylesheet" type="text/css" href="/public/style-res.css">
	<link rel="icon" type="image/x-icon" href="/public/images/logo.png">
	<script src="https://kit.fontawesome.com/062ebc24f8.js" crossorigin="anonymous"></script>
    <?php
    $page = $params['page'] ?? 'homepage';

    $canonicalPath = match ($page) {
        'camp-info' => '/obozy',
        'contact' => '/kontakt',
        'dojo-oath' => '/dojo-oath',
        'entries-info' => '/zapisy',
        'fees-info' => '/skladki',
        'gallery' => '/galeria',
        'news' => '/aktualnosci',
        'news_details' => '/aktualnosci/wpis/' . (int) ($params['content']->id ?? 0),
        'oyama' => '/oyama',
        'requirements' => '/wymagania-egzaminacyjne',
        'statute' => '/status',
        'timetable' => '/grafik',
        default => '/',
    };

    $baseUrl = rtrim((string) ($params['base_url'] ?? ''), '/');
    $canonicalUrl = $baseUrl . $canonicalPath;
    ?>
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
	<title>
		<?php
		echo match ($page) {
			'camp-info' => 'Obóz',
			'contact' => 'Kontakt',
			'dojo-oath' => 'Przysięga Dojo',
			'entries-info' => 'Zapisy',
			'fees-info' => 'Składki',
			'gallery' => 'Galeria',
			'news' => 'Aktualności',
			'news_details' => (string) ($params['content']->title ?? 'Aktualność'),
			'oyama' => 'Matsutatsu Oyama',
			'requirements' => 'Wymagania Egzaminacyjne',
			'statute' => 'Regulamin',
			'timetable' => 'Grafik zajęć',
			default => 'Strona Główna'
		};
		?>
		- Klub Karate Kyokushin Wejherowo
	</title>
</head>

<body<?= $page === 'homepage' ? ' class="homepage"' : '' ?>>
	<?php if (isset($params['flash_public'])): ?>
		<?php
		$flash = $params['flash_public'];
		$flashType = $flash['type'] ?? 'info';

		if (!in_array($flashType, ['success', 'info', 'warning'], true)) {
			$flashType = 'info';
		}

		$flashDetails = match ($flashType) {
			'success' => [
				'title' => 'Gotowe',
				'icon' => 'fa-solid fa-check',
			],
			'warning' => [
				'title' => 'Uwaga',
				'icon' => 'fa-solid fa-exclamation',
			],
			default => [
				'title' => 'Informacja',
				'icon' => 'fa-solid fa-info',
			],
		};
		?>
		<?php if (is_string($flash['message'] ?? null)): ?>
			<div class="site-toast-region" aria-live="polite" aria-atomic="true">
				<div
					class="site-toast site-toast--<?= e($flashType) ?>"
					data-site-toast
					role="<?= $flashType === 'warning' ? 'alert' : 'status' ?>"
				>
					<span class="site-toast__icon" aria-hidden="true">
						<i class="<?= e($flashDetails['icon']) ?>"></i>
					</span>
					<div class="site-toast__content">
						<strong><?= e($flashDetails['title']) ?></strong>
						<p><?= e($flash['message']) ?></p>
					</div>
					<button class="site-toast__close" type="button" data-site-toast-close aria-label="Zamknij komunikat">
						<i class="fa-solid fa-xmark" aria-hidden="true"></i>
					</button>
				</div>
			</div>
		<?php endif ?>
	<?php endif ?>
	<!-- menu na urządzenia mobilne -->
	<?php require_once('components/mobile_menu.php') ?>

	<header>
		<?php
		require_once('components/navigation.php');
		require_once('components/navigation_full_screen.php');

		if ($params['page'] === 'homepage') {
			require_once('components/header.php');
		} else {
			require_once('components/subpage_header.php');
		}
		?>
	</header>

	<main>
		<?php require_once('pages/' . $params['page'] . '.php') ?>
	</main>


	<footer>
		<?php require_once('components/footer.php') ?>
	</footer>

	<script type="text/javascript" src="/public/js/main.js"></script>
	<script type="text/javascript" src="/public/js/nav-indicator.js"></script>
</body>

</html>
