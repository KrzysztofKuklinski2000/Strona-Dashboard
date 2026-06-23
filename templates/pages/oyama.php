<?php
$timelineItems = [
    [
        'year' => '1923',
        'title' => 'Początek drogi',
        'description' => 'Masutatsu Oyama urodził się 27 lipca 1923 roku w Ryongri, w południowej Korei. Już jako dziecko rozpoczął naukę południowo-chińskiego Kempo.',
    ],
    [
        'year' => '1938',
        'title' => 'Wyjazd do Japonii',
        'description' => 'Po wyjeździe do Japonii rozwijał zainteresowanie sztukami walki i rozpoczął trening Shotokan Karate w dojo Gichina Funakoshiego.',
    ],
    [
        'year' => 'Po wojnie',
        'title' => 'Trening ducha',
        'description' => 'Po II wojnie światowej trenował z So Nei Chu, mistrzem Goju-Ryu, który wzmacniał jego charakter i pokazywał znaczenie dyscypliny.',
    ],
];

$principles = [
    [
        'icon' => 'fa-solid fa-mountain',
        'title' => 'Wytrwałość',
        'description' => 'Droga Oyamy pokazuje, że rozwój w karate wymaga regularności, cierpliwości i gotowości do pracy nad sobą.',
    ],
    [
        'icon' => 'fa-solid fa-hand-fist',
        'title' => 'Realny trening',
        'description' => 'Kyokushin opiera się na sprawdzaniu techniki, kondycji i charakteru w wymagającym, ale świadomie prowadzonym treningu.',
    ],
    [
        'icon' => 'fa-solid fa-seedling',
        'title' => 'Rozwój charakteru',
        'description' => 'Karate to nie tylko technika walki. To praca nad szacunkiem, samokontrolą i odpowiedzialnością.',
    ],
];
?>

<section class="oyama-page" aria-labelledby="oyama-page-title">
    <div class="oyama-page__inner">
        <section class="oyama-hero" aria-labelledby="oyama-page-title">
            <div class="oyama-hero__media">
                <img src="/public/images/oyama.jpg" alt="Masutatsu Oyama">
            </div>

            <div class="oyama-hero__content">
                <p>Twórca Karate Kyokushin</p>
                <h2 id="oyama-page-title">Masutatsu Oyama</h2>
                <span>
                    Jedna z najważniejszych postaci współczesnych sztuk walki. Jego droga połączyła twardy trening,
                    dyscyplinę i rozwój charakteru, tworząc fundament stylu Kyokushin.
                </span>

                <div class="oyama-hero__facts" aria-label="Najważniejsze informacje">
                    <div>
                        <strong>1923</strong>
                        <small>rok urodzenia</small>
                    </div>
                    <div>
                        <strong>Kyokushin</strong>
                        <small>styl karate</small>
                    </div>
                    <div>
                        <strong>Osu</strong>
                        <small>duch wytrwałości</small>
                    </div>
                </div>
            </div>
        </section>

        <div class="oyama-content-grid">
            <article class="oyama-story" aria-labelledby="oyama-story-title">
                <p>Biografia</p>
                <h2 id="oyama-story-title">Droga mistrza</h2>

                <div class="oyama-story__text">
                    <p>
                        Masutatsu Oyama urodził się 27 lipca 1923 roku w Ryongri, w południowej Korei. Jego rodzina
                        należała do klanu Yangban. Mając 9 lat zaczął uczyć się południowo-chińskiego Kempo.
                    </p>
                    <p>
                        W 1938 roku wyjechał do Japonii. Tam zapisał się do japońskiej akademii powietrznej z zamiarem
                        zostania pilotem, jednak jego zainteresowanie sztukami walki pozwoliło mu rozpocząć naukę
                        Shotokan Karate w dojo Gichina Funakoshiego na uniwersytecie Takushoku.
                    </p>
                    <p>
                        Mimo wcielenia do wojska Oyama nadal intensywnie ćwiczył i zdobywał kolejne stopnie
                        mistrzowskie. Po zakończeniu II wojny światowej trenował z So Nei Chu, mistrzem Goju-Ryu Karate,
                        który budował siłę jego ducha i pokazywał mu znaczenie wewnętrznej dyscypliny.
                    </p>
                </div>
            </article>

            <aside class="oyama-quote" aria-labelledby="oyama-quote-title">
                <span aria-hidden="true">
                    <i class="fa-solid fa-quote-left"></i>
                </span>
                <p id="oyama-quote-title">Karate zaczyna się i kończy na szacunku, dyscyplinie oraz codziennej pracy.</p>
                <small>Dziedzictwo Kyokushin</small>
            </aside>
        </div>

        <section class="oyama-timeline" aria-labelledby="oyama-timeline-title">
            <div class="oyama-section-heading">
                <p>Historia</p>
                <h2 id="oyama-timeline-title">Najważniejsze etapy</h2>
            </div>

            <div class="oyama-timeline__grid">
                <?php foreach ($timelineItems as $item): ?>
                    <article class="oyama-timeline-card">
                        <strong><?= e($item['year']) ?></strong>
                        <h3><?= e($item['title']) ?></h3>
                        <p><?= e($item['description']) ?></p>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <section class="oyama-principles" aria-labelledby="oyama-principles-title">
            <div class="oyama-section-heading">
                <p>Kyokushin</p>
                <h2 id="oyama-principles-title">Co zostawił kolejnym pokoleniom?</h2>
            </div>

            <div class="oyama-principles__grid">
                <?php foreach ($principles as $principle): ?>
                    <article class="oyama-principle">
                        <span aria-hidden="true">
                            <i class="<?= e($principle['icon']) ?>"></i>
                        </span>
                        <div>
                            <h3><?= e($principle['title']) ?></h3>
                            <p><?= e($principle['description']) ?></p>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        </section>
    </div>
</section>
