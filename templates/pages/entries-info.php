<?php
$content = $params['content'];
$contact = $params['contact'] ?? null;
$phone = trim((string) ($contact->phone ?? ''));
$email = trim((string) ($contact->email ?? ''));
$phoneHref = preg_replace('/[^\d+]/', '', $phone);
$formatAmount = static fn(int $amount): string => $amount . ' zł';

$monthlyFees = [
    [
        'title' => 'Jedna osoba',
        'amount' => $content->reducedContribution1Month,
        'description' => 'Składka ulgowa za miesiąc treningów.',
    ],
    [
        'title' => 'Dwie osoby',
        'amount' => $content->reducedContribution2Month,
        'description' => 'Składka ulgowa dla dwóch osób z rodziny.',
    ],
    [
        'title' => 'Rodzina',
        'amount' => $content->familyContributionMonth,
        'description' => 'Składka dla trzech i więcej osób.',
        'featured' => true,
    ],
];

$joinSteps = [
    [
        'title' => 'Skontaktuj się',
        'description' => 'Zadzwoń albo napisz wiadomość. Ustalimy wiek, poziom i najlepszą grupę treningową.',
    ],
    [
        'title' => 'Przyjdź na trening',
        'description' => 'Pierwsze zajęcia są bezpłatne, więc możesz sprawdzić atmosferę i sposób prowadzenia treningu.',
    ],
    [
        'title' => 'Dołącz do grupy',
        'description' => 'Po pierwszych zajęciach instruktor pomoże dobrać dalszy plan treningów i formalności.',
    ],
];

$firstTrainingNotes = [
    [
        'icon' => 'fa-solid fa-shirt',
        'title' => 'Wygodny strój',
        'description' => 'Na start wystarczy koszulka i spodnie sportowe. Karate-gi nie jest wymagane na pierwszych zajęciach.',
    ],
    [
        'icon' => 'fa-solid fa-bottle-water',
        'title' => 'Woda',
        'description' => 'Weź wodę i przyjdź kilka minut wcześniej, żeby spokojnie przygotować się do treningu.',
    ],
    [
        'icon' => 'fa-regular fa-clock',
        'title' => 'Punktualność',
        'description' => 'Sprawdź wcześniej grafik i lokalizację grupy, do której chcesz dołączyć.',
    ],
];
?>

<section class="entries-page" aria-labelledby="entries-page-title">
    <div class="entries-page__inner">
        <section class="entries-intro" aria-labelledby="entries-page-title">
            <div class="entries-intro__content">
                <p>Zapisy</p>
                <h2 id="entries-page-title">Rozpocznij pierwszy trening</h2>
                <span>
                    Do klubu można dołączyć przez cały rok. Wystarczy skontaktować się z nami, a pomożemy dobrać
                    grupę, termin i lokalizację odpowiednią do wieku oraz poziomu zaawansowania.
                </span>
            </div>

            <aside class="entries-intro__note" aria-labelledby="entries-note-title">
                <span aria-hidden="true">
                    <i class="fa-solid fa-medal"></i>
                </span>

                <div>
                    <p>Pierwszy krok</p>
                    <h3 id="entries-note-title">Pierwsze zajęcia za darmo</h3>
                    <small>Przyjdź, zobacz jak wygląda trening i zdecyduj, czy chcesz kontynuować.</small>
                </div>
            </aside>
        </section>

        <section class="entries-steps" aria-labelledby="entries-steps-title">
            <div class="entries-section-heading">
                <p>Jak dołączyć?</p>
                <h2 id="entries-steps-title">Trzy proste kroki</h2>
            </div>

            <div class="entries-step-grid">
                <?php foreach ($joinSteps as $index => $step): ?>
                    <article class="entries-step-card">
                        <strong><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></strong>
                        <h3><?= e($step['title']) ?></h3>
                        <p><?= e($step['description']) ?></p>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <div class="entries-main-grid">
            <section class="entries-contact-panel" aria-labelledby="entries-contact-title">
                <div class="entries-section-heading">
                    <p>Kontakt</p>
                    <h2 id="entries-contact-title">Umów pierwszy trening</h2>
                </div>

                <div class="entries-contact-list">
                    <?php if ($phone !== ''): ?>
                        <article class="entries-contact-card">
                            <span aria-hidden="true">
                                <i class="fa-solid fa-phone"></i>
                            </span>

                            <div>
                                <p>Telefon</p>

                                <?php if ($phoneHref !== ''): ?>
                                    <a href="tel:<?= e($phoneHref) ?>"><?= e($phone) ?></a>
                                <?php else: ?>
                                    <strong><?= e($phone) ?></strong>
                                <?php endif ?>

                                <small>Najszybszy kontakt w sprawie grup i terminów.</small>
                            </div>
                        </article>
                    <?php endif ?>

                    <?php if ($email !== ''): ?>
                        <article class="entries-contact-card">
                            <span aria-hidden="true">
                                <i class="fa-regular fa-envelope"></i>
                            </span>

                            <div>
                                <p>E-mail</p>
                                <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
                                <small>Napisz, jeśli potrzebujesz szczegółów organizacyjnych.</small>
                            </div>
                        </article>
                    <?php endif ?>
                </div>

                <div class="entries-actions">
                    <?php if ($phoneHref !== ''): ?>
                        <a class="entries-action entries-action--primary" href="tel:<?= e($phoneHref) ?>">
                            Zadzwoń
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    <?php endif ?>

                    <a class="entries-action entries-action--secondary" href="/grafik">
                        <i class="fa-regular fa-calendar"></i>
                        Zobacz grafik
                    </a>
                </div>
            </section>

            <aside class="entries-fees-panel" aria-labelledby="entries-fees-title">
                <div class="entries-section-heading">
                    <p>Składki</p>
                    <h2 id="entries-fees-title">Opłaty miesięczne</h2>
                </div>

                <div class="entries-fees-grid">
                    <?php foreach ($monthlyFees as $fee): ?>
                        <article class="entries-fee-card <?= !empty($fee['featured']) ? 'entries-fee-card--featured' : '' ?>">
                            <p><?= e($fee['title']) ?></p>
                            <strong><?= e($formatAmount((int) $fee['amount'])) ?></strong>
                            <small><?= e($fee['description']) ?></small>
                        </article>
                    <?php endforeach ?>
                </div>

                <a class="entries-fees-link" href="/skladki">
                    Więcej o składkach
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </aside>
        </div>

        <section class="entries-before-first" aria-labelledby="entries-before-first-title">
            <div class="entries-section-heading">
                <p>Przed pierwszym treningiem</p>
                <h2 id="entries-before-first-title">Co warto przygotować?</h2>
            </div>

            <div class="entries-before-first__grid">
                <?php foreach ($firstTrainingNotes as $note): ?>
                    <article class="entries-note-card">
                        <span aria-hidden="true">
                            <i class="<?= e($note['icon']) ?>"></i>
                        </span>

                        <div>
                            <h3><?= e($note['title']) ?></h3>
                            <p><?= e($note['description']) ?></p>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        </section>
    </div>
</section>
