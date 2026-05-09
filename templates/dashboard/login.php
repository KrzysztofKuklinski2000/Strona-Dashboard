<?php
$errors = $params['messages'] ?? [];
?>

<div class="login-form">
    <form action="/auth/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
        <h1>Logowanie</h1>

        <?php if ($errors['general'] ?? null): ?>
            <div class="error-box" style="color: red; margin-bottom: 15px; font-weight: bold; text-align: center;">
                <?php echo $errors['general']; ?>
            </div>
        <?php endif ?>

        <label for="login">Login</label>
        <input type="text" name="login" id="login" required>

        <label for="password">Hasło</label>
        <input type="password" name="password" id="password" required>

        <button>Zaloguj się <i class="fa-solid fa-arrow-right-to-bracket"></i></button>
    </form>
</div>