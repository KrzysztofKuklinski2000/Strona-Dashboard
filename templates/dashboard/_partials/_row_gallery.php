<?php
$isPublished = ($row['status'] == 1);
$statusClass = $isPublished ? 'published' : 'no-published';
$statusText = $isPublished ? 'Publiczny' : 'Niepubliczny';

?>
<tr>
  <td><?= $key + 1 ?>.</td>
  <td><img class="dashboard-image-index" src="/public/images/karate/<?= htmlspecialchars($row['image_name']) ?>" alt="zdjecie" loading="lazy"></td>
  <td><?= htmlspecialchars($row['description']) ?></td>
  <td><?= htmlspecialchars($row['created_at']) ?></td>
  <td class="<?= $statusClass ?>"><?= $statusText ?></td>
  <?php require "templates/dashboard/_partials/_action_links.php"; ?>
  <td class="move-arrows">
    <div>
      <?php
      $postId = $row['id'];
      $direction = 'up';
      require 'templates/dashboard/_partials/_move_button.php';
      $direction = 'down';
      require 'templates/dashboard/_partials/_move_button.php';
      ?>
    </div>
  </td>
</tr>