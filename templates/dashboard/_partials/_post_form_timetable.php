<h3 class="dashboard-action-header"><?= e($formTitle ?? '') ?></h3>
<form action="<?= e($action) ?>" method="POST" class="timetable-create-form dashboard-editor-form timetable-editor-form">
  <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">
  <?php if(isset($data->id)): ?>
  <input type="hidden" name="id" value="<?= e($data->id) ?>">
  <?php endif; ?>

  <section class="dashboard-form-section">
    <header class="dashboard-form-section__header">
      <span class="dashboard-form-section__icon"><i class="fa-solid fa-calendar-week" aria-hidden="true"></i></span>
      <span class="dashboard-form-section__title">
        <strong>Dane zajęć</strong>
        <small>Określ dzień, grupę oraz miejsce treningu.</small>
      </span>
    </header>
    <div class="dashboard-form-grid">
  <label>
    <span>Dzień: </span>
    <select name="day">
      <option <?= ($data->day ?? '') === "PON"   ? 'selected' : '' ?> value="PON"> Poniedziałek </option>
      <option <?= ($data->day ?? '') === "WT"    ? 'selected' : '' ?> value="WT"> Wtorek </option>
      <option <?= ($data->day ?? '') === 'ŚR'    ? 'selected' : '' ?> value="ŚR"> Środa </option>
      <option <?= ($data->day ?? '') === 'CZW'   ? 'selected' : '' ?> value="CZW"> Czwartek </option>
      <option <?= ($data->day ?? '') === 'PT'    ? 'selected' : '' ?> value="PT"> Piątek </option>
      <option <?= ($data->day ?? '') === 'SOB'   ? 'selected' : '' ?> value="SOB"> Sobota </option>
      <option <?= ($data->day ?? '') === 'NIEDZ' ? 'selected' : '' ?> value="NIEDZ"> Niedziela </option>
    </select>
  </label>
  <p class="validation-error"><?= e($error['day'] ?? "")  ?></p>
  <label>
    <span>Miasto: </span>
    <input type="text" name="city" maxlength="30" value="<?= e($data->city ?? '' )?>" placeholder="Miasto">
  </label>
  <p class="validation-error"><?= e($error['city'] ?? "")  ?></p>
  <label>
    <span>Grupa</span>
    <select name="group">
      <option <?= ($data->advancementGroup ?? '') == "Zaawansowana" ? 'selected' : '' ?> value="Zaawansowana"> Zaawansowana </option>
      <option <?= ($data->advancementGroup ?? '') == "Wszyscy"      ? 'selected' : '' ?> value="Wszyscy"> Wszyscy </option>
      <option <?= ($data->advancementGroup ?? '') == "Początkująca" ? 'selected' : '' ?> value="Początkująca"> Początkująca </option>
      <option <?= ($data->advancementGroup ?? '') == "Dzieci"       ? 'selected' : '' ?> value="Dzieci"> Dzieci </option>
      <option <?= ($data->advancementGroup ?? '') == "Kadra"        ? 'selected' : '' ?> value="Kadra"> Kadra </option>
      <option <?= ($data->advancementGroup ?? '') == "Początkująca dzieci" ? 'selected' : '' ?> value="Początkująca dzieci">Początkująca dzieci</option>
    </select>
  </label>
  <p class="validation-error"><?= e($error['group'] ?? "")  ?></p>
  <label>
    <span>Opis miejsca: </span>
    <input type="text" name="place" maxlength="100" value="<?= e($data->place ?? '') ?>" placeholder="Miejsce">
  </label>
  <p class="validation-error"><?= e($error['place'] ?? "")  ?></p>

    </div>
  </section>

  <section class="dashboard-form-section">
    <header class="dashboard-form-section__header">
      <span class="dashboard-form-section__icon"><i class="fa-regular fa-clock" aria-hidden="true"></i></span>
      <span class="dashboard-form-section__title">
        <strong>Godziny i powiadomienie</strong>
        <small>Ustaw czas rozpoczęcia i zakończenia treningu.</small>
      </span>
    </header>
    <div class="dashboard-form-grid">
  <label>
    <span>Start:</span>
    <input type="time" name="startTime" value="<?= e($data->start ?? '') ?>">
  </label>
  <p class="validation-error"><?= e($error['startTime'] ?? "")  ?></p>
  <label>
    <span>Koniec:</span>
    <input type="time" name="endTime" value="<?= e($data->end ?? '') ?>">
  </label>
  <p class="validation-error"><?= e($error['endTime'] ?? "")  ?></p>

    </div>

  <label class="dashboard-form-check">
    <input type="checkbox" name="is_notify">
    <span>
      <strong>Powiadom subskrybentów</strong>
      <small>Wyślij wiadomość o zmianie w grafiku.</small>
    </span>
  </label>
  </section>

  <div class="dashboard-form-actions">
    <input type="submit" value="Zapisz">
    <span>Zmiany zostaną zapisane w publicznym grafiku zajęć.</span>
  </div>
</form>
