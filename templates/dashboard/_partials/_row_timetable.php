<?php
$isPublished = ($row['status'] == 1);
$statusClass = $isPublished ? 'published' : 'no-published';
$statusText = $isPublished ? 'Publiczny' : 'Niepubliczny';
$showPosition = false;
?>
<tr>
  <td><?= $key + 1 ?>.</td>
  <td><?= htmlspecialchars($row['day']) ?></td>
  <td><?= htmlspecialchars($row['city']) ?></td>
  <td><?= htmlspecialchars($row['advancement_group']) ?></td>
  <td><?= htmlspecialchars($row['start']) ?></td>
  <td><?= htmlspecialchars($row['end']) ?></td>
  <td class="<?= $statusClass ?>"><?= $statusText ?></td>
  <?php require "templates/dashboard/_partials/_action_links.php"; ?>
</tr>