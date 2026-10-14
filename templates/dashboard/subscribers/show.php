<?php
$data = $params['data'];
?>
<h3 class="dashboard-action-header">Szczegóły subskrybenta</h3>
<div class="post-content">
    <h4>Email: <?= e($data->email) ?></h4>
    <p>Status: <?= $data->isActive ? 'Aktywny' : 'Oczekuje na potwierdzenie' ?></p>
    <p>Data potwierdzenia (UTC): <?= e($data->confirmedAt ?? 'Brak potwierdzenia') ?></p>
</div>

<a href="/dashboard/subscribers" > Wróć </a>
