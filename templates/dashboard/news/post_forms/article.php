<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : [];
?>

<label class="homepage-post-form__description-field">
    <span>Treść aktualności</span>
    <textarea
        name="payload[description]"
        maxlength="1000"
        placeholder="Wpisz treść aktualności..."
    ><?= e($payload['description'] ?? '') ?></textarea>
</label>
<p class="validation-error"><?= e($errors['payload.description'] ?? '') ?></p>
