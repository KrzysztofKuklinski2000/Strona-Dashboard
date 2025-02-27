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
	 		Składka członkowska i miesięczna ( łącznie składka ) obowiązuje wszystkich Członków Klubu przez 12 miesięcy w roku. Zajęcia prowadzimy przez cały rok, w wakacje i ferie też. W okresie wakacji składka jest obniżona. W przypadku, gdy  członek Klubu nie uczestniczył w zajęciach np z powodu choroby, oraz w innych szczególnych wypadkach nieobecności dłuższej niż 3 tygodnie w miesiącu, może być zmniejszona na pisemny wniosek Członka ( lub rodziców/opiekunów prawnych) do wysokości 70 zł za miesiąc. Wpisowe obecnie jest zawieszone. Obowiązuje tylko przy ponownym wstąpieniu do Klubu.
	 	</p>
	</div>
 	<br><br>
	<?php 
		$text = 'Składka Miesięczna';
		require('templates/components/post_header.php');
	?>
	<div class="price-container" id="price">
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
		<div class="price-box">
			<h2>Składka Normalna</h2>
			<strong><?php echo $content['contribution']; ?>zł <br> Jedna Osoba</strong>
			<p>za miesiąc</p>
			<div class="break"></div>
		</div>
		<div class="price-box">
			<h2>Wpisowe</h2>
			<strong><?php echo $content['entry_fee']; ?>zł <br> Jedna Osoba</strong>
			<br><br>
			<div class="break"></div>
			<br>
		</div>
		<div class="join">
			<a class="btn-join" href="?view=zapisy">ZAPISZ SIĘ <i style="color:white;" class="fa-solid fa-angle-right"></i></a>
			<br><br>
		</div>
	</div>

	<br><br><br>
	<?php 
		$text = 'Składka Roczna';
		require('templates/components/post_header.php');
	?>
	<div class="price-container">
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
			<strong><?php $content['family_contribution_year'] ?>zł <br> trzy i więcej osób</strong>
			<p>za rok</p>
			<div class="break"></div>
			<br>
		</div>
		<div class="join">
			<a class="btn-join" href="?view=zapisy">ZAPISZ SIĘ <i style="color:white;" class="fa-solid fa-angle-right"></i></a>
			<br><br>
		</div>
	</div>

	<div>
		<br><br>
		<?php 
			$text = 'Informacje Dodatkowe';
			require('templates/components/post_header.php'); 
	 	?>
	 	<br>
	 	<div class="impor-info flex-item-center">
	 		<i class="fa-solid fa-circle-exclamation"></i>
	 		<p>Składki ulgowe w lipcu i sierpniu wynoszą odpowiednio: <?php echo $content['reduced_contribution_holidays'] ?>. dla osób nie biorących udziału w zajęciach</p> <br><br>
	 	</div>
	 	<br>
	 	<p>
	 		Składka za dwie osoby i rodzinna dotyczy osób pozostających w bliskim pokrewieństwie: rodzeństwo, rodzice i dzieci, małżeństwo. Składka ulgowa dotyczy płatności terminowych tj wpłaconych do 12 każdego miesiąca. Po tym terminie składki ulgowa i rodzinna, oraz obniżka składek w lipcu i sierpniu  nie obowiązują. Treningi , dla Członków Klubu są bezpłatne. Ich ilość nie jest limitowana. Każdy Członek po uiszczeniu składki może brać udział we wszystkich treningach, we wszystkich lokalizacjach, gdzie je prowadzimy. Jedynym kryterium wstępu jest stopień zaawansowania i wiek( jeśli zajęcia są skierowane do konkretnej grupy wiekowej )Składka normalna dotyczy tych członków Klubu, którzy nie opłacili składek w terminie. Nieobecność na treningach nie zwalnia z opłacania składek i skutkuje utratą ulgi.Obowiązuje trzymiesięczny okres wypowiedzenia członkostwa.
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
