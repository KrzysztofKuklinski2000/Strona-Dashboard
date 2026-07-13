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

    <div class="cards-grid-form__cards">
        <?php foreach ($cards as $index => $card): ?>
            <fieldset class="cards-grid-form__card">
                <legend>
                    <span><?= (int) $index + 1 ?></span>
                    Kafelek <?= (int) $index + 1 ?>
                </legend>

                <label>
                    <span>Ikona</span>
                    <input
                        type="text"
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
                        name="payload[cards][<?= (int) $index ?>][description]"
                        maxlength="500"
                        placeholder="<?= e($index === 0 ? 'Poprawiamy kondycję...' : ($index === 1 ? 'Uczymy szacunku...' : 'Trenujemy razem...')) ?>"
                    ><?= e($card['description'] ?? '') ?></textarea>
                </label>
                <p class="validation-error"><?= e($errors["payload.cards.$index.description"] ?? '') ?></p>
            </fieldset>
        <?php endforeach ?>
    </div>
</div>
