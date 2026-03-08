<footer>
    <div class="footer-header margin-auto">
        <h2>Karate Kyokushin</h2>
        <p>Wejherowo / Reda</p>
    </div>

    <div class="footer-container">
        <div class="footer-content-wrapper">
            
            <div class="newsletter-box">
                <div class="newsletter-title">
                    <h3>Powiadomienia o grafiku</h3>
                    <p></p>
                </div>
                <p class="newsletter-desc">Zapisz się, aby otrzymywać aktualizacje grafiku.</p>
                <form action="/subscribe" method="POST" class="newsletter-form">
                    <input type="hidden" name="csrf_token" value="<?= $params['csrf_token'] ?? '' ?>">
                    <div class="input-container">
                        <div class="input-group">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" name="email" required placeholder="Twój adres email">
                        </div>
                        <button type="submit">Zapisz się <i class="fa-solid fa-paper-plane"></i></button>
                    </div>

                    <div class="consent-wrapper">
                        <label class="consent-label">
                            <input type="checkbox" name="terms_consent" required>
                            <span>Wyrażam zgodę na przetwarzanie mojego adresu e-mail w celu otrzymywania powiadomień o aktualizacjach grafiku.</span>
                        </label>
                    </div>
                </form>
            </div>

            <div class="footer-nav">
                <h3>Zajecia</h3>
                <p></p>
                <ul>
                    <a href="/zapisy"><li>Zapisy</li></a>
                    <a href="/grafik"><li>Grafik</li></a>
                    <a href="/skladki#price"><li>Cennik</li></a>
                    <a href="/wymagania-egzaminacyjne"><li>Wymagania Egzaminacyjne</li></a>
                </ul>
            </div>

            <div class="footer-nav">
                <h3>Dlaczego karate</h3>
                <p></p>
                <ul>
                    <a href="/oyama"><li>Matsutatsu Oyama</li></a>
                    <a href="/dojo-oath"><li>Przysięga Dojo</li></a>
                    <a href="/status"><li>Regulamin</li></a>
                    <a href="/aktualnosci"><li>Aktualności</li></a>
                </ul>
            </div>

            <div class="footer-nav">
                <h3>Kontakt</h3>
                <p></p>
                <ul class="contact">
                    <li>Klub Karate Kyokushin i Sportów Walki</li>
                    <li><i class="fa-solid fa-map-pin"></i> <?= $params['contact']['address'] ?></li>
                    <li><i class="fa-solid fa-mobile-screen-button"></i> <?= $params['contact']['phone'] ?></li>
                    <li><i class="fa-regular fa-envelope"></i> <?= $params['contact']['email'] ?></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="copy">
        <p>2021 Klub Karate Kyokushin i Sportów Walki, Wejherowo wszelkie prawa zastrzeżone.</p>
    </div>
</footer>