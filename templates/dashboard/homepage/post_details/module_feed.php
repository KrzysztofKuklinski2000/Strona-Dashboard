<?php
$moduleValue = $payload['module'] ?? '';
$module = is_scalar($moduleValue) ? (string) $moduleValue : '';
$moduleLabel = $module === 'news' ? 'Aktualności' : $module;

$limitValue = $payload['limit'] ?? 0;
$limit = is_scalar($limitValue) ? (int) $limitValue : 0;
?>

<p class="homepage-post-details__eyebrow">Wpisy z modułu</p>
<h4><?= e($data->title ?? '') ?></h4>

<div class="homepage-post-details__cards">
    <div class="homepage-post-details__card">
        <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
        <strong>Moduł źródłowy</strong>
        <p><?= e($moduleLabel !== '' ? $moduleLabel : 'Nie wybrano') ?></p>
    </div>

    <div class="homepage-post-details__card">
        <i class="fa-solid fa-list-ol" aria-hidden="true"></i>
        <strong>Liczba wpisów</strong>
        <p><?= e($limit) ?></p>
    </div>
</div>
