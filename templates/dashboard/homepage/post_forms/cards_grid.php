<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);

$cards = $payload['cards'] ?? [];

if (!$cards) {
    $cards = [
        ['icon' => '', 'title' => '', 'description' => ''],
        ['icon' => '', 'title' => '', 'description' => ''],
        ['icon' => '', 'title' => '', 'description' => ''],
    ];
}
?>

<div class="cards-grid-form">
    <div class="cards-grid-form__eyebrow">
        <label>
            <span>Nadtytuł (eyebrow)</span>
            <input
                type="text"
                name="payload[eyebrow]"
                maxlength="80"
                value="<?= e($payload['eyebrow'] ?? '') ?>"
                placeholder="np. Dlaczego karate?"
            >
        </label>
        <p class="validation-error"><?= e($errors['payload.eyebrow'] ?? '') ?></p>
    </div>

    <div class="cards-grid-form__cards" data-cards-container data-max-cards="12">
        <?php foreach ($cards as $index => $card): ?>
            <fieldset class="cards-grid-form__card" data-card>
                <legend>
                    <span data-card-number><?= (int) $index + 1 ?></span>
                    <strong data-card-title>Kafelek <?= (int) $index + 1 ?></strong>
                    <button type="button" class="cards-grid-form__remove" data-remove-card aria-label="Usuń kafelek <?= (int) $index + 1 ?>">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </legend>

                <label>
                    <span>Ikona</span>
                    <input
                        type="text"
                        data-card-field="icon"
                        name="payload[cards][<?= (int) $index ?>][icon]"
                        maxlength="80"
                        value="<?= e($card['icon'] ?? '') ?>"
                        placeholder="<?= e($index === 0 ? 'fa-solid fa-child-reaching' : ($index === 1 ? 'fa-solid fa-shield-halved' : 'fa-solid fa-people-group')) ?>"
                    >
                </label>
                <p class="validation-error"><?= e($errors["payload.cards.$index.icon"] ?? '') ?></p>

                <label>
                    <span>Tytuł kafelka</span>
                    <input
                        type="text"
                        data-card-field="title"
                        name="payload[cards][<?= (int) $index ?>][title]"
                        maxlength="80"
                        value="<?= e($card['title'] ?? '') ?>"
                        placeholder="<?= e($index === 0 ? 'Siła i sprawność' : ($index === 1 ? 'Charakter i dyscyplina' : 'Społeczność')) ?>"
                    >
                </label>
                <p class="validation-error"><?= e($errors["payload.cards.$index.title"] ?? '') ?></p>

                <label>
                    <span>Opis kafelka</span>
                    <textarea
                        data-card-field="description"
                        name="payload[cards][<?= (int) $index ?>][description]"
                        maxlength="500"
                        placeholder="<?= e($index === 0 ? 'Poprawiamy kondycję...' : ($index === 1 ? 'Uczymy szacunku...' : 'Trenujemy razem...')) ?>"
                    ><?= e($card['description'] ?? '') ?></textarea>
                </label>
                <p class="validation-error"><?= e($errors["payload.cards.$index.description"] ?? '') ?></p>
            </fieldset>
        <?php endforeach ?>
    </div>
    <p class="validation-error"><?= e($errors['payload.cards'] ?? '') ?></p>

    <button type="button" class="cards-grid-form__add" data-add-card>
        <i class="fa-solid fa-plus" aria-hidden="true"></i>
        Dodaj kafelek
    </button>

    <template data-card-template>
        <fieldset class="cards-grid-form__card" data-card>
            <legend>
                <span data-card-number></span>
                <strong data-card-title></strong>
                <button type="button" class="cards-grid-form__remove" data-remove-card aria-label="Usuń kafelek">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </legend>

            <label>
                <span>Ikona</span>
                <input type="text" data-card-field="icon" maxlength="80" placeholder="np. fa-solid fa-star">
            </label>

            <label>
                <span>Tytuł kafelka</span>
                <input type="text" data-card-field="title" maxlength="80" placeholder="Tytuł nowego kafelka">
            </label>

            <label>
                <span>Opis kafelka</span>
                <textarea data-card-field="description" maxlength="500" placeholder="Opis nowego kafelka"></textarea>
            </label>
        </fieldset>
    </template>
</div>
