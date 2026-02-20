<?php
$content = $params['content'];
?>

<div class="respons-container padding-top">
	<div>
		<?php
		$text = 'Składka Członkowska';
		require('templates/components/post_header.php');
		?>
		<p>
			<?= $content['extra_information'] ?>
		</p>
	</div>
	<br><br>
	<?php
	$text = 'Składka Miesięczna';
	require('templates/components/post_header.php');
	?>
</div>
	<div class="price-container respons-container" id="price">
		<div class="price-box">
			<h2>Składka ulgowa</h2>
			<strong><?php echo $content['reduced_contribution_1_month']; ?>zł <br> Jedna osoba</strong>
			<p>za miesiąc</p>
			<div class="break"></div>
		</div>
		<div class="price-box">
			<h2>Składka ulgowa</h2>
			<strong><?php echo $content['reduced_contribution_2_month']; ?>zł <br> Dwie osoby</strong>
			<p>za miesiąc</p>
			<div class="break"></div>
		</div>
		<div class="price-box">
			<h2>Składka Rodzinna</h2>
			<strong><?php echo $content['family_contribution_month']; ?>zł <br> trzy i więcej osób</strong>
			<p>za miesiąc</p>
			<div class="break"></div>
		</div>
		<div class="join">
			<a class="btn-join" href="/zapisy">ZAPISZ SIĘ <i style="color:white;" class="fa-solid fa-angle-right"></i></a>
			<br><br>
		</div>
	</div>


	<br><br><br>
	<?php
	$text = 'Składka Roczna';
	require('templates/components/post_header.php');
	?>
<div class="price-container respons-container">
	<div class="price-box">
		<h2>Składka ulgowa</h2>
		<strong><?php echo $content['reduced_contribution_1_year'] ?>zł <br> Jedna osoba</strong>
		<p>za rok</p>
		<div class="break"></div>
	</div>
	<div class="price-box">
		<h2>Składka ulgowa</h2>
		<strong><?php echo $content['reduced_contribution_2_year'] ?>zł <br> Dwie osoby</strong>
		<p>za rok</p>
		<div class="break"></div>
	</div>
	<div class="price-box">
		<h2>Składka Rodzinna</h2>
		<strong><?php echo $content['family_contribution_year'] ?>zł <br> trzy i więcej osób</strong>
		<p>za rok</p>
		<div class="break"></div>
		<br>
	</div>
	<div class="join">
		<a class="btn-join" href="/zapisy">ZAPISZ SIĘ <i style="color:white;" class="fa-solid fa-angle-right"></i></a>
		<br><br>
	</div>
</div>

<div class="respons-container">
	<div>
		<br><br>
		<?php
		$text = 'Informacje Dodatkowe';
		require('templates/components/post_header.php');
		?>
		<br>
		<p>
			<?= $content['fees_information'] ?>
		</p>
	</div>
	<div>
		<br><br>
		<?php
		$text = 'Konto';
		require('templates/components/post_header.php');
		?>
		<p style="text-align: center;">
			KLUB KARATE KYOKUSHIN I SPORTÓW WALKI <br>
			Nanicka 22, 84-200 Wejherowo <br>
			<strong>
				Millennium <br>
				10 1160 2202 0000 0000 7303 8229
			</strong> <br>
			W tytule wpłaty proszę wpisać np: <i style="color:#4F4F4F">'Składka za lipiec 2024'</i>
		</p>
	</div>
</div>