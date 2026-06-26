<?php
$adultGrades = ['10 Kyu', '9 Kyu', '8 Kyu', '7 Kyu', '6 Kyu', '5 Kyu', '4 Kyu', '3 Kyu', '2 Kyu', '1 Kyu'];
$childrenGrades = ['10 Kyu', '9 Kyu', '8 Kyu', '7 Kyu', '6 Kyu'];

$summaryCards = [
    [
        'icon' => 'fa-solid fa-medal',
        'title' => 'Stopnie kyu',
        'description' => 'Wybierz stopień, aby sprawdzić zakres technik, kata, kumite i wymagań sprawnościowych.',
    ],
    [
        'icon' => 'fa-solid fa-children',
        'title' => 'Dwie ścieżki',
        'description' => 'Wymagania są rozdzielone dla dorosłych i młodzieży 14+ oraz dla dzieci poniżej 14 roku życia.',
    ],
    [
        'icon' => 'fa-solid fa-clipboard-check',
        'title' => 'Przed egzaminem',
        'description' => 'Zakres materiału warto omówić z instruktorem, szczególnie przy pierwszym podejściu do egzaminu.',
    ],
];
?>

<section class="requirements-page" aria-labelledby="requirements-title">
    <div class="requirements-page__inner">
        <section class="requirements-intro" aria-labelledby="requirements-title">
            <div class="requirements-intro__content">
                <p>Egzaminy</p>
                <h2 id="requirements-title">Tabela stopni i zakres materiału</h2>
                <span>
                    Sprawdź wymagania techniczne dla kolejnych stopni kyu. Po wybraniu stopnia zobaczysz materiał
                    obowiązujący na egzaminie oraz podstawowe wymagania organizacyjne.
                </span>
            </div>

            <aside class="requirements-intro__note" aria-labelledby="requirements-note-title">
                <span aria-hidden="true">
                    <i class="fa-solid fa-torii-gate"></i>
                </span>

                <div>
                    <p>Osu</p>
                    <h3 id="requirements-note-title">Egzamin to etap drogi</h3>
                    <small>Regularny trening, znajomość etykiety dojo i konsultacja z instruktorem są równie ważne jak sama technika.</small>
                </div>
            </aside>
        </section>

        <section class="requirements-summary" aria-labelledby="requirements-summary-title">
            <div class="requirements-section-heading">
                <p>Jak korzystać?</p>
                <h2 id="requirements-summary-title">Wybierz odpowiednią grupę i stopień</h2>
            </div>

            <div class="requirements-summary__grid">
                <?php foreach ($summaryCards as $card): ?>
                    <article class="requirements-summary-card">
                        <span aria-hidden="true">
                            <i class="<?= e($card['icon']) ?>"></i>
                        </span>

                        <div>
                            <h3><?= e($card['title']) ?></h3>
                            <p><?= e($card['description']) ?></p>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <section class="requirements-section" aria-labelledby="requirements-adults-title">
            <div class="requirements-section__top">
                <div class="requirements-section-heading">
                    <p>Dorośli i młodzież</p>
                    <h2 id="requirements-adults-title">Powyżej 14 roku życia</h2>
                </div>

                <span class="requirements-section__badge">10-1 Kyu</span>
            </div>

            <div class="requirements-grade-list" role="group" aria-label="Stopnie dla dorosłych i młodzieży powyżej 14 roku życia">
                <?php foreach ($adultGrades as $grade): ?>
                    <button class="requirements-grade choice" type="button" aria-pressed="false">
                        <span><?= e($grade) ?></span>
                        <small>Stopień</small>
                    </button>
                <?php endforeach ?>
            </div>

            <div class="requirements-results show-content" aria-live="polite"></div>
        </section>

        <section class="requirements-section requirements-section--children" aria-labelledby="requirements-children-title">
            <div class="requirements-section__top">
                <div class="requirements-section-heading">
                    <p>Dzieci</p>
                    <h2 id="requirements-children-title">Poniżej 14 roku życia</h2>
                </div>

                <span class="requirements-section__badge">10-6 Kyu</span>
            </div>

            <div class="requirements-grade-list" role="group" aria-label="Stopnie dla dzieci poniżej 14 roku życia">
                <?php foreach ($childrenGrades as $grade): ?>
                    <button class="requirements-grade choice2" type="button" aria-pressed="false">
                        <span><?= e($grade) ?></span>
                        <small>Stopień</small>
                    </button>
                <?php endforeach ?>
            </div>

            <div class="requirements-results show-content2" aria-live="polite"></div>
        </section>
    </div>
</section>
