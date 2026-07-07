<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);

$image = $payload['image'] ?? [];
$items = $payload['items'] ?? [];
$link = $payload['link'] ?? [];

if (!$items) {
    $items = ['', '', ''];
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

<input
    type="text"
    name="payload[image][src]"
    maxlength="255"
    value="<?= e($image['src'] ?? '') ?>"
    placeholder="Ścieżka obrazka"
>
<p class="validation-error"><?= e($errors['payload.image.src'] ?? '') ?></p>

<input
    type="text"
    name="payload[image][alt]"
    maxlength="160"
    value="<?= e($image['alt'] ?? '') ?>"
    placeholder="Opis alternatywny obrazka"
>
<p class="validation-error"><?= e($errors['payload.image.alt'] ?? '') ?></p>

<?php foreach ($items as $index => $item): ?>
    <input
        type="text"
        name="payload[items][<?= (int) $index ?>]"
        maxlength="160"
        value="<?= e($item) ?>"
        placeholder="Punkt listy <?= (int) $index + 1 ?>"
    >
    <p class="validation-error"><?= e($errors["payload.items.$index"] ?? '') ?></p>
<?php endforeach ?>

<input
    type="text"
    name="payload[link][label]"
    maxlength="80"
    value="<?= e($link['label'] ?? '') ?>"
    placeholder="Etykieta linku"
>
<p class="validation-error"><?= e($errors['payload.link.label'] ?? '') ?></p>

<input
    type="text"
    name="payload[link][url]"
    maxlength="255"
    value="<?= e($link['url'] ?? '') ?>"
    placeholder="Adres linku"
>
<p class="validation-error"><?= e($errors['payload.link.url'] ?? '') ?></p>
