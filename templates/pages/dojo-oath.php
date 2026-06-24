<?php
$oathItems = [
    'Będziemy ćwiczyć nasze serca i ciała dla osiągnięcia pewnego, niewzruszonego ducha.',
    'Będziemy dążyć do prawdziwego opanowania sztuki karate, aby kiedyś nasze ciało i zmysły stały się doskonałe.',
    'Z głębokim zapałem będziemy starać się kultywować ducha samowyrzeczenia.',
    'Będziemy przestrzegać zasad grzeczności, poszanowania starszych oraz powstrzymywać się od gwałtowności.',
    'Będziemy spoglądać w górę ku prawdziwej mądrości i sile, porzucając inne pragnienia.',
    'Będziemy wierni naszym ideałom i nigdy nie zapomnimy o cnocie pokory.',
    'Przez całe nasze życie, poprzez dyscyplinę karate, dążyć będziemy do poznania prawdziwego znaczenia drogi, którą obraliśmy. Nie będziemy stosować ani rozpowszechniać sztuki karate poza Dojo.',
];

$principles = [
    [
        'icon' => 'fa-solid fa-heart-pulse',
        'title' => 'Duch i ciało',
        'description' => 'Przysięga przypomina, że trening karate rozwija sprawność, charakter i odporność psychiczną.',
    ],
    [
        'icon' => 'fa-solid fa-people-arrows',
        'title' => 'Szacunek',
        'description' => 'Zasady dojo porządkują relacje z instruktorami, starszymi stopniem i partnerami treningowymi.',
    ],
    [
        'icon' => 'fa-solid fa-road',
        'title' => 'Droga karate',
        'description' => 'Kyokushin jest procesem codziennej pracy, pokory i odpowiedzialnego używania umiejętności.',
    ],
];
?>

<section class="dojo-oath-page" aria-labelledby="dojo-oath-title">
    <div class="dojo-oath-page__inner">
        <section class="dojo-oath-intro" aria-labelledby="dojo-oath-title">
            <div class="dojo-oath-intro__content">
                <p>Tradycja dojo</p>
                <h2 id="dojo-oath-title">Przysięga Dojo</h2>
                <span>
                    Siedem zasad, które przypominają, że karate to nie tylko technika. To praca nad charakterem,
                    szacunkiem, samokontrolą i odpowiedzialnością za własną drogę.
                </span>
            </div>

            <aside class="dojo-oath-intro__note" aria-labelledby="dojo-oath-note-title">
                <span aria-hidden="true">
                    <i class="fa-solid fa-torii-gate"></i>
                </span>
                <div>
                    <p>Osu</p>
                    <h3 id="dojo-oath-note-title">Słowo wytrwałości</h3>
                    <small>W dojo oznacza gotowość do wysiłku, szacunku i dalszego doskonalenia.</small>
                </div>
            </aside>
        </section>

        <section class="dojo-oath-list-section" aria-labelledby="dojo-oath-list-title">
            <div class="dojo-oath-section-heading">
                <p>Treść przysięgi</p>
                <h2 id="dojo-oath-list-title">Zasady, które budują postawę karateki</h2>
            </div>

            <div class="dojo-oath-list">
                <?php foreach ($oathItems as $index => $item): ?>
                    <article class="dojo-oath-card">
                        <strong><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></strong>
                        <p><?= e($item) ?></p>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <section class="dojo-oath-principles" aria-labelledby="dojo-oath-principles-title">
            <div class="dojo-oath-section-heading">
                <p>Na treningu</p>
                <h2 id="dojo-oath-principles-title">Jak rozumiemy przysięgę?</h2>
            </div>

            <div class="dojo-oath-principles__grid">
                <?php foreach ($principles as $principle): ?>
                    <article class="dojo-oath-principle">
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
