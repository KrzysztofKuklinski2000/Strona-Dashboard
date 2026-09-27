<?php 
$data = $data ?? [];
$csrfToken = $csrfToken ?? '';
?>
<div class="list-header">
  <h3><?= e($pageTitle) ?></h3>
  <div class="list-header__actions">
    <?php foreach ($additionalHeaderActions ?? [] as $headerAction): ?>
      <a
        class="<?= ($headerAction['variant'] ?? '') === 'secondary' ? 'list-header__action--secondary' : '' ?>"
        href="<?= e($headerAction['url']) ?>"
      >
        <span><?= e($headerAction['label']) ?></span>
        <i class="<?= e($headerAction['icon']) ?>" aria-hidden="true"></i>
      </a>
    <?php endforeach; ?>
    <a href="/dashboard/<?= e($moduleName) ?>/create">
      <span>Nowy</span><i class="fa-solid fa-plus" aria-hidden="true"></i>
    </a>
  </div>
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
