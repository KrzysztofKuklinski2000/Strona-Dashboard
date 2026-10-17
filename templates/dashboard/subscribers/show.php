<?php
declare(strict_types=1);

$data = $params['data'];
$isActive = $data->isActive === 1;
?>
<div class="list-header">
    <h3>Szczegóły subskrybenta</h3>
    <div class="list-header__actions">
        <a href="/dashboard/subscribers" class="list-header__action--secondary">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Wróć do listy</span>
        </a>
    </div>
</div>

<div class="dashboard-action-page">
    <div class="post-content">
        <article class="homepage-post-details">
            <section class="homepage-post-details__content" aria-labelledby="subscriber-email">
                <p class="homepage-post-details__eyebrow">Adres e-mail</p>
                <h4 class="subscriber-details__email" id="subscriber-email"><?= e($data->email) ?></h4>
            </section>

            <dl class="homepage-post-details__meta subscriber-details__meta">
                <div>
                    <dt>Identyfikator</dt>
                    <dd><?= e($data->id) ?></dd>
                </div>
                <div>
                    <dt>Status</dt>
                    <dd>
                        <span class="dashboard-status-badge <?= $isActive ? 'published' : 'no-published' ?>">
                            <i class="fa-solid <?= $isActive ? 'fa-circle-check' : 'fa-clock' ?>" aria-hidden="true"></i>
                            <?= $isActive ? 'Aktywny' : 'Oczekuje na potwierdzenie' ?>
                        </span>
                    </dd>
                </div>
                <div>
                    <dt>Data potwierdzenia (UTC)</dt>
                    <dd><?= e($data->confirmedAt ?? 'Brak potwierdzenia') ?></dd>
                </div>
            </dl>
        </article>
    </div>
</div>
