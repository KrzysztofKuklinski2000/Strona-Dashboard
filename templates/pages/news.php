<?php $params = $params['content'];?>
<div class="respons-container">
	<div class="news-contianer">
		<div class="line flex-item-center">
			<div></div>
			<p></p>
		</div>
		<div class="news">
			<?php foreach ($params ?? [] as $content): ?>
				<?php if($content['status']): ?>
					<div class="news-box">
						<div class="news-line"></div>
						<div>
							<h3><?php echo $content['title']; ?></h3>
							<span style="color:gray;"><?php echo $content['created']; ?></span>
							<p><?php echo $content['description']; ?></p>
						</div>
					</div>
				<?php endif ?>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="show-more-news flex-center">
		<button class="btn-more">
			<i class="fa-solid fa-angles-down"></i>
		</button>
	</div>
</div>