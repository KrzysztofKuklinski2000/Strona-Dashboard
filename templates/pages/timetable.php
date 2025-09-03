<?php
$prevDay = null;
?>
<div class="respons-container">
	<div class="timetable-contianer">
		<div class="line flex-item-center">
			<div></div>
			<p></p>
		</div>
		<div>
			<?php foreach ($params['content'] ?? [] as $content): ?>
				<?php if ($content['status']): ?>
					<div class="timetable-day-header">
						<?php
						if ($prevDay !== trim($content['day'])) {
							switch (trim($content['day'])) {
								case 'PON':
									echo 'Poniedziałek';
									break;
								case 'WT':
									echo 'Wtorek';
									break;
								case 'ŚR':
									echo 'Środa';
									break;
								case 'CZW':
									echo 'Czwartek';
									break;
								case 'PT':
									echo 'Piątek';
									break;
								case 'SOB':
									echo 'Sobota';
									break;
								case 'NIEDZ':
									echo 'Niedziela';
									break;
							}
							$prevDay = $content['day'];
						}
						?>
					</div>
					<div class="timetable-box">
						<div class="timetable-line"></div>
						<div class="box-content">
							<div>
								<h3><?= $content['city'] ?> </h3>
								<a href="#addresses">adres</a>
							</div>
							<p><i class="fa-regular fa-clock"></i> <?= $content['start'] . ' - ' . $content['end']; ?></p>
							<p>Grupa: <?= $content['advancement_group']; ?></p>
							<p style="font-weight: 100;"> <?= $content['place']; ?></p>
						</div>
					</div>
				<?php endif ?>
			<?php endforeach; ?>
		</div>
	</div>
	<br><br>
	<?php
	$text = "Adresy";
	require('templates/components/post_header.php');
	?>
	<div id="addresses" class="addresses margin-auto">
		<div class="flex-item-center">
			<span></span>
			<p>Wejherowo - Szkoła Podstawowa nr 8 ul Nanicka 22 (sala pod basenem).
				<a href="https://www.google.pl/maps/place/Szko%C5%82a+Podstawowa+nr+8/@54.6088828,18.2355575,17z/data=!3m1!4b1!4m6!3m5!1s0x46fdba28b18c18dd:0x293cbc2af65de10f!8m2!3d54.6088828!4d18.2381324!16s%2Fg%2F1tr7bhqj?entry=ttu&g_ep=EgoyMDI1MDQyMy4wIKXMDSoASAFQAw%3D%3D">link</a>

			</p>
		</div>
		<div class="flex-item-center">
			<span></span>
			<p>Reda Szkoła Podstawowa nr 4 ul.Łąkowa 36/38 (Łącznik).
				<a href="https://www.google.pl/maps/place/Szko%C5%82a+Podstawowa+nr+4+im.+Kazimierza+Pruszkowskiego+w+Redzie/@54.602192,18.3544579,17z/data=!4m14!1m7!3m6!1s0x46fdbab6229d70c9:0xf16e804e941c5d7!2sSzko%C5%82a+Podstawowa+nr+4+im.+Kazimierza+Pruszkowskiego+w+Redzie!8m2!3d54.602192!4d18.3570328!16s%2Fg%2F11d_7w7x0w!3m5!1s0x46fdbab6229d70c9:0xf16e804e941c5d7!8m2!3d54.602192!4d18.3570328!16s%2Fg%2F11d_7w7x0w?entry=ttu&g_ep=EgoyMDI1MDQyMy4wIKXMDSoASAFQAw%3D%3D">link</a>
			</p>
		</div>
		<div class="flex-item-center">
			<span></span>
			<p>Reda Szkoła Podstawowa nr 6 ul. Gniewowska 33 (sala gimnastyczna).
				<a href="https://www.google.pl/maps/place/Szko%C5%82a+Podstawowa+nr+6/@54.596203,18.341577,17z/data=!4m14!1m7!3m6!1s0x46fdbac508e7e947:0x1d9f432b47e1fe9d!2sSzko%C5%82a+Podstawowa+nr+6!8m2!3d54.596203!4d18.3441519!16s%2Fg%2F1tj99pyj!3m5!1s0x46fdbac508e7e947:0x1d9f432b47e1fe9d!8m2!3d54.596203!4d18.3441519!16s%2Fg%2F1tj99pyj?entry=ttu&g_ep=EgoyMDI1MDQyMy4wIKXMDSoASAFQAw%3D%3D">link</a>
			</p>
		</div>
		<div class="flex-item-center">
			<span></span>
			<p>Rekowo Dolne Szkoła Podstawowa nr 5 ul. Rekowska 36
				<a href="https://www.google.pl/maps/place/Szko%C5%82a+podstawowa+numer+5+im.+Jana+Drze%C5%BCd%C5%BCona+w+Redzie/@54.633877,18.3524456,17z/data=!3m1!4b1!4m6!3m5!1s0x46fdb1c3781d7d09:0x93c2c2bd929dedab!8m2!3d54.633877!4d18.3550205!16s%2Fg%2F11wqc3wsgl?entry=ttu&g_ep=EgoyMDI1MDQyMy4wIKXMDSoASAFQAw%3D%3D">link</a>
			</p>
		</div>
	</div>
</div>