<?php
$page = $params['page'] ?? '';

$subpageHeaders = [
    'camp-info' => [
        'eyebrow' => 'Wyjazdy i wydarzenia',
        'title' => 'Obozy',
        'description' => 'Informacje o wyjazdach, obozach sportowych i aktywnościach organizowanych przez klub.',
    ],
    'contact' => [
        'eyebrow' => 'Kontakt',
        'title' => 'Skontaktuj się z nami',
        'description' => 'Sprawdź dane kontaktowe, lokalizacje treningów i najważniejsze informacje organizacyjne.',
    ],
    'dojo-oath' => [
        'eyebrow' => 'Tradycja dojo',
        'title' => 'Przysięga Dojo',
        'description' => 'Poznaj zasady, które budują charakter, szacunek i odpowiedzialność na macie oraz poza nią.',
    ],
    'entries-info' => [
        'eyebrow' => 'Dołącz do klubu',
        'title' => 'Zapisy',
        'description' => 'Dowiedz się, jak rozpocząć treningi i przygotować się do pierwszych zajęć.',
    ],
    'fees-info' => [
        'eyebrow' => 'Informacje organizacyjne',
        'title' => 'Składki',
        'description' => 'Aktualne informacje o opłatach klubowych, terminach płatności i zasadach rozliczeń.',
    ],
    'gallery' => [
        'eyebrow' => 'Klub w obiektywie',
        'title' => 'Galeria',
        'description' => 'Zobacz zdjęcia z treningów, obozów, egzaminów i wydarzeń klubowych.',
    ],
    'news' => [
        'eyebrow' => 'Aktualności klubowe',
        'title' => 'Aktualności',
        'description' => 'Bądź na bieżąco z wydarzeniami, egzaminami, zmianami w grafiku i ważnymi informacjami z życia klubu.',
    ],
    'oyama' => [
        'eyebrow' => 'Historia karate',
        'title' => 'Matsutatsu Oyama',
        'description' => 'Poznaj postać twórcy Karate Kyokushin i fundamenty stylu, który trenujemy.',
    ],
    'requirements' => [
        'eyebrow' => 'Egzaminy',
        'title' => 'Wymagania egzaminacyjne',
        'description' => 'Sprawdź wymagania techniczne i zakres materiału obowiązujący na kolejne stopnie.',
    ],
    'statute' => [
        'eyebrow' => 'Zasady klubu',
        'title' => 'Regulamin',
        'description' => 'Najważniejsze zasady organizacyjne, które porządkują treningi i funkcjonowanie klubu.',
    ],
    'timetable' => [
        'eyebrow' => 'Plan treningów',
        'title' => 'Grafik zajęć',
        'description' => 'Sprawdź aktualne dni, godziny i lokalizacje treningów dla poszczególnych grup.',
    ],
];

$header = $subpageHeaders[$page] ?? [
    'eyebrow' => 'Karate Kyokushin',
    'title' => 'Strona',
    'description' => 'Informacje klubowe Karate Kyokushin Wejherowo / Reda.',
];
?>

<section class="subpage-header" aria-labelledby="subpage-title">
    <div class="subpage-header__background" aria-hidden="true"></div>

    <div class="subpage-header__inner">
        <p class="subpage-header__eyebrow"><?= e($header['eyebrow']) ?></p>
        <h1 id="subpage-title"><?= e($header['title']) ?></h1>
        <p class="subpage-header__description"><?= e($header['description']) ?></p>
    </div>
</section>
