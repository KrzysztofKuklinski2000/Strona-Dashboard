<?php
  $errors = $params['messages'] ?? [];
?>

<div class="login-form">
  <form action="/auth/login" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
    <h1>Logowanie</h1>
    <label for="login">Login</label>
    <input type="text" name="login" id="login">
    <?php if ($errors['login'] ?? null): ?>
      <p class="error"><i><?php echo $errors['login']; ?></i></p>
    <?php endif ?>
    <label for="pasword">Hasło</label>
    <input type="password" name="password" id="password">
    <?php if ($errors['password'] ?? null): ?>
      <p class="error"><i><?php echo $errors['password']; ?></i></p>
    <?php endif ?>
    <button>Zaloguj się <i class="fa-solid fa-arrow-right-to-bracket"></i></button>
  </form>
</div>