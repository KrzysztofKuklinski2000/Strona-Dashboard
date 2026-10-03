<?php
$isPublished = ($row->status == 1);
$statusClass = $isPublished ? 'published' : 'no-published';
$statusText = $isPublished ? 'Publiczny' : 'Niepubliczny';
$showPosition = false;
$locationName = trim($row->locationName);
?>
<tr>
  <td class="dashboard-table__index"><?=e($key + 1) ?>.</td>
  <td class="dashboard-table__primary"><?= e($row->day) ?></td>
  <td>
    <a class="timetable-location-link timetable-location-link--table" href="/dashboard/timetable/location/show/<?= e($row->locationId) ?>">
      <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
      <span><?= e($locationName !== '' ? $locationName : 'Lokalizacja #' . $row->locationId) ?></span>
      <i class="fa-solid fa-arrow-right timetable-location-link__arrow" aria-hidden="true"></i>
    </a>
  </td>
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
