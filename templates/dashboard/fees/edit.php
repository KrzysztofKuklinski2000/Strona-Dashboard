<?php

use App\DTO\Dashboard\Fees\FeesDto;

/** @var FeesDto $data */
$data = $params['data'];
$csrf = $params['csrf_token'];
$errors = $params['flash_dashboard']['message'] ?? [];
$oldInput = $params['flash_dashboard']['context']['oldInput'] ?? [];
?>

<h3 class="dashboard-action-header">Edycja składek</h3>

<form action="/dashboard/fees/update" method="POST" class="price-form dashboard-editor-form">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon"><i class="fa-regular fa-calendar" aria-hidden="true"></i></span>
            <span class="dashboard-form-section__title">
                <strong>Składki miesięczne</strong>
                <small>Kwoty obowiązujące przy płatności za jeden miesiąc.</small>
            </span>
        </header>
        <div class="dashboard-form-grid dashboard-form-grid--three">

    <label>
        <span>Jedna osoba — składka ulgowa (zł)</span>
        <input type="number" name="n1" value="<?= e($oldInput['n1'] ?? $data->reducedContribution1Month) ?>" placeholder="np. 80">
    </label>
    <p class="validation-error"><?= e($errors['n1'] ?? "")  ?></p>

    <label>
        <span>Dwie osoby — składka ulgowa (zł)</span>
        <input type="number" name="n2" value="<?= e($oldInput['n2'] ?? $data->reducedContribution2Month) ?>" placeholder="np. 140">
    </label>
    <p class="validation-error"><?= e($errors['n2'] ?? "")  ?></p>

    <label>
        <span>Składka rodzinna (zł)</span>
        <input type="number" name="n3" value="<?= e($oldInput['n3'] ?? $data->familyContributionMonth) ?>" placeholder="np. 180">
    </label>
    <p class="validation-error"><?= e($errors['n3'] ?? "")  ?></p>

        </div>
    </section>

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i></span>
            <span class="dashboard-form-section__title">
                <strong>Składki roczne</strong>
                <small>Kwoty obowiązujące przy płatności za cały rok.</small>
            </span>
        </header>
        <div class="dashboard-form-grid dashboard-form-grid--three">

    <label>
        <span>Jedna osoba — składka ulgowa (zł)</span>
        <input type="number" name="n6" value="<?= e($oldInput['n6'] ?? $data->reducedContribution1Year) ?>" placeholder="np. 800">
    </label>
    <p class="validation-error"><?= e($errors['n6'] ?? "")  ?></p>

    <label>
        <span>Dwie osoby — składka ulgowa (zł)</span>
        <input type="number" name="n7" value="<?= e($oldInput['n7'] ?? $data->reducedContribution2Year) ?>" placeholder="np. 1400">
    </label>
    <p class="validation-error"><?= e($errors['n7'] ?? "")  ?></p>

    <label>
        <span>Składka rodzinna (zł)</span>
        <input type="number" name="n8" value="<?= e($oldInput['n8'] ?? $data->familyContributionYear) ?>" placeholder="np. 1800">
    </label>
    <p class="validation-error"><?= e($errors['n8'] ?? "")  ?></p>

        </div>
    </section>

    <section class="dashboard-form-section">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon"><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i></span>
            <span class="dashboard-form-section__title">
                <strong>Informacje na stronie</strong>
                <small>Treści wyświetlane nad i pod zestawieniem składek.</small>
            </span>
        </header>
        <div class="dashboard-form-grid">

    <label>
        <span>Informacja nad składkami</span>
        <textarea name="n10" placeholder="Krótka informacja wprowadzająca..."><?= e($oldInput['n10'] ?? $data->extraInformation) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['n10'] ?? "")  ?></p>

    <label>
        <span>Informacja pod składkami</span>
        <textarea name="n11" placeholder="Dodatkowe zasady lub wyjaśnienia..."><?= e($oldInput['n11'] ?? $data->feesInformation) ?></textarea>
    </label>
    <p class="validation-error"><?= e($errors['n11'] ?? "")  ?></p>

        </div>
    </section>

    <div class="dashboard-form-actions">
        <span>Zmiany będą widoczne na publicznej stronie po zapisaniu.</span>
        <input type="submit" value="Zapisz">
    </div>
</form>
