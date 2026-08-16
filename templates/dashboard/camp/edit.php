<?php
use App\DTO\Dashboard\CampDto;

/** @var CampDto $data */
$data = $params['data'];
$csrf = $params['csrf_token'];
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<div class="list-header">
    <h3>Obozy - Edytuj</h3>
</div>
<br>
<form action="/dashboard/camp/update" method="POST" class="camp-form ">
    <input type="hidden" name="csrf_token" value="<?= e($csrf  ?? '') ?>">

    <label>
        <span>Miejscowość:</span>
        <input type="text" name="town" value="<?= e($data->city) ?>">
    </label>
    <p class="validation-error"><?= e($errors['town'] ?? "")  ?></p>

    <label>
        <span>Nazwa Pensjonatu</span>
        <input type="text" name="guesthouse" value="<?= e($data->guesthouse) ?>">
    </label>
    <p class="validation-error"><?= e($errors['guesthouse'] ?? "")  ?></p>

    <label>
        <span>Miejsce wyjazdu: </span>
        <input type="text" name="townStart" value="<?= e($data->cityStart) ?>">
    </label>
    <p class="validation-error"><?= e($errors['townStart'] ?? "")  ?></p>

    <label>
        <span>Data wyjazdu: </span>
        <input type="date" name="dateStart" value="<?= e($data->dateStart) ?>">
    </label>
    <p class="validation-error"><?= e($errors['dateStart'] ?? "")  ?></p>

    <label>
        <span>Data powrotu: </span>
        <input type="date" name="dateEnd" value="<?= e($data->dateEnd) ?>">
    </label>
    <p class="validation-error"><?= e($errors['dateEnd'] ?? "")  ?></p>

    <label>
        <span>Godzina wyjazdu: </span>
        <input type="time" name="timeStart" value="<?= e($data->timeStart) ?>">
    </label>
    <p class="validation-error"><?= e($errors['timeStart'] ?? "")  ?></p>

    <label>
        <span>Godzina powrotu: </span>
        <input type="time" name="timeEnd" value="<?= e($data->timeEnd) ?>">
    </label>
    <p class="validation-error"><?= e($errors['timeEnd'] ?? "")  ?></p>

    <label>
        <span>Pensjonat(nazwa/adres): </span>
        <textarea name="place"><?= e($data->place) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['place'] ?? "")  ?></p>

    <label>
        <span>Zakwaterowanie: </span>
        <textarea name="accommodation"><?= e($data->accommodation) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['accommodation'] ?? "")  ?></p>

    <label>
        <span>Wyżywienie: </span>
        <textarea name="meals"><?= e($data->meals) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['meals'] ?? "")  ?></p>

    <label>
        <span>Wycieczki </span>
        <textarea name="trips"><?= e($data->trips) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['trips'] ?? "")  ?></p>

    <label>
        <span>Kadrę:</span>
        <textarea name="staff"><?= e($data->staff) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['staff'] ?? "")  ?></p>

    <label>
        <span>Transport PKP:</span>
        <textarea name="transport"><?= e($data->transport) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['transport'] ?? "")  ?></p>

    <label>
        <span>Treningi:</span>
        <textarea name="training"><?= e($data->training) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['training'] ?? "")  ?></p>

    <label>
        <span>Ubezpieczenie:</span>
        <textarea name="insurance"><?= e($data->insurance) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['insurance'] ?? "")  ?></p>

    <label>
        <span>Koszt:</span>
        <input type="number" name="cost" value="<?= e($data->cost) ?>">
    </label>
    <p class="validation-error"><?= e($errors['cost'] ?? "")  ?></p>

    <label>
        <span>Zaliczka:</span>
        <input type="number" name="advancePayment" value="<?= e($data->advancePayment) ?>">
    </label>
    <p class="validation-error"><?= e($errors['advancePayment'] ?? "")  ?></p>

    <label>
        <span>Data zaliczki</span>
        <input type="date" name="advanceDate" value="<?= e($data->advanceDate) ?>">
    </label>
    <p class="validation-error"><?= e($errors['advanceDate'] ?? "")  ?></p>

    <input type="submit" value="Zapisz">
</form>