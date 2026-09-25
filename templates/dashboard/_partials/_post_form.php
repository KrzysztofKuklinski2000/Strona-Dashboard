<h3 class="dashboard-action-header"><?= e($formTitle ?? 'Nowy Post') ?></h3>

<form action="<?= e($action ?? '') ?>" method="POST" class="dashboard-editor-form important-post-form">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

    <?php if (isset($data->id)): ?>
        <input type="hidden" name="postId" value="<?= e($data->id) ?>">
    <?php endif; ?>

    <section class="dashboard-form-section dashboard-form-section--important">
        <header class="dashboard-form-section__header">
            <span class="dashboard-form-section__icon"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i></span>
            <span class="dashboard-form-section__title">
                <strong>Treść ważnej informacji</strong>
                <small>Tytuł powinien szybko wyjaśniać temat, a opis przekazywać wszystkie szczegóły.</small>
            </span>
        </header>

        <label>
            <span>Tytuł komunikatu</span>
            <input type="text" name="postTitle" maxlength="60" value="<?= e($data->title ?? '') ?>" placeholder="Krótki tytuł ważnej informacji">
        </label>
        <p class="validation-error"><?= e($errors['postTitle'] ?? '') ?></p>

        <label>
            <span>Treść komunikatu</span>
            <textarea name="postDescription" placeholder="Opisz ważną informację i podaj potrzebne szczegóły..."><?= e($data->description ?? '') ?></textarea>
        </label>
        <p class="validation-error"><?= e($errors['postDescription'] ?? '') ?></p>

        <?php
        if (isset($extraFieldsHtml) && is_string($extraFieldsHtml)) {
            echo $extraFieldsHtml;
        }
        ?>

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
