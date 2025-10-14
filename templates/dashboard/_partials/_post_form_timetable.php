<br>
<h3><?= $formTitle ?? "" ?></h3>
<br>
<form action="<?= $action ?>" method="POST" class="timetable-create-form">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?? '' ?>">
  <?php if(isset($data['id'])): ?>
  <input type="hidden" name="id" value="<?= $data['id'] ?>">
  <?php endif; ?>
  <label>
    <span>Dzień: </span>
    <select name="day">
      <option <?= ($data['day'] ?? '') === "PON"   ? 'selected' : '' ?> value="PON"> Poniedziałek </option>
      <option <?= ($data['day'] ?? '') === "WT"    ? 'selected' : '' ?> value="WT"> Wtorek </option>
      <option <?= ($data['day'] ?? '') === 'ŚR'    ? 'selected' : '' ?> value="ŚR"> Środa </option>
      <option <?= ($data['day'] ?? '') === 'CZW'   ? 'selected' : '' ?> value="CZW"> Czwartek </option>
      <option <?= ($data['day'] ?? '') === 'PT'    ? 'selected' : '' ?> value="PT"> Piątek </option>
      <option <?= ($data['day'] ?? '') === 'SOB'   ? 'selected' : '' ?> value="SOB"> Sobota </option>
      <option <?= ($data['day'] ?? '') === 'NIEDZ' ? 'selected' : '' ?> value="NIEDZ"> Niedziela </option>
    </select>
  </label>
  <p class="validation-error"><?= $error['day'] ?? ""  ?></p>
  <label>
    <span>Miasto: </span>
    <input type="text" name="city" maxlength="30" value="<?= $data['city'] ?? '' ?>" placeholder="Miasto">
  </label>
  <p class="validation-error"><?= $error['city'] ?? ""  ?></p>
  <label>
    <span>Grupa</span>
    <select name="group">
      <option <?= ($data['advancement_group'] ?? '') == "Zaawansowana" ? 'selected' : '' ?> value="Zaawansowana"> Zaawansowana </option>
      <option <?= ($data['advancement_group'] ?? '') == "Wszyscy"      ? 'selected' : '' ?> value="Wszyscy"> Wszyscy </option>
      <option <?= ($data['advancement_group'] ?? '') == "Początkująca" ? 'selected' : '' ?> value="Początkująca"> Początkująca </option>
      <option <?= ($data['advancement_group'] ?? '') == "Dzieci"       ? 'selected' : '' ?> value="Dzieci"> Dzieci </option>
      <option <?= ($data['advancement_group'] ?? '') == "Kadra"        ? 'selected' : '' ?> value="Kadra"> Kadra </option>
      <option <?= ($data['advancement_group'] ?? '') == "Początkująca dzieci" ? 'selected' : '' ?> value="Początkująca dzieci">Początkująca dzieci</option>
    </select>
  </label>
  <p class="validation-error"><?= $error['group'] ?? ""  ?></p>
  <label>
    <span>Opis miejsca: </span>
    <input type="text" name="place" maxlength="100" value="<?= $data['place'] ?? '' ?>" placeholder="Miejsce">
  </label>
  <p class="validation-error"><?= $error['place'] ?? ""  ?></p>
  <label>
    <span>Start:</span>
    <input type="time" name="startTime" value="<?= $data['start'] ?? '' ?>">
  </label>
  <p class="validation-error"><?= $error['startTime'] ?? ""  ?></p>
  <label>
    <span>Koniec:</span>
    <input type="time" name="endTime" value="<?= $data['end'] ?? '' ?>">
  </label>
  <p class="validation-error"><?= $error['endTime'] ?? ""  ?></p>
  <input type="submit" value="Zapisz">
</form>