<?php

use App\Content\HomepageFeedModules;
$modules = HomepageFeedModules::all();

$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);

$moduleValue = $payload['module'] ?? HomepageFeedModules::NEWS;
$module = is_scalar($moduleValue) ? (string) $moduleValue : HomepageFeedModules::NEWS;

$limitValue = $payload['limit'] ?? 3;
$limit = is_scalar($limitValue) ? (string) $limitValue : '3';
?>

<div class="cards-grid-form module-feed-form">
    <fieldset class="cards-grid-form__card">
        <legend>
            <span><i class="fa-regular fa-newspaper" aria-hidden="true"></i></span>
            <strong>Wpisy z modułu</strong>
        </legend>

        <label>
            <span>Moduł źródłowy</span>
            <select name="payload[module]">
                <?php foreach ($modules as $key  => $value): ?>
                    <option
                        value="<?= e($key) ?>"
                        <?= $module === $key ? 'selected': ''?>
                    >
                            <?= e($value['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <p class="validation-error"><?= e($errors['payload.module'] ?? '') ?></p>

        <label>
            <span>Liczba wyświetlanych wpisów</span>
            <input
                type="number"
                name="payload[limit]"
                min="1"
                max="12"
                value="<?= e($limit) ?>"
            >
        </label>
        <p class="validation-error"><?= e($errors['payload.limit'] ?? '') ?></p>
    </fieldset>
</div>
