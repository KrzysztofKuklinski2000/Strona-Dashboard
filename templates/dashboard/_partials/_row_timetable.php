<?php
$isPublished = ($row->status == 1);
$statusClass = $isPublished ? 'published' : 'no-published';
$statusText = $isPublished ? 'Publiczny' : 'Niepubliczny';
$showPosition = false;
?>
<tr>
  <td><?=e($key + 1) ?>.</td>
  <td><?= e($row->day) ?></td>
  <td><?= e($row->city) ?></td>
  <td><?= e($row->advancementGroup) ?></td>
  <td><?= e($row->start) ?></td>
  <td><?= e($row->end) ?></td>
  <td class="<?= e($statusClass) ?>"><?= e($statusText) ?></td>
  <?php require "templates/dashboard/_partials/_action_links.php"; ?>
</tr>