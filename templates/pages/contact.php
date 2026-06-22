<?php
$contact = $params['contact'] ?? null;
$address = trim((string) ($contact->address ?? ''));
$phone = trim((string) ($contact->phone ?? ''));
$email = trim((string) ($contact->email ?? ''));
$phoneHref = preg_replace('/[^\d+]/', '', $phone);

$contactCards = [
    [
        'icon' => 'fa-solid fa-location-dot',
        'label' => 'Adres klubu',
        'value' => $address,
        'href' => '',
        'text' => 'Główna lokalizacja klubu i punkt kontaktowy.',
    ],
    [
        'icon' => 'fa-solid fa-phone',
        'label' => 'Telefon',
        'value' => $phone,
        'href' => $phoneHref !== '' ? 'tel:' . $phoneHref : '',
        'text' => 'Najszybszy kontakt w sprawie treningów i zapisów.',
    ],
    [
        'icon' => 'fa-regular fa-envelope',
        'label' => 'E-mail',
        'value' => $email,
        'href' => $email !== '' ? 'mailto:' . $email : '',
        'text' => 'Napisz, jeśli potrzebujesz szczegółów organizacyjnych.',
    ],
];
?>

<section class="contact-page" aria-labelledby="contact-page-title">
    <div class="contact-page__inner">
        <div class="contact-page__heading">
            <p>Kontakt</p>
            <h2 id="contact-page-title">Porozmawiajmy o treningu</h2>
            <span>Wybierz najwygodniejszą formę kontaktu albo sprawdź dojazd do klubu na mapie.</span>
        </div>

        <div class="contact-page__grid">
            <section class="contact-panel" aria-labelledby="contact-details-title">
                <div class="contact-panel__top">
                    <p>Dane klubu</p>
                    <h2 id="contact-details-title">Klub Karate Kyokushin i Sportów Walki</h2>
                </div>

                <div class="contact-list">
                    <?php foreach ($contactCards as $card): ?>
                        <?php if ($card['value'] === '') continue; ?>

                        <article class="contact-card">
                            <span class="contact-card__icon" aria-hidden="true">
                                <i class="<?= e($card['icon']) ?>"></i>
                            </span>

                            <div class="contact-card__body">
                                <p><?= e($card['label']) ?></p>

                                <?php if ($card['href'] !== ''): ?>
                                    <a href="<?= e($card['href']) ?>"><?= e($card['value']) ?></a>
                                <?php else: ?>
                                    <strong><?= e($card['value']) ?></strong>
                                <?php endif ?>

                                <span><?= e($card['text']) ?></span>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>

                <div class="contact-actions">
                    <?php if ($phoneHref !== ''): ?>
                        <a class="contact-action contact-action--primary" href="tel:<?= e($phoneHref) ?>">
                            Zadzwoń
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    <?php endif ?>

                    <?php if ($email !== ''): ?>
                        <a class="contact-action contact-action--secondary" href="mailto:<?= e($email) ?>">
                            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                            Napisz e-mail
                        </a>
                    <?php endif ?>
                </div>
            </section>

            <aside class="contact-info-box" aria-labelledby="contact-info-title">
                <div class="contact-info-box__icon" aria-hidden="true">
                    <i class="fa-solid fa-person-running"></i>
                </div>

                <div>
                    <p>Pierwszy trening</p>
                    <h2 id="contact-info-title">Chcesz dołączyć?</h2>
                    <span>Przed pierwszymi zajęciami skontaktuj się z klubem. Pomożemy dobrać grupę, godzinę i lokalizację do wieku oraz poziomu zaawansowania.</span>
                </div>

                <a href="/grafik">
                    Zobacz grafik
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </aside>
        </div>

        <section class="contact-map-section" aria-labelledby="contact-map-title">
            <div class="contact-map-section__heading">
                <p>Dojazd</p>
                <h2 id="contact-map-title">Jak dojechać?</h2>
            </div>

            <div class="contact-map">
                <iframe
                    title="Mapa dojazdu do Klubu Karate Kyokushin i Sportów Walki"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2310.6992536077355!2d18.23527337586969!3d54.60929057948394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46fdba28b18c18dd%3A0x5cbaf193380fe60d!2sNanicka%2022%2C%2084-200%20Wejherowo!5e0!3m2!1spl!2spl!4v1713019237782!5m2!1spl!2spl"
                    width="100%"
                    height="420"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
    </div>
</section>
