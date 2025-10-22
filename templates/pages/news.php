<?php
$numberOfRows = $params['numberOfRows'];
$currentPage = $params['currentNumberOfPage'];
?>
<div class="respons-container">
	<div class="news-contianer">
		<div class="line flex-item-center">
			<div></div>
			<p></p>
		</div>
		<div class="news">
			<?php foreach ($params['content'] ?? [] as $content): ?>
				<?php if ($content['status']): ?>
					<div class="news-box">
						<div class="news-line"></div>
						<div>
							<h3><?= $content['title']; ?></h3>
							<p><?= $content['description']; ?></p>
						</div>
					</div>
				<?php endif ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="pagination">
		<div class="pagination-box">
			<?php if($currentPage > 1): ?>
				<a href="/?action=aktualnosci&page=<?= $currentPage - 1 ?>">
					<i class="fa-regular fa-square-caret-left"></i>
				</a>
			<?php endif ?>

			<?php for ($i = 1; $i <= $numberOfRows; $i++):	?>
				<?php if ($currentPage <= 0): ?>
					<a <?= $i === 1 ? "class=current" : "" ?> href="/?action=aktualnosci&page=<?= $i ?>"><?= $i ?></a>
				<?php elseif ($currentPage > $numberOfRows ): ?>
					<a <?= $i == $numberOfRows  ? "class=current" : "" ?> href="/?action=aktualnosci&page=<?= $i ?>"><?= $i ?></a>
				<?php else: ?>
					<a <?= $i === $currentPage ? "class=current" : "" ?> href="/?action=aktualnosci&page=<?= $i ?>"><?= $i ?></a>
				<?php endif; ?>

			<?php endfor; ?>

			<?php if($currentPage < $numberOfRows): ?>
			<a href="/?action=aktualnosci&page=<?= $currentPage + 1 ?>">
				<i class="fa-regular fa-square-caret-right"></i>
			</a>
			<?php endif; ?>
		</div>
	</div>
</div>