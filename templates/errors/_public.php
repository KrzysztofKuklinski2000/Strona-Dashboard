<?php
$escapeError = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$errorStyleVersion = filemtime(__DIR__ . '/../../public/style.css');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title><?= $escapeError($errorTitle) ?> – Karate Kyokushin Wejherowo / Reda</title>
    <link rel="icon" href="/public/images/logo.png">
    <link rel="stylesheet" href="/public/style.css?v=<?= $errorStyleVersion ?>">
</head>
<body class="public-error-page">
    <header class="public-error-page__header">
        <a class="site-brand" href="/" aria-label="Strona główna Karate Kyokushin Wejherowo / Reda">
            <span class="site-brand__icons" aria-hidden="true">
                <img class="site-brand__emblem" src="/public/images/logo.png" alt="">
                <img class="site-brand__calligraphy" src="/public/images/logo.gif" alt="">
            </span>
            <span class="site-brand__text">
                <strong><span>Karate</span><span>Kyokushin</span></strong>
                <small>Wejherowo / Reda</small>
            </span>
        </a>
    </header>
    <main class="public-error-page__main">
        <section class="public-error-card" aria-labelledby="error-title">
            <p class="public-error-card__code" aria-label="Błąd <?= $escapeError($errorCode) ?>"><?= $escapeError($errorCode) ?></p>
            <h1 id="error-title"><?= $escapeError($errorTitle) ?></h1>
            <p class="public-error-card__description"><?= $escapeError($errorDescription) ?></p>
            <div class="public-error-card__actions">
                <a class="public-error-card__home" href="/">Wróć na stronę główną</a>
                <a class="public-error-card__contact" href="/kontakt">Kontakt z klubem</a>
            </div>
        </section>
    </main>
</body>
</html>
