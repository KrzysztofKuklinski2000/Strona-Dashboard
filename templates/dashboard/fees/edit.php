<?php
/** @var \App\DTO\Dashboard\FeesDto $data */
$data = $params['data'];
$csrf = $params['csrf_token'];
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<div class="list-header">
    <h3>Opłaty - Edytuj</h3>
</div>
<br>
<form action="/dashboard/fees/update" method="POST" class="price-form ">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?? '' ?>">

    <label>
        <span>Składka Ulgowa (jedna osoba):</span>
        <input type="number" name="n1" value="<?= $data->reducedContribution1Month ?>">
    </label>
    <p class="validation-error"><?= $errors['n1'] ?? ""  ?></p>

    <label>
        <span>Składka Ulgowa (dwie osoby): </span>
        <input type="number" name="n2" value="<?= $data->reducedContribution2Month ?>">
    </label>
    <p class="validation-error"><?= $errors['n2'] ?? ""  ?></p>

    <label>
        <span>Składka rodzina: </span>
        <input type="number" name="n3" value="<?= $data->familyContributionMonth ?>">
    </label>
    <p class="validation-error"><?= $errors['n3'] ?? ""  ?></p>

    <label>
        <span>Składka Ulgowa (jedna osoba/rok): </span>
        <input type="number" name="n6" value="<?= $data->reducedContribution1Year ?>">
    </label>
    <p class="validation-error"><?= $errors['n6'] ?? ""  ?></p>

    <label>
        <span>Składka Ulgowa (dwie osoby/rok): </span>
        <input type="number" name="n7" value="<?= $data->reducedContribution2Year ?>">
    </label>
    <p class="validation-error"><?= $errors['n7'] ?? ""  ?></p>

    <label>
        <span>Składka Rodzinna (za rok):</span>
        <input type="number" name="n8" value="<?= $data->familyContributionYear ?>">
    </label>
    <p class="validation-error"><?= $errors['n8'] ?? ""  ?></p>

    <label>
        <span>Informacje dodatkowe (góra):</span>
        <textarea name="n10"><?= $data->extraInformation ?></textarea>
    </label>
    <p class="validation-error"><?= $errors['n10'] ?? ""  ?></p>

    <label>
        <span>Infomracje o Składkach (dół):</span>
        <textarea name="n11"><?= $data->feesInformation ?></textarea>
    </label>
    <p class="validation-error"><?= $errors['n11'] ?? ""  ?></p>

    <input type="submit" value="Zapisz">
</form>