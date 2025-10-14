<?php 
$data = $data ?? [];
$csrfToken = $csrfToken ?? '';
?>
<div class="list-header">
  <h3><?= htmlspecialchars($pageTitle) ?></h3>
  <a href="?dashboard=<?= htmlspecialchars($moduleName) ?>&action=create">
    <p>Nowy </p><i class="fa-solid fa-plus"></i>
  </a>
</div>
<table>
  <thead>
    <tr>
      <th>Lp.</th>
      <?= $tableHeadersHtml ?? '' ?>

      <th>Opcje</th>
      <?php if (isset($showPosition) && $showPosition): ?>
        <th>Pozycja</th>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $key => $row): ?>
      <?php
      // Dołączamy partiala renderującego wiersz, przekazując mu potrzebne zmienne
      require $tableRowPartialPath;
      ?>
    <?php endforeach; ?>
  </tbody>
</table>