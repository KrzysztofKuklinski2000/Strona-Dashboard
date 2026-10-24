<?php

declare(strict_types=1);

namespace App\Seo;

final class PublicPageMetadata
{
    public const SITE_NAME = 'Karate Kyokushin Wejherowo / Reda';

    private const PAGES = [
        'homepage' => [
            'path' => '/',
            'title' => 'Karate Kyokushin Wejherowo i Reda – treningi dla dzieci i dorosłych',
            'description' => 'Trenuj Karate Kyokushin w Wejherowie i Redzie. Zajęcia dla dzieci, młodzieży i dorosłych. Sprawdź grafik i przyjdź na bezpłatny pierwszy trening.',
        ],
        'news' => [
            'path' => '/aktualnosci',
            'title' => 'Aktualności',
            'description' => 'Aktualności klubu Karate Kyokushin w Wejherowie i Redzie: zawody, wydarzenia, dofinansowania i informacje organizacyjne.',
        ],
        'timetable' => [
            'path' => '/grafik',
            'title' => 'Grafik zajęć',
            'description' => 'Sprawdź dni, godziny i lokalizacje treningów Karate Kyokushin w Wejherowie i Redzie. Znajdź zajęcia dla swojej grupy.',
        ],
        'gallery' => [
            'path' => '/galeria',
            'title' => 'Galeria',
            'description' => 'Zobacz zdjęcia z treningów, zawodów, egzaminów i obozów klubu Karate Kyokushin w Wejherowie i Redzie.',
        ],
        'camp-info' => [
            'path' => '/obozy',
            'title' => 'Obozy sportowe i kolonie',
            'description' => 'Poznaj ofertę obozów sportowych i kolonii organizowanych przez klub Karate Kyokushin w Wejherowie i Redzie. Sprawdź program i zasady uczestnictwa.',
        ],
        'fees-info' => [
            'path' => '/skladki',
            'title' => 'Składki i opłaty',
            'description' => 'Aktualne składki członkowskie i opłaty w klubie Karate Kyokushin Wejherowo / Reda. Sprawdź zasady płatności i dane do przelewu.',
        ],
        'entries-info' => [
            'path' => '/zapisy',
            'title' => 'Zapisy na trening',
            'description' => 'Rozpocznij treningi Karate Kyokushin w Wejherowie lub Redzie. Dowiedz się, jak dołączyć do klubu i przygotować się do bezpłatnych pierwszych zajęć.',
        ],
        'contact' => [
            'path' => '/kontakt',
            'title' => 'Kontakt',
            'description' => 'Skontaktuj się z klubem Karate Kyokushin Wejherowo / Reda. Sprawdź telefon, adres e-mail i lokalizacje sal treningowych.',
        ],
        'statute' => [
            'path' => '/status',
            'title' => 'Regulamin klubu',
            'description' => 'Poznaj regulamin klubu Karate Kyokushin w Wejherowie i Redzie: zasady uczestnictwa, obowiązki członków i organizację treningów.',
        ],
        'oyama' => [
            'path' => '/oyama',
            'title' => 'Masutatsu Oyama – twórca Karate Kyokushin',
            'description' => 'Poznaj Masutatsu Oyamę, twórcę Karate Kyokushin, oraz historię i wartości stylu trenowanego w naszym klubie w Wejherowie i Redzie.',
        ],
        'dojo-oath' => [
            'path' => '/dojo-oath',
            'title' => 'Przysięga Dojo',
            'description' => 'Przeczytaj przysięgę Dojo Karate Kyokushin. Poznaj zasady szacunku, wytrwałości i odpowiedzialności, które towarzyszą treningom.',
        ],
        'requirements' => [
            'path' => '/wymagania-egzaminacyjne',
            'title' => 'Wymagania egzaminacyjne',
            'description' => 'Sprawdź wymagania egzaminacyjne Karate Kyokushin na kolejne stopnie kyu i dan. Materiały dla dzieci, młodzieży i dorosłych.',
        ],
    ];

    /** @return list<string> */
    public static function indexablePaths(): array
    {
        return array_column(self::PAGES, 'path');
    }

    public static function forPage(array $params, string $baseUrl, bool $indexingAllowed): array
    {
        $page = $params['page'] ?? 'homepage';
        $definition = self::PAGES[$page] ?? null;
        $title = $definition['title'] ?? 'Powiadomienia';
        $description = $definition['description'] ?? 'Zarządzaj powiadomieniami e-mail o zmianach grafiku treningów naszego klubu.';
        $path = $definition['path'] ?? null;
        $isPublicPage = $definition !== null;

        if ($page === 'news') {
            $number = max(1, (int) ($params['currentNumberOfPage'] ?? 1));

            if ($number > 1) {
                $title .= ' – strona ' . $number;
                $description .= ' Strona ' . $number . ' archiwum.';
                $path .= '/' . $number;
            }
        }

        if ($page === 'news_details') {
            $post = $params['content'] ?? null;
            $id = (int) ($post->id ?? 0);
            $title = self::plainText((string) ($post->title ?? 'Aktualność'));
            $payload = json_decode((string) ($post->payload ?? '{}'), true);
            $postDescription = is_array($payload) && is_string($payload['description'] ?? null)
                ? self::plainText($payload['description'])
                : '';
            $description = $postDescription !== ''
                ? self::excerpt($postDescription)
                : self::excerpt($title . '. Aktualność klubu Karate Kyokushin w Wejherowie i Redzie.');
            $path = $id > 0 ? '/aktualnosci/wpis/' . $id : null;
            $isPublicPage = $id > 0;
        }

        $robots = $indexingAllowed && $isPublicPage ? 'index, follow' : 'noindex, nofollow';

        if ($indexingAllowed && $page === 'gallery' && !empty($params['selectedCategorySlugs'])) {
            $robots = 'noindex, follow';
        }

        return [
            'title' => $page === 'homepage' ? $title : $title . ' | ' . self::SITE_NAME,
            'description' => $description,
            'canonical' => $path !== null && $baseUrl !== '' ? rtrim($baseUrl, '/') . $path : null,
            'robots' => $robots,
            'type' => $page === 'news_details' ? 'article' : 'website',
        ];
    }

    private static function plainText(string $text): string
    {
        $text = strip_tags(html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        return trim(preg_replace('/\s+/u', ' ', $text) ?? '');
    }

    private static function excerpt(string $text): string
    {
        return mb_strlen($text) <= 170 ? $text : rtrim(mb_substr($text, 0, 167)) . '…';
    }
}
