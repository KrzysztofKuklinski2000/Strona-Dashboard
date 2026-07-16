<h3 class="dashboard-action-header"><?= e($formTitle ?? 'Nowy Post') ?></h3>

<form action="<?= e($action ?? '') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <?php if (isset($data->id)): ?>
        <input type="hidden" name="postId" value="<?= e($data->id) ?>">
    <?php endif; ?>

    <input type="text" name="postTitle" maxlength="100" value="<?= e($data->title ?? '') ?>" placeholder="Tytuł posta">
    <p class="validation-error"><?= e($errors['postTitle'] ?? '') ?></p>

    <textarea name="postDescription" placeholder="Wpisz treść posta"><?= e($data->description ?? '') ?></textarea>
    <p class="validation-error"><?= e($errors['postDescription'] ?? '') ?></p>

    <?php
    if (isset($extraFieldsHtml) && is_string($extraFieldsHtml)) {
        echo $extraFieldsHtml;
    }
    ?>

    <input type="submit" value="<?= e($buttonTitle ?? 'Stwórz') ?>">
</form>
