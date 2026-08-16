<?php

use App\DTO\Dashboard\FeesDto;

/** @var FeesDto $data */
$data = $params['data'];
$csrf = $params['csrf_token'];
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<div class="list-header">
    <h3>Opłaty - Edytuj</h3>
</div>
<br>
<form action="/dashboard/fees/update" method="POST" class="price-form ">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <label>
        <span>Składka Ulgowa (jedna osoba):</span>
        <input type="number" name="n1" value="<?= e($data->reducedContribution1Month) ?>">
    </label>
    <p class="validation-error"><?= e($errors['n1'] ?? "")  ?></p>

    <label>
        <span>Składka Ulgowa (dwie osoby): </span>
        <input type="number" name="n2" value="<?= e($data->reducedContribution2Month) ?>">
    </label>
    <p class="validation-error"><?= e($errors['n2'] ?? "")  ?></p>

    <label>
        <span>Składka rodzina: </span>
        <input type="number" name="n3" value="<?= e($data->familyContributionMonth) ?>">
    </label>
    <p class="validation-error"><?= e($errors['n3'] ?? "")  ?></p>

    <label>
        <span>Składka Ulgowa (jedna osoba/rok): </span>
        <input type="number" name="n6" value="<?= e($data->reducedContribution1Year) ?>">
    </label>
    <p class="validation-error"><?= e($errors['n6'] ?? "")  ?></p>

    <label>
        <span>Składka Ulgowa (dwie osoby/rok): </span>
        <input type="number" name="n7" value="<?= e($data->reducedContribution2Year) ?>">
    </label>
    <p class="validation-error"><?= e($errors['n7'] ?? "")  ?></p>

    <label>
        <span>Składka Rodzinna (za rok):</span>
        <input type="number" name="n8" value="<?= e($data->familyContributionYear) ?>">
    </label>
    <p class="validation-error"><?= e($errors['n8'] ?? "")  ?></p>

    <label>
        <span>Informacje dodatkowe (góra):</span>
        <textarea name="n10"><?= e($data->extraInformation) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['n10'] ?? "")  ?></p>

    <label>
        <span>Infomracje o Składkach (dół):</span>
        <textarea name="n11"><?= e($data->feesInformation) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['n11'] ?? "")  ?></p>

    <input type="submit" value="Zapisz">
</form>