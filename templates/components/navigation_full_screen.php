<div class="nav-container-full-screen" style="<?php if($params['page'] !== 'start'){echo("position: static; background: #171D29;");} ?>">
	<div class="black" style="<?php if($params['page']!== 'start'){echo("display: none");} ?>"></div>
	<div class="nav" style="<?php if($params['page'] === 'start'){ echo "border:none";} ?>">
		<a href="?view=start">
			<div class="logo">
				<img src="public/images/logo1.png">
				<span>
					<p style="font-size:1.1em;  color:#fff">Karate</p>
					<p style="font-size:1.1em;  color:#CC0000;">Kyokushin</p>
					<p style="font-size:.9em;  color:#fff">Wejherowo</p>
				</span>
			</div>
		</a>
		<div class="full-screen-menu">
			<ul>
				<a href="?view=start">
					<li>
						<i class="fa-solid fa-house"></i>
						<p>start</p>
					</li>
				</a>
				<a href="?view=oplaty">
					<li>
						<i class="fa-solid fa-money-check-dollar"></i>
						<p>opłaty</p>
					</li>
				</a>
				<a href="?view=grafik">
					<li>
						<i class="fa-regular fa-calendar"></i>
						<p>grafik</p>
					</li>
				</a>
				<a href="?view=zapisy">
					<li>
						<i class="fa-solid fa-plus"></i>
						<p>zapisy</p>
					</li>
				</a>
				<a href="?view=kontakt">
					<li>
						<i class="fa-regular fa-address-book"></i>
						<p>kontakt</p>
					</li>
				</a>
				<a href="?view=aktualnosci">
					<li>
						<i class="fa-solid fa-info"></i>
						<p>aktualności</p>
					</li>
				</a>
				<a href="?view=galeria">
					<li>
						<i class="fa-regular fa-images"></i>
						<p>galleria</p>
					</li>
				</a>
				<a href="?view=obozy">
					<li>
						<i class="fa-solid fa-campground"></i>
						<p>obozy</p>
					</li>
				</a>
				<li class="onmouse">
					<i class="fa-regular fa-hand-back-fist"></i>
					<p>karate <i class="fa-solid fa-caret-down"></i> </p>
					<div class="dropdown">
						<ul>
							<a href="?view=oyama"><li>Matsutatsu Oyama</li></a>
							<a href="?view=przysiega_do_jo"><li>przysiega dojo</li></a>
							<a href="?view=wymagania"><li>wymagania egzaminacyjne</li></a>
							<a href="?view=regulamin"><li>regulamin</li></a>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>