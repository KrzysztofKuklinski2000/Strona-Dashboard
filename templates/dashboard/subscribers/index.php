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
      <th>Email</th>
      <th>Status</th> <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $key => $row): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td>
          <?php if ($row['is_active']): ?>
            <span style="color: #28a745; font-weight: bold;">
              <i class="fa-solid fa-circle-check"></i> Aktywny
            </span>
          <?php else: ?>
            <span style="color: #dc3545; font-weight: bold;">
              <i class="fa-solid fa-circle-xmark"></i> Nieaktywny
            </span>
          <?php endif; ?>
        </td>
        <?php require "templates/dashboard/_partials/_action_links.php"; ?>
      </tr> 
    <?php endforeach; ?>
  </tbody>
</table>