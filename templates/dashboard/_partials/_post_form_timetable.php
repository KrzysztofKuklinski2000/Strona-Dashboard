<?php
$flash = $params['flash_dashboard'] ?? [];
$error = is_array($flash['message'] ?? null) ? $flash['message'] : [];
$oldInput = $flash['context']['oldInput'] ?? [];
$locations = $params['locations'] ?? [];
$currentLocationId = (string) ($data->locationId ?? '');
$selectedLocationId = (string) ($oldInput['location_id'] ?? $currentLocationId);
$day = $oldInput['day'] ?? ($data->day ?? '');
$group = $oldInput['group'] ?? ($data->advancementGroup ?? '');
?>

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
    <select name="day" aria-describedby="timetable-day-error">
      <option <?= $day === "PON"   ? 'selected' : '' ?> value="PON"> Poniedziałek </option>
      <option <?= $day === "WT"    ? 'selected' : '' ?> value="WT"> Wtorek </option>
      <option <?= $day === 'ŚR'    ? 'selected' : '' ?> value="ŚR"> Środa </option>
      <option <?= $day === 'CZW'   ? 'selected' : '' ?> value="CZW"> Czwartek </option>
      <option <?= $day === 'PT'    ? 'selected' : '' ?> value="PT"> Piątek </option>
      <option <?= $day === 'SOB'   ? 'selected' : '' ?> value="SOB"> Sobota </option>
      <option <?= $day === 'NIEDZ' ? 'selected' : '' ?> value="NIEDZ"> Niedziela </option>
    </select>
    <span class="validation-error" id="timetable-day-error"><?= e($error['day'] ?? '') ?></span>
  </label>
  <label>
    <span>Grupa</span>
    <select name="group" aria-describedby="timetable-group-error">
      <option <?= $group === "Zaawansowana" ? 'selected' : '' ?> value="Zaawansowana"> Zaawansowana </option>
      <option <?= $group === "Wszyscy"      ? 'selected' : '' ?> value="Wszyscy"> Wszyscy </option>
      <option <?= $group === "Początkująca" ? 'selected' : '' ?> value="Początkująca"> Początkująca </option>
      <option <?= $group === "Dzieci"       ? 'selected' : '' ?> value="Dzieci"> Dzieci </option>
      <option <?= $group === "Kadra"        ? 'selected' : '' ?> value="Kadra"> Kadra </option>
      <option <?= $group === "Początkująca dzieci" ? 'selected' : '' ?> value="Początkująca dzieci">Początkująca dzieci</option>
    </select>
    <span class="validation-error" id="timetable-group-error"><?= e($error['group'] ?? '') ?></span>
  </label>

    </div>

    <label for="timetable-location">
      <span>Lokalizacja zajęć</span>
      <select
        id="timetable-location"
        name="location_id"
        aria-describedby="timetable-location-help timetable-location-error"
        required
        <?= $locations === [] ? 'disabled' : '' ?>
      >
        <option value="" disabled <?= $selectedLocationId === '' || $selectedLocationId === '0' ? 'selected' : '' ?>>
          <?= $locations === [] ? 'Brak dostępnych lokalizacji' : 'Wybierz lokalizację' ?>
        </option>
        <?php foreach ($locations as $location): ?>
          <?php $canSelect = $location->status === 1 || (string) $location->id === $currentLocationId; ?>
          <option
            value="<?= e($location->id) ?>"
            <?= (string) $location->id === $selectedLocationId ? 'selected' : '' ?>
            <?= !$canSelect ? 'disabled' : '' ?>
          ><?= e($location->name . ' — ' . $location->city . ', ' . $location->address . ($location->status !== 1 ? ' (nieaktywna)' : '')) ?></option>
        <?php endforeach; ?>
      </select>
      <small id="timetable-location-help">
        <?php if ($locations === []): ?>
          Najpierw <a href="/dashboard/timetable/location/create">dodaj lokalizację</a>
          lub aktywuj istniejącą w <a href="/dashboard/timetable/location">module lokalizacji</a>.
        <?php elseif ($currentLocationId !== '' && $currentLocationId !== '0'): ?>
          Możesz wybrać aktywną lokalizację lub zachować obecnie przypisaną, nawet jeśli jest nieaktywna.
        <?php else: ?>
          Wybierz aktywną lokalizację. Nazwa, miasto i adres są pobierane z modułu lokalizacji.
        <?php endif; ?>
      </small>
    </label>
    <p class="validation-error" id="timetable-location-error"><?= e($error['location_id'] ?? '') ?></p>
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
    <input type="time" name="startTime" value="<?= e($oldInput['startTime'] ?? ($data->start ?? '')) ?>" aria-describedby="timetable-start-error">
    <span class="validation-error" id="timetable-start-error"><?= e($error['startTime'] ?? '') ?></span>
  </label>
  <label>
    <span>Koniec:</span>
    <input type="time" name="endTime" value="<?= e($oldInput['endTime'] ?? ($data->end ?? '')) ?>" aria-describedby="timetable-end-error">
    <span class="validation-error" id="timetable-end-error"><?= e($error['endTime'] ?? '') ?></span>
  </label>

    </div>

  <label class="dashboard-form-check">
    <input type="checkbox" name="is_notify" <?= !empty($oldInput['is_notify']) ? 'checked' : '' ?>>
    <span>
      <strong>Powiadom subskrybentów</strong>
      <small>Wyślij wiadomość o zmianie w grafiku.</small>
    </span>
  </label>
  </section>

  <div class="dashboard-form-actions">
    <input type="submit" value="Zapisz" <?= $locations === [] ? 'disabled' : '' ?>>
    <span>Zmiany zostaną zapisane w publicznym grafiku zajęć.</span>
  </div>
</form>
