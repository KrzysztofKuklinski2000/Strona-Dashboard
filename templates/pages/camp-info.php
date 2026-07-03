<?php
$content = $params['content'];

$formatDate = static function (string $date): string {
    if (trim($date) === '') {
        return '';
    }

    $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', $date);

    return $dateTime ? $dateTime->format('d.m.Y') : $date;
};

$formatTime = static fn(string $time): string => substr($time, 0, 5);
$formatAmount = static fn(int $amount): string => $amount . ' zł';

$destination = trim($content->city);
$guesthouse = trim($content->guesthouse);
$place = trim($content->place);
$dateStart = $formatDate($content->dateStart);
$dateEnd = $formatDate($content->dateEnd);
$timeStart = $formatTime($content->timeStart);
$timeEnd = $formatTime($content->timeEnd);

$tripDetails = array_filter([
    [
        'icon' => 'fa-regular fa-calendar',
        'label' => 'Termin',
        'value' => trim($dateStart . ($dateStart !== '' && $dateEnd !== '' ? ' - ' : '') . $dateEnd),
    ],
    [
        'icon' => 'fa-solid fa-location-dot',
        'label' => 'Miejsce wyjazdu',
        'value' => trim($content->cityStart),
    ],
    [
        'icon' => 'fa-regular fa-clock',
        'label' => 'Wyjazd',
        'value' => trim($dateStart . ($timeStart !== '' ? ', godz. ' . $timeStart : '')),
    ],
    [
        'icon' => 'fa-solid fa-rotate-left',
        'label' => 'Powrót',
        'value' => trim($dateEnd . ($timeEnd !== '' ? ', godz. ' . $timeEnd : '')),
    ],
], static fn(array $item): bool => $item['value'] !== '');

$offerItems = array_filter([
    [
        'icon' => 'fa-solid fa-bed',
        'title' => 'Zakwaterowanie',
        'description' => trim($content->accommodation),
    ],
    [
        'icon' => 'fa-solid fa-utensils',
        'title' => 'Wyżywienie',
        'description' => trim($content->meals),
    ],
    [
        'icon' => 'fa-solid fa-route',
        'title' => 'Wycieczki',
        'description' => trim($content->trips),
    ],
    [
        'icon' => 'fa-solid fa-user-shield',
        'title' => 'Kadra',
        'description' => trim($content->staff),
    ],
    [
        'icon' => 'fa-solid fa-train',
        'title' => 'Transport',
        'description' => trim($content->transport),
    ],
    [
        'icon' => 'fa-solid fa-dumbbell',
        'title' => 'Treningi',
        'description' => trim($content->training),
    ],
    [
        'icon' => 'fa-solid fa-shield-heart',
        'title' => 'Ubezpieczenie',
        'description' => trim($content->insurance),
    ],
], static fn(array $item): bool => $item['description'] !== '');
?>

<section class="camp-page" aria-labelledby="camp-page-title">
    <div class="camp-page__inner">
        <section class="camp-intro" aria-labelledby="camp-page-title">
            <div class="camp-intro__content">
                <p>Obóz sportowy</p>
                <h2 id="camp-page-title"><?= e($destination !== '' ? $destination : 'Informacje o obozie') ?></h2>

                <?php if ($guesthouse !== '' || $place !== ''): ?>
                    <span>
                        <?= e($guesthouse !== '' ? $guesthouse : $place) ?>
                    </span>
                <?php endif ?>
            </div>

            <?php if ($content->cost > 0 || $content->advancePayment > 0 || $content->advanceDate !== ''): ?>
                <aside class="camp-price-panel" aria-labelledby="camp-price-title">
                    <?php if ($content->cost > 0): ?>
                        <p>Koszt obozu</p>
                        <h3 id="camp-price-title"><?= e($formatAmount($content->cost)) ?></h3>
                    <?php else: ?>
                        <p id="camp-price-title">Rezerwacja</p>
                    <?php endif ?>

                    <?php if ($content->advancePayment > 0 || $content->advanceDate !== ''): ?>
                        <small>
                            <?php if ($content->advancePayment > 0): ?>
                                Zaliczka: <?= e($formatAmount($content->advancePayment)) ?>
                            <?php endif ?>

                            <?php if ($content->advanceDate !== ''): ?>
                                <?= $content->advancePayment > 0 ? ' do ' : 'Termin zaliczki: ' ?><?= e($formatDate($content->advanceDate)) ?>
                            <?php endif ?>
                        </small>
                    <?php endif ?>
                </aside>
            <?php endif ?>
        </section>

        <?php if ($tripDetails): ?>
            <section class="camp-details" aria-label="Szczegóły wyjazdu">
                <?php foreach ($tripDetails as $detail): ?>
                    <article class="camp-detail-card">
                        <span aria-hidden="true">
                            <i class="<?= e($detail['icon']) ?>"></i>
                        </span>
                        <div>
                            <p><?= e($detail['label']) ?></p>
                            <strong><?= e($detail['value']) ?></strong>
                        </div>
                    </article>
                <?php endforeach ?>
            </section>
        <?php endif ?>

        <?php if ($place !== ''): ?>
            <section class="camp-place" aria-labelledby="camp-place-title">
                <div class="camp-section-heading">
                    <p>Miejsce pobytu</p>
                    <h2 id="camp-place-title"><?= e($guesthouse !== '' ? $guesthouse : 'Pensjonat') ?></h2>
                </div>

                <div class="camp-place__content">
                    <i class="fa-solid fa-house-chimney" aria-hidden="true"></i>
                    <p><?= e_br($place) ?></p>
                </div>
            </section>
        <?php endif ?>

        <?php if ($offerItems): ?>
            <section class="camp-offer" aria-labelledby="camp-offer-title">
                <div class="camp-section-heading">
                    <p>Zapewniamy</p>
                    <h2 id="camp-offer-title">Informacje organizacyjne</h2>
                </div>

                <div class="camp-offer__grid">
                    <?php foreach ($offerItems as $item): ?>
                        <article class="camp-offer-card">
                            <span aria-hidden="true">
                                <i class="<?= e($item['icon']) ?>"></i>
                            </span>
                            <div>
                                <h3><?= e($item['title']) ?></h3>
                                <p><?= e_br($item['description']) ?></p>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>
            </section>
        <?php endif ?>
    </div>
</section>
