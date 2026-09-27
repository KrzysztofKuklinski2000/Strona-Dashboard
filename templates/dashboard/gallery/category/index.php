<?php

declare(strict_types=1);

$data = $params['data'] ?? [];
?>

<div class="list-header">
    <h3>Kategorie galerii</h3>
</div>

<?php if ($data === []): ?>
    <div class="dashboard-table-empty" role="status">
        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
        <strong>Brak kategorii</strong>
        <span>Utworzone kategorie pojawią się w tym miejscu.</span>
    </div>
<?php else: ?>
    <div class="dashboard-table-wrapper">
        <table class="dashboard-table">
            <thead>
            <tr>
                <th>Lp.</th>
                <th>Nazwa</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Pozycja</th>
                <th>Data utworzenia</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $key => $category): ?>
                <?php
                $isActive = $category->status === 1;
                $statusClass = $isActive ? 'published' : 'no-published';
                $statusText = $isActive ? 'Aktywna' : 'Nieaktywna';
                ?>
                <tr>
                    <td class="dashboard-table__index"><?= e($key + 1) ?>.</td>
                    <td class="dashboard-table__primary"><?= e($category->name) ?></td>
                    <td><?= e($category->slug) ?></td>
                    <td>
                        <span class="dashboard-status-badge <?= e($statusClass) ?>">
                            <i class="fa-solid <?= $isActive ? 'fa-circle-check' : 'fa-circle-xmark' ?>" aria-hidden="true"></i>
                            <?= e($statusText) ?>
                        </span>
                    </td>
                    <td><?= e($category->position) ?></td>
                    <td><?= e($category->createdAt) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
