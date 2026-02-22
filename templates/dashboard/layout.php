<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/templates/dashboard/public/style.css">
	<script src="https://kit.fontawesome.com/062ebc24f8.js" crossorigin="anonymous"></script>
	<title>Panel Administracyjny - Karate Kyokushin</title>
</head>

<body>
	<?php if (isset($params['flash']) && in_array($params['flash']['type'], ['success', 'info', 'warning'])): ?>
		<div class="flash <?= htmlspecialchars($params['flash']['type']) ?>">
			<?= $params['flash']['message'] ?>
			<i class="flash-close fa-solid fa-xmark"></i>
		</div>
	<?php endif ?>
	<header>
		<h2><i style="margin-right: 10px;" class="fa-solid fa-gear"></i>Panel Administracyjny</h2>
	</header>
	<div class="container">
		<?php if (!in_array($params['page'], ['login', 'register'])): ?>
			<aside>
				<ul>
					<a href="/dashboard/start">
						<i class="fa-solid fa-house"></i>
						<p>Strona Główna</p>
					</a>

					<a href="/dashboard/important_posts">
						<i class="fa-solid fa-exclamation"></i>
						<p>Ważne Info</p>
					</a>

					<a href="/dashboard/timetable">
						<i class="fa-regular fa-calendar"></i>
						<p>Grafik</p>
					</a>

					<a href="/dashboard/news">
						<i class="fa-solid fa-info"></i>
						<p>Aktualności</p>
					</a>

					<a href="/dashboard/gallery">
						<i class="fa-solid fa-image"></i>
						<p>Galeria</p>
					</a>

					<a href="/dashboard/camp">
						<i class="fa-solid fa-campground"></i>
						<p>Obozy</p>
					</a>

					<a href="/dashboard/fees">
						<i class="fa-solid fa-money-check-dollar"></i>
						<p>Składki</p>
					</a>
					<a href="/dashboard/contact">
						<i class="fa-regular fa-address-book"></i>
						<p>Kontakt</p>
					</a>
					<a href="/auth/logout">
						<i class="fa-solid fa-arrow-right-from-bracket"></i>
						<p>Wyloguj</p>
					</a>
				</ul>
			</aside>
		<?php endif; ?>
		<main>
			<div class="<?= $params['page'] !== 'login' ? 'content-container' : ''?>">
				<?php require_once('templates/dashboard/' . $params['page'] . '.php'); ?>
			</div>
		</main>
	</div>
</body>
<?php if (isset($params['flash']) && in_array($params['flash']['type'], ['success', 'info', 'warning'])): ?>
	<script src="/templates/dashboard/public/main.js"></script>
<?php endif; ?>

</html>