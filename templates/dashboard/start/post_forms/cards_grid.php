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

<input
    type="text"
    name="payload[eyebrow]"
    maxlength="80"
    value="<?= e($payload['eyebrow'] ?? '') ?>"
    placeholder="Mały nagłówek"
>
<p class="validation-error"><?= e($errors['payload.eyebrow'] ?? '') ?></p>

<?php foreach ($cards as $index => $card): ?>
    <fieldset>
        <legend>Kafelek <?= (int) $index + 1 ?></legend>

        <input
            type="text"
            name="payload[cards][<?= (int) $index ?>][icon]"
            maxlength="80"
            value="<?= e($card['icon'] ?? '') ?>"
            placeholder="Ikona, np. fa-solid fa-shield-halved"
        >
        <p class="validation-error"><?= e($errors["payload.cards.$index.icon"] ?? '') ?></p>

        <input
            type="text"
            name="payload[cards][<?= (int) $index ?>][title]"
            maxlength="80"
            value="<?= e($card['title'] ?? '') ?>"
            placeholder="Tytuł kafelka"
        >
        <p class="validation-error"><?= e($errors["payload.cards.$index.title"] ?? '') ?></p>

        <textarea
            name="payload[cards][<?= (int) $index ?>][description]"
            maxlength="500"
            placeholder="Opis kafelka"
        ><?= e($card['description'] ?? '') ?></textarea>
        <p class="validation-error"><?= e($errors["payload.cards.$index.description"] ?? '') ?></p>
    </fieldset>
<?php endforeach ?>
