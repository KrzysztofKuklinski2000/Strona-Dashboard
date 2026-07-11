<?php
$postTypes = $params['postTypes'] ?? [];
$defaultType = (string)(array_key_first($postTypes) ?? '');
?>

<h3><?= e($formTitle ?? 'Nowy Post') ?></h3>

<form action="<?= e($action ?? '') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <select name="postType" data-post-type-select>
        <?php foreach ($postTypes as $typeName => $typeProperties): ?>
            <option value="<?= e($typeName) ?>" <?= ($data->type ?? null) && $data->type === $typeName ? 'selected' : '' ?>>
                <?= e($typeProperties['label'] ?? $typeName) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if (isset($data->id)): ?>
        <input type="hidden" name="postId" value="<?= e($data->id) ?>">
    <?php endif; ?>
    <p class="validation-error"><?= e($errors['postType'] ?? '') ?></p>

    <input type="text" name="postTitle" maxlength="100" value="<?= e($data->title ?? '') ?>" placeholder="Tytuł posta">
    <p class="validation-error"><?= e($errors['postTitle'] ?? '') ?></p>

    <textarea name="postDescription" placeholder="Wpisz treść posta"><?= e($data->description ?? '') ?></textarea>
    <p class="validation-error"><?= e($errors['postDescription'] ?? '') ?></p>
    <?php
    $currentType = $data->type ?? $defaultType;

    if (!isset($postTypes[$currentType])) {
        $currentType = $defaultType;
    }

    ?>

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

    <input type="submit" value="<?= e($buttonTitle ?? 'Stwórz') ?>">
</form>