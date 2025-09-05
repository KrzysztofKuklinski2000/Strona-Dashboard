<?php 
	$counter = 1;
	$data = $params['data'];
?>
<div class="content-container">
	<?php if(!$params['operation']): ?>
		<div class="list-header">
			<h3>Posty - Strona Główna</h3>
			<a href="?dashboard=start&subpage=grafik&operation=create"><p>Nowy </p><i class="fa-solid fa-plus"></i></a>
		</div>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Dzień</th>
					<th>Miasto</th>
					<th>Grupa</th>
					<th>Start</th>
					<th>Koniec</th>
					<th>Status</th>
					<th>Opcje</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($data ?? [] as $row): ?>
					<tr>
						<!-- <td><?php echo $counter++ ?>.</td> -->
						<td><?= $row['id'] ?></td>
						<td><?php echo $row['day'] ?></td>
						<td><?php echo $row['city'] ?></td>
						<td><?php echo $row['advancement_group'] ?></td>
						<td><?php echo $row['start'] ?></td>
						<td><?php echo $row['end'] ?></td>
						<td class="<?php echo $row['status'] == 1 ? 'published' : 'no-published' ?>">
							<?php echo $row['status'] == 1 ? 'Publiczny' : 'Nie publiczny' ?>
						</td>
						<td class="links">
							<a href="?dashboard=start&subpage=grafik&operation=edit&id=<?php echo $row['id']?>"><i class="fa-regular fa-pen-to-square"></i></a>
							<a href="?dashboard=start&subpage=grafik&operation=delete&id=<?php echo $row['id']?>"><i class="fa-solid fa-trash"></i></a>
							<a href="?dashboard=start&subpage=grafik&operation=show&id=<?php echo $row['id']?>"><i class="fa-solid fa-magnifying-glass"></i></a>
						</td>
						<td></td>
					</tr> 
				<?php endforeach ?>
			</tbody>
		</table>
		<?php else: require_once('templates/dashboard/pages/operation_timetable/'.$params['operation'].'.php'); ?>
		<?php endif; ?>
</div>