<!DOCTYPE html>
<html lang='pl'>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="content=" Szkoła sztuk walki zaprasza na naukę karate kyokushin oraz samoobronę dla kobiet. Organizujemy obozy sportowe i kolonie dla dzieci i młodzieży - Wejherowo - Reda - Prowadzi zajęcia Pilates - Organizujemy warsztaty taneczne - Prowadzimy szkolenia dla firm - Pomorskie"">
	<link rel="stylesheet" type="text/css" href="/public/style.css">
	<link rel="stylesheet" type="text/css" href="/public/style-res.css">
	<link rel="icon" type="image/x-icon" href="/public/images/logo.png">
	<script src="https://kit.fontawesome.com/062ebc24f8.js" crossorigin="anonymous"></script>
	<?php
	$page = $params['page'];
	switch ($page):
		case 'camp-info':
			$canonical = 'obozy';
			break;
		case 'contact':
			$canonical = 'kontakt';
			break;
		case 'dojo-oath':
			$canonical = 'przysiega-do-jo';
			break;
		case 'entries-info':
			$canonical = 'zapisy';
			break;
		case 'gallery':
			$canonical = 'galeria';
			break;
		case 'news':
			$canonical = 'aktualnosci';
			break;
		case 'oyama':
			$canonical = 'oyama';
			break;
		case 'requirements':
			$canonical = 'wymagania';
			break;
		case 'statute':
			$canonical = 'regulamin';
			break;
		case 'timetable':
			$canonical = 'grafik';
			break;
		case 'fees-info':
			$canonical = 'skladki';
			break;
		default:
			$canonical = 'start';
	endswitch;
	?>
	<link rel="canonical" href="http://karatetestkyokushin.atwebpages.com/<?= $canonical ?>" />
	<title>
		<?php switch ($params['page']):
			case 'camp-info': ?>
				Obozy
			<?php break;
			case 'contact': ?>
				Kontakt
			<?php break;
			case 'dojo-oath': ?>
				Przysięga DoJo
			<?php break;
			case 'entries-info': ?>
				Zapisy
			<?php break;
			case 'fees-info': ?>
				Składki
			<?php break;
			case 'gallery': ?>
				Galeria
			<?php break;
			case 'news': ?>
				Aktualności
			<?php break;
			case 'oyama': ?>
				Matsutatsu Oyama
			<?php break;
			case 'requirements': ?>
				Wymagania Egzaminacyjne
			<?php break;
			case 'statute': ?>
				Regulamin
			<?php break;
			case 'timetable': ?>
				Grafik
			<?php break;
			default: ?>
				Strona Główna
		<?php endswitch; ?>
		- Klub Karate Kyokushin Wejherowo
	</title>
</head>

<body>
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

	<script type="text/javascript" src="public/js/main.js"></script>
</body>

</html>