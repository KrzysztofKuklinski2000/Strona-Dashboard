<?php
$page = $params['page'] ?? 'homepage';
$seo = $params['seo'] ?? \App\Seo\PublicPageMetadata::forPage(
    $params,
    (string) ($params['base_url'] ?? ''),
    false,
);
?>
<!DOCTYPE html>
<html lang='pl'>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?= e($seo['description']) ?>">
	<meta name="robots" content="<?= e($seo['robots']) ?>">
	<title><?= e($seo['title']) ?></title>
	<?php if ($seo['canonical'] !== null): ?>
		<link rel="canonical" href="<?= e($seo['canonical']) ?>">
		<meta property="og:url" content="<?= e($seo['canonical']) ?>">
	<?php endif ?>
	<meta property="og:title" content="<?= e($seo['title']) ?>">
	<meta property="og:description" content="<?= e($seo['description']) ?>">
	<meta property="og:type" content="<?= e($seo['type']) ?>">
	<meta property="og:locale" content="pl_PL">
	<meta property="og:site_name" content="<?= e(\App\Seo\PublicPageMetadata::SITE_NAME) ?>">
	<link rel="stylesheet" type="text/css" href="/style.css?v=<?= filemtime(__DIR__ . '/../public/style.css') ?>">
	<link rel="stylesheet" type="text/css" href="/style-res.css?v=<?= filemtime(__DIR__ . '/../public/style-res.css') ?>">
	<?php if (($params['page'] ?? 'homepage') === 'homepage'): ?>
		<link rel="stylesheet" href="/style-homepage.css?v=<?= filemtime(__DIR__ . '/../public/style-homepage.css') ?>">
	<?php endif ?>
	<link rel="icon" type="image/x-icon" href="/images/branding/logo.png">
	<script src="https://kit.fontawesome.com/062ebc24f8.js" crossorigin="anonymous"></script>
</head>

<body class="public-site <?= $page === 'homepage' ? 'homepage homepage--refined' : 'subpage' ?>">
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

	<script type="text/javascript" src="/js/main.js?v=<?= filemtime(__DIR__ . '/../public/js/main.js') ?>"></script>
	<script type="text/javascript" src="/js/nav-indicator.js"></script>
	<?php if (($params['page'] ?? '') === 'homepage'): ?>
		<script src="/js/hero-carousel.js?v=<?= filemtime(__DIR__ . '/../public/js/hero-carousel.js') ?>" defer></script>
	<?php endif ?>
	<?php if (($params['page'] ?? '') === 'timetable'): ?>
		<script src="/js/location-map.js" defer></script>
	<?php endif ?>
</body>

</html>
