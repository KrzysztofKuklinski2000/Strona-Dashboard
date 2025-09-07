<div class="respons-container">
	<div class="slider">
		<div class="slider-content">
			<i class="fa-solid fa-camera"></i>
			<h3>Zdjęcia z zajęć</h3>
			<p>Klub Karate Kyokushin</p>
			<p>Tu znajedziesz zdjęcia z zajęć i obozów</p>
			<a href="" class="btn-join">Więcej</a>
		</div>
		<div class="slider-image">
			<div class="dots">
				<p></p>
				<p></p>
				<p></p>
				<p></p>
			</div>
			<div class="arrows">
				<div class="left-arrow"><i class="fa-solid fa-caret-left"></i></div>
				<div class="right-arrow"><i class="fa-solid fa-caret-right"></i></div>
			</div>
			<img class="img" src="public/images/slider/4.JPG" alt="">
			<img class="img" src="public/images/slider/3.JPG" alt="">
			<img class="img" src="public/images/slider/2.JPG" alt="">
			<img class="img" src="public/images/slider/1.JPG" alt="">
			<div class="black-filter"></div>
		</div>
	</div><br><br>
	<?php 
		$text = '<i style="color:#1C2331" class="fa-regular fa-image"></i> Zdjęcia ';
		require('templates/components/post_header.php');
	 ?>
	<div class="gallery">
		<?php foreach($params['content'] as $content): ?>
			<div class="img-box">
				<img src="public/images/karate/<?= $content['image_name'] ?>" alt="">
				<p><?= $content['description'] ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<script type="text/javascript" src="public/js/slider.js"></script>