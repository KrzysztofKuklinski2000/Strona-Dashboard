<?php

declare(strict_types=1);

$data = $params['data'] ?? [];
?>

<div class="list-header">
    <h3>Lokalizacje zajęć</h3>
</div>

<?php if ($data === []): ?>
    <div class="dashboard-table-empty" role="status">
        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
        <strong>Brak lokalizacji</strong>
        <span>Utworzone lokalizacje zajęć pojawią się w tym miejscu.</span>
    </div>
<?php else: ?>
    <div class="dashboard-table-wrapper">
        <table class="dashboard-table">
            <thead>
            <tr>
                <th scope="col">Lp.</th>
                <th scope="col">Nazwa</th>
                <th scope="col">Miasto</th>
                <th scope="col">Adres</th>
                <th scope="col">Status</th>
                <th scope="col">Mapa</th>
                <th scope="col">Data utworzenia</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $key => $location): ?>
                <?php
                $isActive = $location->status === 1;
                $statusClass = $isActive ? 'published' : 'no-published';
                $statusText = $isActive ? 'Aktywna' : 'Nieaktywna';
                $hasMap = trim((string) $location->map_embed_url) !== '';
                ?>
                <tr>
                    <td class="dashboard-table__index"><?= e($key + 1) ?>.</td>
                    <td class="dashboard-table__primary"><?= e($location->name) ?></td>
                    <td><?= e($location->city) ?></td>
                    <td><?= e($location->address) ?></td>
                    <td>
                        <span class="dashboard-status-badge <?= e($statusClass) ?>">
                            <i class="fa-solid <?= $isActive ? 'fa-circle-check' : 'fa-circle-xmark' ?>" aria-hidden="true"></i>
                            <?= e($statusText) ?>
                        </span>
                    </td>
                    <td><?= $hasMap ? 'Dodana' : 'Brak' ?></td>
                    <td><?= e($location->createdAt) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
