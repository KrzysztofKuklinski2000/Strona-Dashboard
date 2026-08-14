<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);
?>

<label class="homepage-post-form__description-field">
    <span>Opis sekcji</span>
    <textarea
        name="payload[description]"
        maxlength="1000"
        placeholder="Wpisz treść sekcji..."
    ><?= e($payload['description'] ?? '') ?></textarea>
</label>
<p class="validation-error"><?= e($errors['payload.description'] ?? '') ?></p>
