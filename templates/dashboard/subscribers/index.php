<?php
$pageTitle = 'Lista Subskrybentów';
$moduleName = 'subscribers';
$data = $params['data'] ?? [];
?>
<div class="list-header">
  <h3><?= htmlspecialchars($pageTitle) ?></h3>
  <a href="/dashboard/<?= htmlspecialchars($moduleName) ?>/create">
    <p>Nowy </p><i class="fa-solid fa-plus"></i>
  </a>
</div>
<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Emails</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $key => $row): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['email'] ?></td>
        <?php require "templates/dashboard/_partials/_action_links.php"; ?>
    <?php endforeach; ?>
  </tbody>
</table>