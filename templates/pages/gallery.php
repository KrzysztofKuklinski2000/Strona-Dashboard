<?php
$galleryItems = array_values(array_filter(
    $params['content'] ?? [],
    static fn($item): bool => (bool) ($item->status ?? false)
));
$categories = is_array($params['categories'] ?? null)
    ? $params['categories']
    : [];
$selectedCategorySlugs = is_array($params['selectedCategorySlugs'] ?? null)
    ? $params['selectedCategorySlugs']
    : [];
$selectedCategories = array_values(array_filter(
    $categories,
    static fn($category): bool => in_array($category->slug, $selectedCategorySlugs, true)
));
$selectedCategoryNames = array_map(
    static fn($category): string => $category->name,
    $selectedCategories
);

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

$activeCategoryLabel = $selectedCategoryNames === []
    ? 'Wszystkie zdjęcia'
    : implode(' • ', $selectedCategoryNames);
$countContext = $selectedCategoryNames === [] ? 'w galerii' : 'dla wybranych kategorii';
?>

<section class="gallery-page" aria-labelledby="gallery-page-title">
    <div class="gallery-page__inner">
        <section class="gallery-intro" aria-labelledby="gallery-page-title">
            <div class="gallery-intro__content">
                <p>Galeria</p>
                <h2 id="gallery-page-title">Klub w obiektywie</h2>
                <span>
                    Zobacz zdjęcia z treningów, obozów i wydarzeń klubowych.
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

        <?php if ($categories): ?>
            <form id="gallery-filters" class="gallery-filters" action="/galeria" method="GET">
                <fieldset>
                    <legend class="visually-hidden">Wybierz kategorie zdjęć</legend>

                    <div class="gallery-filters__slider">
                        <button
                            class="gallery-filters__arrow gallery-filters__arrow--left"
                            type="button"
                            aria-label="Pokaż poprzednie kategorie"
                        >
                            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                        </button>

                        <div class="gallery-filters__options">
                            <?php foreach ($categories as $category): ?>
                                <?php $isSelected = in_array($category->slug, $selectedCategorySlugs, true); ?>

                                <label class="gallery-filter-option">
                                    <input
                                        type="checkbox"
                                        name="categories[]"
                                        value="<?= e($category->slug) ?>"
                                        <?= $isSelected ? 'checked' : '' ?>
                                    >

                                    <span
                                        class="gallery-filter-option__content"
                                        title="<?= e($category->name) ?>"
                                    >
                                        <span class="gallery-filter-option__check" aria-hidden="true">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                        <span class="gallery-filter-option__label"><?= e($category->name) ?></span>
                                    </span>
                                </label>
                            <?php endforeach ?>
                        </div>

                        <button
                            class="gallery-filters__arrow gallery-filters__arrow--right"
                            type="button"
                            aria-label="Pokaż kolejne kategorie"
                        >
                            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="gallery-filters__actions">
                        <button
                            class="gallery-filters__submit"
                            type="submit"
                            aria-label="Pokaż zdjęcia z wybranych kategorii"
                            title="Pokaż zdjęcia"
                        >
                            <i class="fa-solid fa-filter" aria-hidden="true"></i>
                            <span>Filtruj</span>
                        </button>

                        <a
                            class="gallery-filters__clear <?= $selectedCategorySlugs === [] ? 'is-hidden' : '' ?>"
                            href="/galeria"
                            aria-label="Wyczyść wybrane kategorie"
                            <?= $selectedCategorySlugs === [] ? 'aria-hidden="true" tabindex="-1"' : '' ?>
                        >
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            <span>Wyczyść</span>
                        </a>
                    </div>
                </fieldset>
            </form>
        <?php endif ?>

        <?php if ($galleryItems): ?>
            <div class="gallery-grid">
                <?php foreach ($galleryItems as $index => $item): ?>
                    <?php
                    $categoryLabel = count($selectedCategoryNames) === 1
                        ? $selectedCategoryNames[0]
                        : 'Galeria';
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

<script src="/public/js/gallery-filters.js"></script>
