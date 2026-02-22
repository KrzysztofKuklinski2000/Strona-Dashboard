<?php
$data = $params['data'];
$csrf = $params['csrf_token'];
$errors = $params['flash']['message'] ?? [];
?>

<div class="list-header">
  <h3>Obozy - Edytuj</h3>
</div>
<br>
<form action="/dashboard/camp/update" method="POST" class="camp-form ">
  <input type="hidden" name="csrf_token" value="<?= $csrf  ?? '' ?>">
  <label>
    <span>Miejscowość:</span>
    <input type="text" name="town" value="<?= $data['city'] ?>">
  </label>
  <p class="validation-error"><?= $errors['town'] ?? ""  ?></p>
  <label>
    <span>Nazwa Pensjonatu</span>
    <input type="text" name="guesthouse" value="<?= $data['guesthouse'] ?>">
  </label>
  <p class="validation-error"><?= $errors['guesthouse'] ?? ""  ?></p>
  <label>
    <span>Miejsce wyjazdu: </span>
    <input type="text" name="townStart" value="<?= $data['city_start'] ?> ">
  </label>
  <p class="validation-error"><?= $errors['townStart'] ?? ""  ?></p>
  <label>
    <span>Data wyjazdu: </span>
    <input type="date" name="dateStart" value="<?= $data['date_start'] ?>">
  </label>
  <p class="validation-error"><?= $errors['dateStart'] ?? ""  ?></p>
  <label>
    <span>Data powrotu: </span>
    <input type="date" name="dateEnd" value="<?= $data['date_end'] ?>">
  </label>
  <p class="validation-error"><?= $errors['dateEnd'] ?? ""  ?></p>
  <label>
    <span>Godzina wyjazdu: </span>
    <input type="time" name="timeStart" value="<?= $data['time_start'] ?>">
  </label>
  <p class="validation-error"><?= $errors['timeStart'] ?? ""  ?></p>
  <label>
    <span>Godzina powrotu: </span>
    <input type="time" name="timeEnd" value="<?= $data['time_end'] ?>">
  </label>
  <p class="validation-error"><?= $errors['timeEnd'] ?? ""  ?></p>
  <label>
    <span>Pensjonat(nazwa/adres): </span>
    <textarea name="place"><?= $data['place'] ?></textarea>
  </label>
  <p class="validation-error"><?= $errors['place'] ?? ""  ?></p>
  <label>
    <span>Zakwaterowanie: </span>
    <textarea name="accommodation" value=""><?= $data['accommodation'] ?></textarea>
  </label>
  <p class="validation-error"><?= $errors['accommodation'] ?? ""  ?></p>
  <label>
    <span>Wyżywienie: </span>
    <textarea name="meals" value=""><?= $data['meals'] ?></textarea>
  </label>
  <p class="validation-error"><?= $errors['meals'] ?? ""  ?></p>
  <label>
    <span>Wycieczki </span>
    <textarea name="trips" value=""><?= $data['trips'] ?></textarea>
  </label>
  <p class="validation-error"><?= $errors['trips'] ?? ""  ?></p>
  <label>
    <span>Kadrę:</span>
    <textarea name="staff" value=""><?= $data['staff'] ?></textarea>
  </label>
  <p class="validation-error"><?= $errors['staff'] ?? ""  ?></p>
  <label>
    <span>Transport PKP:</span>
    <textarea name="transport" value=""><?= $data['transport'] ?></textarea>
  </label>
  <p class="validation-error"><?= $errors['transport'] ?? ""  ?></p>
  <label>
    <span>Treningi:</span>
    <textarea name="training" value=""><?= $data['training'] ?></textarea>
  </label>
  <p class="validation-error"><?= $errors['training'] ?? ""  ?></p>
  <label>
    <span>Ubezpieczenie:</span>
    <textarea name="insurance" value=""><?= $data['insurance'] ?>	</textarea>
  </label>
  <p class="validation-error"><?= $errors['insurance'] ?? ""  ?></p>
  <label>
    <span>Koszt:</span>
    <input type="number" name="cost" value="<?= $data['cost'] ?>">
  </label>
  <p class="validation-error"><?= $errors['cost'] ?? ""  ?></p>
  <label>
    <span>Zaliczka:</span>
    <input type="number" name="advancePayment" value="<?= $data['advancePayment'] ?>">
  </label>
  <p class="validation-error"><?= $errors['advancePayment'] ?? ""  ?></p>
  <label>
    <span>Data zaliczki</span>
    <input type="date" name="advanceDate" value="<?= $data['advanceDate'] ?>">
  </label>
  <p class="validation-error"><?= $errors['advanceDate'] ?? ""  ?></p>
  <input type="submit" value="Zapisz">
</form>