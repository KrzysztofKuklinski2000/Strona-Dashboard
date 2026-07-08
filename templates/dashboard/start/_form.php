<?php
$postTypes = $params['postTypes'] ?? [];
$defaultType = (string) (array_key_first($postTypes) ?? '');
?>

<h3><?= e($formTitle ?? 'Nowy Post') ?></h3>

<form action="<?= e($action ?? '') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <select name="postType" data-post-type-select>
        <?php foreach ($postTypes as $typeName => $typeProperties): ?>
            <option value="<?= e($typeName) ?>">
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

    <?php foreach ($postTypes as $typeName => $typeProperties): ?>
        <?php
            $payload = [];
            $partial = $typeProperties['partial'] ?? null;
        ?>

        <?php if ($partial): ?>
            <div
                class="post-type-fields"
                data-post-type-form="<?= e($typeName) ?>"
                <?= $defaultType !== $typeName ? 'hidden' : '' ?>
            >
                <?php require 'templates/dashboard/start/post_forms/' . $partial; ?>
            </div>
        <?php endif ?>
    <?php endforeach ?>

    <input type="submit" value="<?= e($buttonTitle ?? 'Stwórz') ?>">
</form>
