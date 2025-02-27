<?php $content = $params['content'];?>

<p style="width: 100px; height:2px; background: #FF3366; margin: 30px auto;"></p>
<div class="respons-container">
	<p class='price-content'>Na zajęcia Karate Kyokushin można zapisywać się przez cały rok. Wystarczy skontaktować się z nami telefonicznie lub wysłać wiadomość na adres e-mail. Pierwsze zajęcia są    ZA DARMO.</p>
	<div class="price-list">
		<div class="table">
			<h3>Składka miesieczna</h3>
			<div class="row flex-center">
				<div class="flex-center">Składka ulgowa <br/> (jedna osoba) </div>
				<div class="flex-center">Składka ulgowa <br/> (dwie osoby)</div>
				<div class="flex-center">Składka ulgowa <br/> (trzy i więcej osób)</div>
			</div>
			<div class="row flex-center" style="font-weight: 700; border-top:1px solid #282E39">
				<div class="flex-center" style="color:#333;"><?php echo $content['reduced_contribution_1_month'] ?>zł/msc </div>
				<div class="flex-center" style="color:#333;"><?php echo $content['reduced_contribution_2_month'] ?>zł/msc</div>
				<div class="flex-center" style="color:#333;"><?php echo $content['family_contribution_month'] ?>zł/msc</div>
			</div>
		</div>
		<br>
		<div class="table">
			<h3>Składka roczna</h3>
			<div class="row flex-center">
				<div class="flex-center">Składka ulgowa <br/> (jedna osoba) </div>
				<div class="flex-center">Składka ulgowa <br/> (dwie osoby)</div>
				<div class="flex-center">Składka ulgowa <br/> (trzy i więcej osób)</div>
			</div>
			<div class="row flex-center" style="font-weight: 700; border-top:1px solid #282E39">
				<div class="flex-center" style="color:#333;"><?php echo $content['reduced_contribution_1_year'] ?>zł/msc </div>
				<div class="flex-center" style="color:#333;"><?php echo $content['reduced_contribution_2_year'] ?>zł/msc</div>
				<div class="flex-center" style="color:#333;"><?php echo $content['family_contribution_year'] ?>zł/msc</div>
			</div>
		</div>
		<br>
	</div>
	<a class="price-btn" href="?view=oplaty">
		<div class="flex-item-center margin-auto">
			<p style="color:white;">Więcej o <br> składkach</p> 
			<i style="color:white;" class="fa-solid fa-angle-right"></i>
		</div>
	</a>
</div>