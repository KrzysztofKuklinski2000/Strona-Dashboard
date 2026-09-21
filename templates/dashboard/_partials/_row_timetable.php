<?php
$isPublished = ($row->status == 1);
$statusClass = $isPublished ? 'published' : 'no-published';
$statusText = $isPublished ? 'Publiczny' : 'Niepubliczny';
$showPosition = false;
?>
<tr>
  <td class="dashboard-table__index"><?=e($key + 1) ?>.</td>
  <td class="dashboard-table__primary"><?= e($row->day) ?></td>
  <td><?= e($row->city) ?></td>
  <td><?= e($row->advancementGroup) ?></td>
  <td><?= e($row->start) ?></td>
  <td><?= e($row->end) ?></td>
  <td>
    <span class="dashboard-status-badge <?= e($statusClass) ?>">
      <i class="fa-solid <?= $isPublished ? 'fa-circle-check' : 'fa-circle-xmark' ?>" aria-hidden="true"></i>
      <?= e($statusText) ?>
    </span>
  </td>
  <?php require "templates/dashboard/_partials/_action_links.php"; ?>
</tr>
