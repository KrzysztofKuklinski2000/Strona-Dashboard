<!DOCTYPE html>
<html lang='pl'>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="public/style.css">
	<link rel="stylesheet" type="text/css" href="public/style-res.css">
	<link rel="icon" type="image/x-icon" href="public/images/logo.png">
	<script src="https://kit.fontawesome.com/062ebc24f8.js" crossorigin="anonymous"></script>
	
	<title>
	 <?php switch($params['page']): case 'camp-info': ?>
				Obozy
			<?php break;  case 'contact' :?>
				Kontakt
			<?php break; case 'dojo-oath' : ?>
				Przysięga DoJo
			<?php break; case 'entries-info': ?>
				Zapisy
			<?php break; case 'fees-info': ?>
				Opłaty
			<?php break; case 'gallery': ?>
				Galeria
			<?php break; case 'news': ?>
				Aktualności
			<?php break; case 'oyama': ?>
				Matsutatsu Oyama
			<?php break; case 'requirements': ?>
				Wymagania Egzaminacyjne
			<?php break; case 'statute': ?>
				Regulamin
			<?php break; case 'timetable': ?>
				Grafik
			<?php break; default : ?>
				Strona Główna
		<?php endswitch; ?>
		- Klub Karate Kyokushin Wejherowo
	</title>
</head>
<body>
	<!-- menu na urządzenia mobilne -->
	<?php require_once('components/manu_for_mobile.php') ?>

	<header>
		<?php 
			require_once('components/navigation.php');
			require_once('components/navigation_full_screen.php');
			
			if($params['page'] === 'start'){
				require_once('components/header.php'); 
			}else {
				require_once('components/subpage_header.php');
			}
		?>
	</header>

	<main>
		<?php require_once('pages/'.$params['page'].'.php') ?>
	</main>


	<footer>
		<?php require_once('components/footer.php') ?>
	</footer>

	<script type="text/javascript" src="public/js/main.js"></script>
</body>
</html>

