<?php
$content = $params['content'];
$formatAmount = static fn(int $amount): string => $amount . ' zł';
$splitIntoItems = static function (string $text): array {
    $normalizedText = trim((string) preg_replace('/\s+/u', ' ', $text));

    if ($normalizedText === '') {
        return [];
    }

    $items = preg_split('/(?<=[.!?])\s+/u', $normalizedText, -1, PREG_SPLIT_NO_EMPTY) ?: [];

    return array_map('trim', $items);
};

$feesInformationItems = $splitIntoItems($content->feesInformation);
$monthlyFees = [
    [
        'title' => 'Składka ulgowa',
        'amount' => $content->reducedContribution1Month,
        'label' => 'Jedna osoba',
        'period' => 'za miesiąc',
    ],
    [
        'title' => 'Składka ulgowa',
        'amount' => $content->reducedContribution2Month,
        'label' => 'Dwie osoby',
        'period' => 'za miesiąc',
    ],
    [
        'title' => 'Składka rodzinna',
        'amount' => $content->familyContributionMonth,
        'label' => 'Trzy i więcej osób',
        'period' => 'za miesiąc',
        'featured' => true,
    ],
];

$yearlyFees = [
    [
        'title' => 'Składka ulgowa',
        'amount' => $content->reducedContribution1Year,
        'label' => 'Jedna osoba',
        'period' => 'za rok',
    ],
    [
        'title' => 'Składka ulgowa',
        'amount' => $content->reducedContribution2Year,
        'label' => 'Dwie osoby',
        'period' => 'za rok',
    ],
    [
        'title' => 'Składka rodzinna',
        'amount' => $content->familyContributionYear,
        'label' => 'Trzy i więcej osób',
        'period' => 'za rok',
        'featured' => true,
    ],
];
?>

<section class="fees-page" aria-labelledby="fees-page-title">
    <div class="fees-page__inner">
        <section class="fees-membership" aria-labelledby="fees-page-title">
            <h2 id="fees-page-title">Składka członkowska</h2>
            <p><?= e_br($content->extraInformation) ?></p>
        </section>

        <section class="fees-section" aria-labelledby="fees-monthly-title">
            <h2 id="fees-monthly-title">Składka miesięczna</h2>

            <div class="fees-grid">
                <?php foreach ($monthlyFees as $fee): ?>
                    <article class="fees-card <?= !empty($fee['featured']) ? 'fees-card--featured' : '' ?>">
                        <p><?= e($fee['title']) ?></p>
                        <strong><?= e($formatAmount((int) $fee['amount'])) ?></strong>
                        <span><?= e($fee['label']) ?></span>
                        <small><?= e($fee['period']) ?></small>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <section class="fees-section" aria-labelledby="fees-yearly-title">
            <h2 id="fees-yearly-title">Składka roczna</h2>

            <div class="fees-grid">
                <?php foreach ($yearlyFees as $fee): ?>
                    <article class="fees-card <?= !empty($fee['featured']) ? 'fees-card--featured' : '' ?>">
                        <p><?= e($fee['title']) ?></p>
                        <strong><?= e($formatAmount((int) $fee['amount'])) ?></strong>
                        <span><?= e($fee['label']) ?></span>
                        <small><?= e($fee['period']) ?></small>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <div class="fees-cta">
            <a class="fees-section__cta" href="/zapisy">
                Zapisz się
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="fees-details">
            <section class="fees-info-card" aria-labelledby="fees-info-title">
                <h2 id="fees-info-title">Informacje dodatkowe</h2>

                <?php if ($feesInformationItems): ?>
                    <ul>
                        <?php foreach ($feesInformationItems as $item): ?>
                            <li><?= e($item) ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </section>

            <section class="fees-bank-card" aria-labelledby="fees-bank-title">
                <h2 id="fees-bank-title">Konto</h2>

                <div class="fees-bank-list">
                    <div class="fees-bank-row">
                        <i class="fa-regular fa-circle-user" aria-hidden="true"></i>
                        <p>
                            <strong>KLUB KARATE KYOKUSHIN I SPORTÓW WALKI</strong>
                            <span>Nanicka 22, 84-200 Wejherowo</span>
                        </p>
                    </div>

                    <div class="fees-bank-row">
                        <i class="fa-solid fa-building-columns" aria-hidden="true"></i>
                        <p>
                            <strong>Millennium</strong>
                        </p>
                    </div>

                    <div class="fees-bank-row">
                        <i class="fa-regular fa-credit-card" aria-hidden="true"></i>
                        <p>
                            <strong>10 1160 2202 0000 0000 7303 8229</strong>
                        </p>
                    </div>

                    <div class="fees-bank-row">
                        <i class="fa-regular fa-file-lines" aria-hidden="true"></i>
                        <p>
                            <strong>Tytuł wpłaty: Składka za lipiec 2024</strong>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
