<?php
$postTypes = $params['postTypes'] ?? [];
$defaultType = (string)(array_key_first($postTypes) ?? '');
$currentType = $data->type ?? $defaultType;

if (!isset($postTypes[$currentType])) {
    $currentType = $defaultType;
}
?>

<h3><?= e($formTitle ?? 'Nowy Post') ?></h3>

<form class="homepage-post-form" action="<?= e($action ?? '') ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <section class="homepage-post-form__type-panel">
        <div class="homepage-post-form__type-row">
            <label for="post-type-select">Typ posta</label>

            <select id="post-type-select" name="postType" data-post-type-select>
                <?php foreach ($postTypes as $typeName => $typeProperties): ?>
                    <option value="<?= e($typeName) ?>" <?= $currentType === $typeName ? 'selected' : '' ?>>
                        <?= e($typeProperties['label'] ?? $typeName) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </section>

    <?php if (isset($data->id)): ?>
        <input type="hidden" name="postId" value="<?= e($data->id) ?>">
    <?php endif; ?>
    <p class="validation-error"><?= e($errors['postType'] ?? '') ?></p>

    <section class="homepage-post-form__preview-panel">
        <div class="homepage-post-form__preview-content">
            <div class="homepage-post-form__base-fields">
                <label class="homepage-post-form__title-field">
                    <span>Tytuł sekcji</span>
                    <input type="text" name="postTitle" maxlength="100" value="<?= e($data->title ?? '') ?>" placeholder="np. Więcej niż sport">
                </label>
                <p class="validation-error"><?= e($errors['postTitle'] ?? '') ?></p>

                <label class="homepage-post-form__description-field">
                    <span>Opis sekcji</span>
                    <textarea name="postDescription" placeholder="Krótki opis sekcji, jeśli ten typ posta go używa..."><?= e($data->description ?? '') ?></textarea>
                </label>
                <p class="validation-error"><?= e($errors['postDescription'] ?? '') ?></p>
            </div>

            <?php foreach ($postTypes as $typeName => $typeProperties): ?>
                <?php
                $partial = $typeProperties['partial'] ?? null;

                if (!$partial) {
                    continue;
                }

                $isActive = $currentType === $typeName;
                ?>

                <div
                    class="post-type-fields"
                    data-post-type-form="<?= e($typeName) ?>"
                    <?= !$isActive ? 'hidden' : '' ?>
                >
                    <?php require 'templates/dashboard/start/post_forms/' . $partial; ?>
                </div>
            <?php endforeach ?>
        </div>
    </section>

    <div class="homepage-post-form__actions">
        <input type="submit" value="<?= e($buttonTitle ?? 'Stwórz') ?>">
    </div>
</form>
