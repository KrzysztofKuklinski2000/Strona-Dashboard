<?php 
	$content = $params['content'];
?>

<div class="camp-header">
	<div>
		<h2><?php echo $content['city'] ?></h2>
		<p>Zapraszamy na obóz karate i kolonie do <?php echo $content['guesthouse'] ?>.</p>
	</div>
</div>
<div style="padding:0px" class="respons-container">
	<br><br>
	<div class="off-header">
		<?php 
			$text = $content['city'];
			require('templates/components/post_header.php');
		?>
	</div>
	<div>
		<p class="p1">Zapraszamy na obóz karate i kolonie do <?php echo $content['guesthouse']; ?>. <br><br></p>
		<div class="detail-info">
			<strong>Termin obozu - <?php echo $content['date_start']. ' - '. $content['date_end']; ?></strong><br>
			<strong>Wyjazd <?php echo $content['date_start'] . ' godz '. $content['time_start'] . ' ' . $content['city_start']; ?></strong><br>
			<strong>Powrót <?php echo $content['date_end'] . ' godz '. $content['time_end'] . ' ' . $content['city_start']; ?></strong>
		</div>
		<br>
		<br>
		<p>
			Uczestnikami obozu, poza członkami Klubu, mogą być: osoby niezrzeszone  które nie uprawiały sportów walki / osobne zajęcia dla początkujących /od 8 roku życia, dorośli i rodzice. <br><br>
			Uczestnikami kolonii  mogą być:  młodzież i dzieci w wieku 8-18 lat nie biorące udziału w treningach karate ( grupa kolonijna ) dla których zostanie opracowany osobny plan zajęć ( gry i zabawy zespołowe)<br><br>
			Organizatorem jest  Klub Karate Kyokushin i  Sportów Walki w Wejherowie we współpracy z <?php echo $content['place']; ?>
		</p>
	</div>
	<br><br><br>
	<div class="nt">
		<div>
			<?php 
				$text = 'Zapewniamy';
				require('templates/components/post_header.php');
			 ?>
			 <br>
			<p>
				<?php echo $content['accommodation']; ?> <br><br>
				<?php echo $content['meals']; ?> <br><br>
				<?php echo $content['trips']; ?> <br><br>
				<?php echo $content['staff']; ?> <br><br>
				<?php echo $content['transport'] ?> <br><br>
				<?php echo $content['training'] ?><br><br>
				<?php echo $content['insurance']; ?> 
			</p>
		</div>
	<br><br>
		<div>
			<?php 
				$text = 'Koszta';
				require('templates/components/post_header.php');
			?>
			<br>
			
			<strong>Koszta obozu <?php echo $content['cost']; ?>zł plus koszt dojazdu.</strong> <br><br>

			<p>
				Tytułem rezerwacji należy wpłacić zaliczkę wysokości   <?php echo $content['advancePayment'] ?> zł,- od osoby do 
				<?php echo $content['advanceDate'] ?>.r, na konto Klubu Karate Kyokushin i Sportów Walki , pozostałą kwotę w czerwcu. <br><br>
				Millennium  10 1160 2202 0000 0000 7303 8229 , lub u trenera.
				Koordynator: mgr inż. Krzysztof Kukliński tel. 518844843
			</p>
		<br><br>
			<?php 
				$text = 'Uczestnicy';
				require('templates/components/post_header.php');
			?>
			<br>
			<p>
				Uczestnikami obozu, poza członkami Klubu, mogą być: osoby niezrzeszone  które nie uprawiały sportów walki / osobne zajęcia dla początkujących /od 8 roku życia, dorośli i rodzice. <br><br>
				Uczestnikami kolonii  mogą być:  młodzież i dzieci w wieku 8-18 lat nie biorące udziału w treningach karate ( grupa kolonijna ) dla których zostanie opracowany osobny plan zajęć ( gry i zabawy zespołowe) <br><br>
				Organizatorem jest  Klub Karate Kyokushin i  Sportów Walki w Wejherowie we współpracy z <?php echo $content['place']; ?>.
			</p>	
		</div>
	</div>
</div>