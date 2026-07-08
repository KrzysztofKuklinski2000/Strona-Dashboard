<?php
$postTypes = $params['postTypes'] ?? [];
?>

<h3><?= e($formTitle ?? 'Nowy Post') ?></h3>

<form action="<?= e($action ?? '') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <select name="postType">
        <?php foreach ($postTypes as $typeName => $typeProperties): ?>
            <option value="<?= e($typeName) ?>"> <?= $typeProperties['label'] ?></option>
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

    <input type="submit" value="<?= e($buttonTitle ?? 'Stwórz') ?>">
</form>
