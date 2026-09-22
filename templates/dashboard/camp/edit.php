<?php

use App\DTO\Dashboard\Camp\CampDto;

/** @var CampDto $data */
$data = $params['data'];
$csrf = $params['csrf_token'];
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<h3 class="dashboard-action-header">Edycja obozu</h3>

<form action="/dashboard/camp/update" method="POST" class="camp-form dashboard-editor-form">
    <input type="hidden" name="csrf_token" value="<?= e($csrf  ?? '') ?>">

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
            <span class="dashboard-form-section__title">
                <strong>Miejsce obozu</strong>
                <small>Podstawowe informacje o miejscowości i obiekcie.</small>
            </span>
        </header>
        <div class="dashboard-form-grid">

    <label>
        <span>Miejscowość:</span>
        <input type="text" name="town" value="<?= e($data->city) ?>" placeholder="np. Zakopane">
    </label>
    <p class="validation-error"><?= e($errors['town'] ?? "")  ?></p>

    <label>
        <span>Nazwa pensjonatu lub ośrodka</span>
        <input type="text" name="guesthouse" value="<?= e($data->guesthouse) ?>" placeholder="Nazwa pensjonatu lub ośrodka">
    </label>
    <p class="validation-error"><?= e($errors['guesthouse'] ?? "")  ?></p>

        </div>
    </section>

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon"><i class="fa-solid fa-route" aria-hidden="true"></i></span>
            <span class="dashboard-form-section__title">
                <strong>Termin i podróż</strong>
                <small>Miejsce zbiórki oraz planowany wyjazd i powrót.</small>
            </span>
        </header>
        <div class="dashboard-form-grid dashboard-form-grid--three">

    <label>
        <span>Miejsce wyjazdu: </span>
        <input type="text" name="townStart" value="<?= e($data->cityStart) ?>" placeholder="Miejscowość lub dokładne miejsce zbiórki">
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

        </div>
    </section>

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon"><i class="fa-solid fa-bed" aria-hidden="true"></i></span>
            <span class="dashboard-form-section__title">
                <strong>Warunki pobytu</strong>
                <small>Zakwaterowanie, opieka i elementy programu obozu.</small>
            </span>
        </header>
        <div class="dashboard-form-grid">

    <label>
        <span>Pełna nazwa i adres obiektu</span>
        <textarea name="place" placeholder="Pełna nazwa i adres obiektu..."><?= e($data->place) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['place'] ?? "")  ?></p>

    <label>
        <span>Zakwaterowanie: </span>
        <textarea name="accommodation" placeholder="Opisz pokoje i warunki zakwaterowania..."><?= e($data->accommodation) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['accommodation'] ?? "")  ?></p>

    <label>
        <span>Wyżywienie: </span>
        <textarea name="meals" placeholder="Opisz liczbę i rodzaj posiłków..."><?= e($data->meals) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['meals'] ?? "")  ?></p>

    <label>
        <span>Wycieczki:</span>
        <textarea name="trips" placeholder="Planowane wycieczki i atrakcje..."><?= e($data->trips) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['trips'] ?? "")  ?></p>

    <label>
        <span>Kadra:</span>
        <textarea name="staff" placeholder="Informacje o trenerach i opiekunach..."><?= e($data->staff) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['staff'] ?? "")  ?></p>

    <label>
        <span>Transport PKP:</span>
        <textarea name="transport" placeholder="Szczegóły przejazdu i biletów..."><?= e($data->transport) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['transport'] ?? "")  ?></p>

    <label>
        <span>Treningi:</span>
        <textarea name="training" placeholder="Plan i częstotliwość treningów..."><?= e($data->training) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['training'] ?? "")  ?></p>

    <label>
        <span>Ubezpieczenie:</span>
        <textarea name="insurance" placeholder="Zakres ubezpieczenia uczestników..."><?= e($data->insurance) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['insurance'] ?? "")  ?></p>

        </div>
    </section>

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon"><i class="fa-solid fa-wallet" aria-hidden="true"></i></span>
            <span class="dashboard-form-section__title">
                <strong>Koszty i zaliczka</strong>
                <small>Kwota całkowita oraz dane dotyczące rezerwacji miejsca.</small>
            </span>
        </header>
        <div class="dashboard-form-grid dashboard-form-grid--three">

    <label>
        <span>Koszt całkowity (zł):</span>
        <input type="number" name="cost" value="<?= e($data->cost) ?>">
    </label>
    <p class="validation-error"><?= e($errors['cost'] ?? "")  ?></p>

    <label>
        <span>Zaliczka (zł):</span>
        <input type="number" name="advancePayment" value="<?= e($data->advancePayment) ?>">
    </label>
    <p class="validation-error"><?= e($errors['advancePayment'] ?? "")  ?></p>

    <label>
        <span>Termin wpłaty zaliczki</span>
        <input type="date" name="advanceDate" value="<?= e($data->advanceDate) ?>">
    </label>
    <p class="validation-error"><?= e($errors['advanceDate'] ?? "")  ?></p>

        </div>
    </section>

    <div class="dashboard-form-actions">
        <span>Sprawdź termin i kwoty przed zapisaniem zmian.</span>
        <input type="submit" value="Zapisz">
    </div>
</form>
