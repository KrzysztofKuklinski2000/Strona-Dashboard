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
    $page = $params['page'] ?? 'start';

    $canonicalPath = match ($page) {
        'camp-info' => '/obozy',
        'contact' => '/kontakt',
        'dojo-oath' => '/dojo-oath',
        'entries-info' => '/zapisy',
        'fees-info' => '/skladki',
        'gallery' => '/galeria',
        'news' => '/aktualnosci',
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

<body>
	<?php if (isset($params['flash_public']) && in_array($params['flash_public']['type'], ['success', 'info', 'warning'])): ?>
		<div class="flash <?= htmlspecialchars($params['flash_public']['type']) ?>">
            <?= e($params['flash_public']['message']) ?>
			<i class="flash-close fa-solid fa-xmark"></i>
		</div>
	<?php endif ?>
	<!-- menu na urządzenia mobilne -->
	<?php require_once('components/mobile_menu.php') ?>

	<header>
		<?php
		require_once('components/navigation.php');
		require_once('components/navigation_full_screen.php');

		if ($params['page'] === 'start') {
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
</body>

</html>
