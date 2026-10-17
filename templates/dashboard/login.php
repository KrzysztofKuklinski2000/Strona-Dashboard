<?php
$errors = $params['messages'] ?? [];
$hasError = !empty($errors['general']);
?>

<div class="login-form">
    <form
        action="/auth/login"
        method="POST"
        aria-labelledby="login-title"
        <?= $hasError ? 'aria-describedby="login-error"' : '' ?>
    >
        <input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">
        <h1 id="login-title">Logowanie</h1>

        <?php if ($hasError): ?>
            <p class="login-form__error" id="login-error" role="alert">
                <?= e($errors['general']) ?>
            </p>
        <?php endif ?>

        <label for="login">Login</label>
        <input
            type="text"
            name="login"
            id="login"
            autocomplete="username"
            autocapitalize="none"
            spellcheck="false"
            required
        >

        <label for="password">Hasło</label>
        <div class="login-form__password-field" data-password-field>
            <input
                type="password"
                name="password"
                id="password"
                autocomplete="current-password"
                required
            >
            <button
                class="login-form__password-toggle"
                type="button"
                aria-controls="password"
                aria-label="Pokaż hasło"
                title="Pokaż hasło"
                data-password-toggle
                hidden
            >
                <i class="fa-regular fa-eye" aria-hidden="true" data-password-icon></i>
            </button>
        </div>

        <button class="login-form__submit" type="submit">
            Zaloguj się <i class="fa-solid fa-arrow-right-to-bracket" aria-hidden="true"></i>
        </button>
    </form>
</div>
