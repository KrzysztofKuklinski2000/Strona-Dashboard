<?php
$previewHtml = trim((string) ($previewHtml ?? ''));
$previewTitle = (string) ($previewTitle ?? 'Podgląd wpisu na stronie głównej');
$previewDescription = (string) ($previewDescription ?? 'Tak wpis będzie prezentowany na stronie głównej.');
$previewBodyClass = trim((string) ($previewBodyClass ?? 'homepage'));
$previewBodyAttribute = $previewBodyClass !== '' ? ' class="' . e($previewBodyClass) . '"' : '';
$scrollScriptVersion = filemtime(__DIR__ . '/../../../public/js/scroll.js');
?>

<section class="dashboard-post-preview" aria-label="<?= e($previewTitle) ?>">
    <div class="dashboard-post-preview__heading">
        <span class="dashboard-post-preview__icon" aria-hidden="true">
            <i class="fa-regular fa-eye"></i>
        </span>
        <div>
            <h4><?= e($previewTitle) ?></h4>
            <p><?= e($previewDescription) ?></p>
        </div>
    </div>

    <?php if ($previewHtml !== ''): ?>
        <?php
        $previewDocument = <<<HTML
        <!DOCTYPE html>
        <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="/public/style.css">
            <link rel="stylesheet" href="/public/style-res.css">
            <script src="https://kit.fontawesome.com/062ebc24f8.js" crossorigin="anonymous"></script>
            <style>
                html, body {
                    width: 100%;
                    height: auto;
                    min-height: 0;
                    display: block;
                    overflow: hidden;
                }

                body {
                    background: #fff;
                }

                main {
                    width: 100%;
                }

                a {
                    pointer-events: none;
                }
            </style>
        </head>
        <body{$previewBodyAttribute}>
            <main>
                {$previewHtml}
            </main>
            <script src="/public/js/scroll.js?v={$scrollScriptVersion}"></script>
        </body>
        </html>
        HTML;
        ?>

        <iframe
            class="dashboard-post-preview__frame"
            title="<?= e($previewTitle) ?>"
            srcdoc="<?= e($previewDocument) ?>"
            data-public-post-preview
        ></iframe>
    <?php else: ?>
        <div class="dashboard-post-preview__empty">
            <i class="fa-regular fa-eye-slash" aria-hidden="true"></i>
            <p>Ta sekcja nie wyświetli się na stronie głównej, ponieważ nie ma obecnie zawartości do pokazania.</p>
        </div>
    <?php endif ?>
</section>
