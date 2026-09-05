<?php
$data = $data ?? null;
$postTypes = $params['postTypes'] ?? [];
$defaultType = (string) (array_key_first($postTypes) ?? '');
$oldInput = $params['flash_dashboard']['context']['oldInput'] ?? [];
$currentType = $oldInput['postType']
    ?? $data->type
    ?? $defaultType;

if (!isset($postTypes[$currentType])) {
    $currentType = $defaultType;
}

$postId = $oldInput['postId']
    ?? $data->id
    ?? null;

$titleValue = $oldInput['postTitle']
    ?? $data->title
    ?? '';

$payload = $oldInput['payload']
    ?? json_decode((string) ($data->payload ?? ''), true)
    ?? [];
?>

<h3 class="dashboard-action-header"><?= e($formTitle ?? 'Nowa aktualność') ?></h3>

<form class="homepage-post-form news-post-form" action="<?= e($action ?? '') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <section class="homepage-post-form__type-panel">
        <div class="homepage-post-form__type-row">
            <label for="news-post-type-select">Typ aktualności</label>

            <select id="news-post-type-select" name="postType" data-post-type-select>
                <?php foreach ($postTypes as $typeName => $typeProperties): ?>
                    <option value="<?= e($typeName) ?>" <?= $currentType === $typeName ? 'selected' : '' ?>>
                        <?= e($typeProperties['label'] ?? $typeName) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
    </section>

    <?php if ($postId !== null): ?>
        <input type="hidden" name="postId" value="<?= e($postId) ?>">
    <?php endif ?>
    <p class="validation-error"><?= e($errors['postType'] ?? '') ?></p>

    <section class="homepage-post-form__preview-panel">
        <div class="homepage-post-form__preview-content">
            <div class="homepage-post-form__base-fields">
                <label class="homepage-post-form__title-field">
                    <span>Tytuł aktualności</span>
                    <input
                        type="text"
                        name="postTitle"
                        maxlength="60"
                        value="<?= e($titleValue) ?>"
                        placeholder="Wpisz tytuł aktualności"
                    >
                </label>
                <p class="validation-error"><?= e($errors['postTitle'] ?? '') ?></p>
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
                    <?php require 'templates/dashboard/news/post_forms/' . $partial; ?>
                </div>
            <?php endforeach ?>
        </div>
    </section>

    <div class="homepage-post-form__actions">
        <input type="submit" value="<?= e($buttonTitle ?? 'Stwórz') ?>">
    </div>
</form>
