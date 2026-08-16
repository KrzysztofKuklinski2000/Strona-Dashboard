<?php
$isPublished = ($row->status == 1);
$statusClass = $isPublished ? 'published' : 'no-published';
$statusText = $isPublished ? 'Publiczny' : 'Niepubliczny';

?>
<tr>
  <td><?= e($key + 1) ?>.</td>
  <td><img class="dashboard-image-index" src="/public/uploads/<?= e(rawurlencode((string) $row->imageName)) ?>" alt="zdjecie" loading="lazy"></td>
  <td><?= e($row->description) ?></td>
  <td><?= e($row->createdAt) ?></td>
  <td class="<?= e($statusClass) ?>"><?= e($statusText) ?></td>
  <?php require "templates/dashboard/_partials/_action_links.php"; ?>
  <td class="move-arrows">
    <div>
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