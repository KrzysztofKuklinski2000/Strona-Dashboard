<?php
$data = $data ?? null;
$postTypes = $params['postTypes'] ?? [];
$defaultType = (string)(array_key_first($postTypes) ?? '');
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

<h3 class="dashboard-action-header"><?= e($formTitle ?? 'Nowy Post') ?></h3>

<form class="homepage-post-form" action="<?= e($action ?? '') ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <section class="homepage-post-form__type-panel">
        <div class="homepage-post-form__panel-heading">
            <span class="homepage-post-form__panel-icon">
                <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
            </span>
            <span>
                <strong>Układ sekcji</strong>
                <small>Wybierz sposób prezentacji treści na stronie głównej.</small>
            </span>
        </div>

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

    <?php if ($postId !== null): ?>
        <input type="hidden" name="postId" value="<?= e($postId) ?>">
    <?php endif; ?>
    <p class="validation-error"><?= e($errors['postType'] ?? '') ?></p>

    <section class="homepage-post-form__preview-panel">
        <div class="homepage-post-form__panel-heading homepage-post-form__panel-heading--content">
            <span class="homepage-post-form__panel-icon">
                <i class="fa-regular fa-pen-to-square" aria-hidden="true"></i>
            </span>
            <span>
                <strong>Zawartość sekcji</strong>
                <small>Uzupełnij pola właściwe dla wybranego układu.</small>
            </span>
        </div>

        <div class="homepage-post-form__preview-content">
            <div class="homepage-post-form__base-fields">
                <label class="homepage-post-form__title-field">
                    <span>Tytuł sekcji</span>
                    <input type="text" name="postTitle" maxlength="100" value="<?= e($titleValue) ?>" placeholder="np. Więcej niż sport">
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
                    <?php require 'templates/dashboard/homepage/post_forms/' . $partial; ?>
                </div>
            <?php endforeach ?>
        </div>
    </section>

    <div class="homepage-post-form__actions">
        <button
                class="homepage-post-form__action homepage-post-form__action--draft"
                type="submit"
                name="submitAction"
                value="draft"
        >
            Zapisz szkic
        </button>

        <button
                class="homepage-post-form__action homepage-post-form__action--publish"
                type="submit"
                name="submitAction"
                value="publish"
        >
            Opublikuj
        </button>
    </div>
</form>
