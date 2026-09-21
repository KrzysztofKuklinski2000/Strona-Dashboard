<?php
$isPublished = ($row->status == 1);
$statusClass = $isPublished ? 'published' : 'no-published';
$statusText = $isPublished ? 'Publiczny' : 'Niepubliczny';

?>
<tr>
  <td class="dashboard-table__index"><?= e($key + 1) ?>.</td>
  <td><img class="dashboard-image-index" src="/public/uploads/<?= e(rawurlencode((string) $row->imageName)) ?>" alt="Miniatura zdjęcia" loading="lazy"></td>
  <td class="dashboard-table__primary"><?= e($row->description) ?></td>
  <td><?= e($row->createdAt) ?></td>
  <td>
    <span class="dashboard-status-badge <?= e($statusClass) ?>">
      <i class="fa-solid <?= $isPublished ? 'fa-circle-check' : 'fa-circle-xmark' ?>" aria-hidden="true"></i>
      <?= e($statusText) ?>
    </span>
  </td>
  <?php require "templates/dashboard/_partials/_action_links.php"; ?>
  <td class="dashboard-table__position">
    <div class="dashboard-position-actions">
      <?php
      $postId = $row->id;
      $direction = 'up';
      require 'templates/dashboard/_partials/_move_button.php';
      $direction = 'down';
      require 'templates/dashboard/_partials/_move_button.php';
      ?>
    </div>
  </td>
</tr>
