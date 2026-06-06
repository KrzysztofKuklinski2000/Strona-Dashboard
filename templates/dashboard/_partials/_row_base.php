<?php
$isPublished = ($row->status == 1);
$statusClass = $isPublished ? 'published' : 'no-published';
$statusText = $isPublished ? 'Publiczny' : 'Niepubliczny';
?>
<tr>
    <td><?= e($key + 1) ?>.</td>
    <td><?= e($row->title) ?></td>
    <td><?= e($row->created) ?></td>
    <td class="<?= e($row->status == 1 ? 'published' : 'no-published') ?>">
        <?= $row->status == 1 ? 'Publiczny' : 'Niepubliczny' ?>
    </td>
  <?php require "templates/dashboard/_partials/_action_links.php"; ?>
  <td>
    <div>
      <?php
      //Przycisk w górę
      $postId = $row->id;
      $direction = 'up';
      require "templates/dashboard/_partials/_move_button.php";

      //Przycisk w dół
      $direction = 'down';
      require "templates/dashboard/_partials/_move_button.php";
      ?>
    </div>
  </td>
</tr>