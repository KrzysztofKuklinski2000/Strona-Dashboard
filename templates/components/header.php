<?php
$heroImageDirectory = __DIR__ . '/../../public/images/hero-cinematic/tiles';
$heroImageVersion = filemtime($heroImageDirectory . '/hero-group.webp');
$heroSlides = [
	[
		'file' => 'hero-group.webp',
		'alt' => 'Grupa uczestników treningu Karate Kyokushin w sali sportowej',
	],
	[
		'file' => 'hero-double-kick.webp',
		'alt' => 'Dwie zawodniczki wykonujące wysokie kopnięcia podczas treningu',
	],
	[
		'file' => 'hero-pad-training.webp',
		'alt' => 'Trening uderzeń na tarczy w klubie Karate Kyokushin',
	],
	[
		'file' => 'hero-line-kicks.webp',
		'alt' => 'Uczestnicy treningu wykonujący wspólnie serię kopnięć',
	],
	[
		'file' => 'hero-target-kick.webp',
		'alt' => 'Zawodniczka wykonująca wysokie kopnięcie na tarczę',
	],
	[
		'file' => 'hero-stretching.webp',
		'alt' => 'Rozciąganie podczas treningu Karate Kyokushin',
	],
	[
		'file' => 'hero-red-belt-kick.webp',
		'alt' => 'Młoda zawodniczka z czerwonym pasem wykonująca wysokie kopnięcie',
	],
	[
		'file' => 'hero-kick-pad.webp',
		'alt' => 'Ćwiczenie kopnięcia na tarczę podczas treningu',
	],
	[
		'file' => 'hero-sparring.webp',
		'alt' => 'Trening technik walki dorosłych zawodników Karate Kyokushin',
	],
];
?>

<section class="hero-section" aria-labelledby="hero-title">
	<div class="hero-section__frame">
		<span class="hero-section__corner hero-section__corner--top-left" aria-hidden="true"></span>
		<span class="hero-section__corner hero-section__corner--top-right" aria-hidden="true"></span>
		<span class="hero-section__corner hero-section__corner--bottom-left" aria-hidden="true"></span>
		<span class="hero-section__corner hero-section__corner--bottom-right" aria-hidden="true"></span>

		<div class="hero-section__meta">
			<p class="hero-section__brand">
				<span aria-hidden="true"></span>
				Klub Karate Kyokushin
			</p>
			<p class="hero-section__location">Wejherowo / Reda</p>
		</div>

		<div class="hero-section__intro">
			<p class="hero-section__eyebrow">Dyscyplina &middot; Szacunek &middot; Siła</p>
			<h1 id="hero-title" class="hero-section__title">
				<span>Karate</span> <strong>Kyokushin</strong>
			</h1>
		</div>

		<div class="hero-gallery" data-hero-carousel>
			<button
				class="hero-gallery__control hero-gallery__control--previous"
				type="button"
				data-hero-carousel-previous
				aria-label="Pokaż poprzednie zdjęcia"
				hidden
			>
				<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
			</button>

			<div
				class="hero-gallery__viewport"
				data-hero-carousel-viewport
				tabindex="0"
				aria-label="Zdjęcia z treningów klubu"
			>
				<div class="hero-gallery__track">
					<?php foreach ($heroSlides as $index => $slide): ?>
						<figure class="hero-gallery__item" data-hero-carousel-item>
							<img
								src="/public/images/hero-cinematic/tiles/<?= e($slide['file']) ?>?v=<?= $heroImageVersion ?>"
								width="1536"
								height="1024"
								alt="<?= e($slide['alt']) ?>"
								loading="<?= $index < 4 ? 'eager' : 'lazy' ?>"
								decoding="async"
								<?= $index === 0 ? 'fetchpriority="high"' : '' ?>
							>
							<figcaption aria-hidden="true">
								<?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?>
							</figcaption>
						</figure>
					<?php endforeach ?>
				</div>
			</div>

			<button
				class="hero-gallery__control hero-gallery__control--next"
				type="button"
				data-hero-carousel-next
				aria-label="Pokaż następne zdjęcia"
				hidden
			>
				<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
			</button>
		</div>

		<div class="hero-gallery__status">
			<span data-hero-carousel-current aria-hidden="true">01</span>
			<span class="hero-gallery__status-line" aria-hidden="true"></span>
			<span aria-hidden="true"><?= str_pad((string) count($heroSlides), 2, '0', STR_PAD_LEFT) ?></span>
			<button class="hero-gallery__autoplay" type="button" data-hero-carousel-autoplay aria-label="Wstrzymaj automatyczne przesuwanie zdjęć" title="Wstrzymaj automatyczne przesuwanie zdjęć" hidden>
				<i class="fa-solid fa-pause" aria-hidden="true"></i>
			</button>
		</div>

		<div class="hero-section__footer">
			<div class="hero-section__copy">
				<p class="hero-section__lead">
					Tradycyjne karate dla dzieci, młodzieży i dorosłych. Budujemy charakter,
					sprawność i pewność siebie przez regularny trening.
				</p>
				<p class="hero-section__motto">Silniejsi razem. Lepsi każdego dnia.</p>
			</div>

			<div class="hero-section__actions">
				<a class="hero-button hero-button--primary" href="/zapisy">
					Zapisz się na trening
					<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
				<a class="hero-button hero-button--secondary" href="/grafik">
					<i class="fa-regular fa-calendar" aria-hidden="true"></i>
					Zobacz grafik
				</a>
			</div>
		</div>
	</div>
</section>
