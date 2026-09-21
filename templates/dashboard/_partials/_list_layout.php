<?php 
$data = $data ?? [];
$csrfToken = $csrfToken ?? '';
?>
<div class="list-header">
  <h3><?= e($pageTitle) ?></h3>
  <a href="/dashboard/<?= e($moduleName) ?>/create">
    <span>Nowy</span><i class="fa-solid fa-plus" aria-hidden="true"></i>
  </a>
</div>

<?php if ($data === []): ?>
  <div class="dashboard-table-empty" role="status">
    <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
    <strong>Brak danych</strong>
    <span>Dodaj pierwszy element, aby pojawił się na liście.</span>
  </div>
<?php else: ?>
<div class="dashboard-table-wrapper">
<table class="dashboard-table">
  <thead>
    <tr>
      <th>Lp.</th>
      <?= $tableHeadersHtml ?? '' ?>

      <th class="dashboard-table__actions-heading">Opcje</th>
      <?php if (isset($showPosition) && $showPosition): ?>
        <th class="dashboard-table__position-heading">Pozycja</th>
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
</div>
<?php endif; ?>
