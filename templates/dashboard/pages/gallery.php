<?php 
	$counter = 1;
	$data = $params['data'];
?>

<div class="content-container">
	<?php if(!$params['operation']): ?>
		<div class="list-header">
			<h3>Posty - Strona Główna</h3>
			<a href="?dashboard=start&subpage=galeria&operation=create"><p>Nowy </p><i class="fa-solid fa-plus"></i></a>
		</div>
		<table>
			<thead>
				<tr>
					<th>Lp.</th>
					<th>Zdjęcie</th>
					<th>Opis</th>
					<th>Data</th>
					<th>Status</th>
					<th>Opcje</th>
					<th>Position</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($data ?? [] as $row): ?>
					<tr>
						<td><?php echo $counter++ ?>.</td>
						<td><img class="dashboard-image-index" src="/public/images/karate/<?= $row['image_name'] ?>" alt=""></td>
						<td><?php echo $row['description'] ?></td>
						<td><?php echo $row['created_at'] ?></td>
						<td class="<?php echo $row['status'] == 1 ? 'published' : 'no-published' ?>">
							<?php echo $row['status'] == 1 ? 'Publiczny' : 'Nie publiczny' ?>
						</td>
						<td class="links">
							<a href="?dashboard=start&subpage=galeria&operation=edit&id=<?php echo $row['id']?>"><i class="fa-regular fa-pen-to-square"></i></a>
							<a href="?dashboard=start&subpage=galeria&operation=delete&id=<?php echo $row['id']?>"><i class="fa-solid fa-trash"></i></a>
							<a href="?dashboard=start&subpage=galeria&operation=show&id=<?php echo $row['id']?>"><i class="fa-solid fa-magnifying-glass"></i></a>
						</td>
						<td class="move-arrows">
							<div>
								<form action="?dashboard=start&subpage=galeria&operation=move"  method="POST">
									<input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
									<input type="hidden" name="id" value="<?= $row['id'] ?>">
									<input type="hidden" name="dir" value="up">
									<button type="submit"><i class="fa-solid fa-caret-up"></i></button>
								</form>
								<form action="?dashboard=start&subpage=galeria&operation=move"  method="POST">
									<input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
									<input type="hidden" name="id" value="<?= $row['id'] ?>">
									<input type="hidden" name="dir" value="down">
									<button type="submit"><i class="fa-solid fa-caret-down"></i></button>
								</form>
							</div>	
						</td>
					</tr> 
				<?php endforeach ?>
			</tbody>
		</table>
	<?php else: require_once('templates/dashboard/pages/operation_gallery/'.$params['operation'].'.php');?>
	<?php endif; ?>
</div>


