<?php
	$params = $params['content'];
	$counter = 0;
?>

<div class="respons-container padding-top">
	<?php 
		$text = 'Grafik Zajęć';
		require('templates/components/post_header.php');
	?>

	<div class="timetable">
		<div class="time-content flex-item-center">
			<?php foreach($params ?? [] as $content): ?>
				<?php if($content['status']): ?>
					<div class="time-box">
						<p class="day"><?php echo $content['day']; ?>.</p>
						<span><?php if($counter++ == 0 ) echo '<div class="time-line"></div>' ?></span>
						<div class="box-container">
							<div class="box-content">
								<h3><?php echo $content['city'] ?> <a href="#addresses">adres</a></h3>
								<p><i class="fa-regular fa-clock"></i> <?php echo $content['start']. ' - '. $content['end']; ?></p>
								<p><?php echo $content['advancement_group']; ?></p>
								<p style="font-weight: 100;"> <?php echo $content['place']; ?></p>
							</div>
						</div>
					</div>
					<br><br>
				<?php endif ?>
			<?php endforeach ?>
		</div>	
		<br><br><br>
		<?php 
			$text = "Adresy";
			require('templates/components/post_header.php');
		?>
		<div id="addresses" class="addresses margin-auto">
			<div class="flex-item-center">
				<span></span>
				<p>Wejherowo - Szkoła Podstawowa nr 8 ul Nanicka 22 (sala pod basenem).</p>
			</div>
			<div class="flex-item-center">
				<span></span>
				<p>Reda Szkoła Podstawowa nr 4 ul.Łąkowa 36/38 (Łącznik).</p>
			</div>
			<div class="flex-item-center">
				<span></span>
				<p>Reda Szkoła Podstawowa nr 6 ul. Gniewowska 33 (sala gimnastyczna).</p>
			</div>
			<div class="flex-item-center">
				<span></span>
				<p>Rekowo Dolne Szkoła Podstawowa nr 5 ul. Rekowska 36</p>
			</div>
		</div>
	</div>
</div>