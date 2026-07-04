<section id="newsletter" class="site-newsletter" aria-labelledby="newsletter-title">
	<div class="site-newsletter__inner">
		<div class="site-newsletter__intro">
			<span class="site-newsletter__icon" aria-hidden="true">
				<i class="fa-regular fa-envelope"></i>
			</span>

			<div>
				<p class="site-newsletter__eyebrow">Bądź na bieżąco</p>
				<h2 id="newsletter-title">Dołącz do listy informacji</h2>
				<p>
					Otrzymuj informacje o zmianach w grafiku, wydarzeniach klubowych i ważnych
					komunikatach dla trenujących.
				</p>
			</div>
		</div>

		<form action="/subscribe" method="POST" class="site-newsletter__form">
			<input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">

			<div class="site-newsletter__field">
				<label class="visually-hidden" for="newsletter-email">Adres e-mail</label>
				<input id="newsletter-email" type="email" name="email" required maxlength="100" placeholder="Twój adres e-mail">
				<button type="submit">
					Włącz powiadomienia
					<i class="fa-regular fa-envelope" aria-hidden="true"></i>
				</button>
			</div>

			<label class="site-newsletter__consent">
				<input type="checkbox" name="terms_consent" required>
				<span>Wyrażam zgodę na otrzymywanie powiadomień o aktualizacjach grafiku.</span>
			</label>
		</form>

		<img class="site-newsletter__decor" src="/public/images/decor-bamboo.png" alt="" aria-hidden="true">
	</div>
</section>

<div id="site-footer" class="site-footer-main">
	<div class="site-footer-main__inner">
		<div class="site-footer-brand">
			<a class="site-brand site-brand--footer" href="/" aria-label="Strona główna Karate Kyokushin Wejherowo / Reda">
				<span class="site-brand__icons" aria-hidden="true">
					<img class="site-brand__emblem" src="/public/images/logo.png" alt="">
					<img class="site-brand__calligraphy" src="/public/images/logo.gif" alt="">
				</span>
				<span class="site-brand__text">
					<strong>
						<span>Karate</span>
						<span>Kyokushin</span>
					</strong>
					<small>Wejherowo / Reda</small>
				</span>
			</a>

			<p>
				Tradycyjne karate, które aktualizuje ciało, charakter i sposób działania.
			</p>
		</div>

		<nav class="site-footer-nav" aria-label="Nawigacja w stopce">
			<div>
				<h3>Nawigacja</h3>
				<ul>
					<li><a href="/">Strona główna</a></li>
					<li><a href="/aktualnosci">Aktualności</a></li>
					<li><a href="/grafik">Grafik zajęć</a></li>
					<li><a href="/galeria">Galeria</a></li>
					<li><a href="/kontakt">Kontakt</a></li>
				</ul>
			</div>

			<div>
				<h3>Karate</h3>
				<ul>
					<li><a href="/zapisy">Zapisy</a></li>
					<li><a href="/skladki">Składki</a></li>
					<li><a href="/wymagania-egzaminacyjne">Wymagania egzaminacyjne</a></li>
					<li><a href="/dojo-oath">Przysięga dojo</a></li>
					<li><a href="/status">Regulamin</a></li>
				</ul>
			</div>

			<div>
				<h3>Kontakt</h3>
				<ul class="site-footer-contact">
					<li>
						<i class="fa-solid fa-location-dot" aria-hidden="true"></i>
						<span><?= e($params['contact']->address ?? 'Wejherowo / Reda') ?></span>
					</li>
					<li>
						<i class="fa-solid fa-phone" aria-hidden="true"></i>
						<a href="tel:<?= e(preg_replace('/\s+/', '', $params['contact']->phone ?? '')) ?>">
							<?= e($params['contact']->phone ?? '') ?>
						</a>
					</li>
					<li>
						<i class="fa-regular fa-envelope" aria-hidden="true"></i>
						<a href="mailto:<?= e($params['contact']->email ?? '') ?>">
							<?= e($params['contact']->email ?? '') ?>
						</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>

	<div class="site-footer-bottom">
		<p>&copy; <?= date('Y') ?> Klub Karate Kyokushin Wejherowo / Reda. Wszelkie prawa zastrzeżone.</p>
		<div>
			<a href="/status">Regulamin</a>
			<a href="/kontakt">Kontakt</a>
		</div>
	</div>
</div>
