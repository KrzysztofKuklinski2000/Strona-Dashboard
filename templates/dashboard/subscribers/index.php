<?php
$pageTitle = 'Lista Subskrybentów';
$moduleName = 'subscribers';
$showEditAction = false;
$data = $params['data'] ?? [];
?>
<div class="list-header">
    <h3><?= e($pageTitle) ?></h3>
</div>

<?php if ($data === []): ?>
    <div class="dashboard-table-empty" role="status">
        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
        <strong>Brak subskrybentów</strong>
        <span>Adresy pojawią się tutaj po zapisie przez formularz na stronie publicznej.</span>
    </div>
<?php else: ?>
    <div class="dashboard-table-wrapper">
        <table class="dashboard-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Status</th>
                <th class="dashboard-table__actions-heading">Opcje</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td class="dashboard-table__index"><?= e($row->id) ?></td>
                    <td class="dashboard-table__primary"><?= e($row->email) ?></td>
                    <td>
                        <span class="dashboard-status-badge <?= $row->isActive ? 'published' : 'no-published' ?>">
                            <i class="fa-solid <?= $row->isActive ? 'fa-circle-check' : 'fa-clock' ?>" aria-hidden="true"></i>
                            <?= $row->isActive ? 'Aktywny' : 'Oczekuje na potwierdzenie' ?>
                        </span>
                    </td>
                    <?php require "templates/dashboard/_partials/_action_links.php"; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
