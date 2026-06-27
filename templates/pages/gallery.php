<?php
$galleryItems = array_values(array_filter(
    $params['content'] ?? [],
    static fn($item): bool => (bool) ($item->status ?? false)
));
$currentCategory = $params['category'] ?? null;

$categoryLabels = [
    'training' => 'Treningi',
    'camp' => 'Obozy',
];

$formatPhotoCount = static function (int $count): string {
    $lastDigit = $count % 10;
    $lastTwoDigits = $count % 100;
    $label = 'zdjęć';

    if ($count === 1) {
        $label = 'zdjęcie';
    } elseif ($lastDigit >= 2 && $lastDigit <= 4 && ($lastTwoDigits < 12 || $lastTwoDigits > 14)) {
        $label = 'zdjęcia';
    }

    return $count . ' ' . $label;
};

$filters = [
    'all' => [
        'label' => 'Wszystkie',
        'href' => '/galeria',
        'category' => null,
    ],
    'training' => [
        'label' => 'Treningi',
        'href' => '/galeria/training',
        'category' => 'training',
    ],
    'camp' => [
        'label' => 'Obozy',
        'href' => '/galeria/camp',
        'category' => 'camp',
    ],
];

$activeCategoryLabel = $categoryLabels[$currentCategory] ?? 'Wszystkie zdjęcia';
$countContext = $currentCategory === null ? 'w galerii' : 'w tej kategorii';
?>

<section class="gallery-page" aria-labelledby="gallery-page-title">
    <div class="gallery-page__inner">
        <section class="gallery-intro" aria-labelledby="gallery-page-title">
            <div class="gallery-intro__content">
                <p>Galeria</p>
                <h2 id="gallery-page-title">Klub w obiektywie</h2>
                <span>
                    Zobacz zdjęcia z treningów, obozów i wydarzeń klubowych. Galeria jest tworzona z opublikowanych
                    materiałów dodanych w panelu administracyjnym.
                </span>
            </div>

            <aside class="gallery-intro__stats" aria-labelledby="gallery-stats-title">
                <span aria-hidden="true">
                    <i class="fa-regular fa-images"></i>
                </span>

                <div>
                    <p>Aktualny widok</p>
                    <h3 id="gallery-stats-title"><?= e($activeCategoryLabel) ?></h3>
                    <small><?= e($formatPhotoCount(count($galleryItems))) ?> <?= e($countContext) ?></small>
                </div>
            </aside>
        </section>

        <nav class="gallery-filters" aria-label="Filtry galerii">
            <?php foreach ($filters as $filter): ?>
                <?php $isActive = $filter['category'] === $currentCategory; ?>

                <a class="<?= $isActive ? 'is-active' : '' ?>" href="<?= e($filter['href']) ?>">
                    <?= e($filter['label']) ?>
                </a>
            <?php endforeach ?>
        </nav>

        <?php if ($galleryItems): ?>
            <div class="gallery-grid">
                <?php foreach ($galleryItems as $index => $item): ?>
                    <?php
                    $category = $item->category ?? null;
                    $categoryLabel = $categoryLabels[$category] ?? 'Galeria';
                    $description = trim((string) ($item->description ?? ''));
                    $imageDescription = $description !== '' ? $description : 'Zdjęcie z galerii klubowej';
                    $imagePath = '/public/uploads/' . rawurlencode((string) $item->imageName);
                    ?>

                    <article class="gallery-card <?= $index === 0 ? 'gallery-card--featured' : '' ?>">
                        <img src="<?= e($imagePath) ?>" alt="<?= e($imageDescription) ?>" loading="lazy">

                        <div class="gallery-card__overlay">
                            <p><?= e($categoryLabel) ?></p>
                            <h3><?= e($imageDescription) ?></h3>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="gallery-empty">
                <i class="fa-regular fa-images" aria-hidden="true"></i>
                <h2>Brak zdjęć w galerii</h2>
                <p>Opublikowane zdjęcia pojawią się tutaj po dodaniu ich w panelu administracyjnym.</p>
            </div>
        <?php endif ?>
    </div>
</section>
