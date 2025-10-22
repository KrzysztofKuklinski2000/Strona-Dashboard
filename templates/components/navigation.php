<div style="<?php if($params['page'] !== 'start'){echo 'background: #171D29;';} ?>">
	<div class="nav-container margin-auto <?php if($params['page'] !== 'start'){echo 'border-bottom-for-nav';} ?>">
		<a href="?action=start">
			<div class="logo">
				<img src="public/images/<?php if($params['page'] !== 'start'){echo 'logo1.png';}else {echo 'logo.gif';} ?>" alt="logo"">
				<span>
					<p style="font-size:.9em;  <?php if($params['page'] !== 'start'){echo 'color: #fff;';}else {echo 'color:#111;';} ?>">Karate</p>
					<p style="font-size:.9em; color:#CC0000;">Kyokushin</p>
					<p style="font-size:.9em; <?php if($params['page'] !== 'start'){echo 'color: #fff;';}else {echo 'color:#111;';} ?>">Wejherowo/Reda</p>
				</span>
			</div>
		</a>
		<div class="flex-item-center">
			<div  style="cursor: pointer;" class="nav-bar-icon">
				<p style="<?php if($params['page'] !== 'start') echo 'background: #fff'; ?>"></p>
				<p style="<?php if($params['page'] !== 'start') echo 'background: #fff'; ?>"></p>
				<p style="<?php if($params['page'] !== 'start') echo 'background: #fff'; ?>"></p>
			</div>
		</div>
	</div>
</div>
