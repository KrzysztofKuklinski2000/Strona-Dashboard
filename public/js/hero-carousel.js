(() => {
	const carousels = document.querySelectorAll('[data-hero-carousel]');

	if (carousels.length === 0) {
		return;
	}

	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

	carousels.forEach((carousel) => {
		const viewport = carousel.querySelector('[data-hero-carousel-viewport]');
		const track = carousel.querySelector('.hero-gallery__track');
		const items = [...carousel.querySelectorAll('[data-hero-carousel-item]')];
		const previousButton = carousel.querySelector('[data-hero-carousel-previous]');
		const nextButton = carousel.querySelector('[data-hero-carousel-next]');
		const currentIndicator = carousel.parentElement?.querySelector('[data-hero-carousel-current]');
		const autoplayButton = carousel.parentElement?.querySelector('[data-hero-carousel-autoplay]');

		if (!viewport || !track || items.length === 0 || !previousButton || !nextButton) {
			return;
		}

		// Extra copies let the native scroll position wrap without a visible jump.
		const createCopies = () => items.map((item) => {
			const copy = item.cloneNode(true);
			copy.removeAttribute('data-hero-carousel-item');
			copy.setAttribute('aria-hidden', 'true');
			copy.inert = true;
			return copy;
		});
		const beforeCopies = createCopies();
		const afterCopies = createCopies();
		track.prepend(...beforeCopies);
		track.append(...afterCopies);
		carousel.classList.add('is-enhanced');

		let updateFrame;
		let animationFrame;
		let resumeTimer;
		let settleTimer;
		let step = 0;
		let cycleWidth = 0;
		let viewportWidth = 0;
		let hasOverflow = false;
		let isInView = !('IntersectionObserver' in window);
		let isHovered = false;
		let pointerDown = false;
		let userPaused = false;
		let resumeAfter = 0;
		let lastTimestamp = 0;
		let autoPosition = 0;

		const getCycleOffset = () => {
			if (cycleWidth <= 0) {
				return 0;
			}
			const offset = ((viewport.scrollLeft - cycleWidth) % cycleWidth + cycleWidth) % cycleWidth;
			// Ignore subpixel rounding at the join between identical copies.
			return offset < .5 || cycleWidth - offset < .5 ? 0 : offset;
		};

		const normalizeScroll = () => {
			if (hasOverflow && (viewport.scrollLeft < cycleWidth || viewport.scrollLeft >= cycleWidth * 2)) {
				viewport.scrollLeft = cycleWidth + getCycleOffset();
			}
		};

		const updateCarousel = () => {
			updateFrame = undefined;
			// Both directions stay available because the tape is circular.
			previousButton.hidden = !hasOverflow;
			nextButton.hidden = !hasOverflow;
			carousel.classList.toggle('can-scroll-left', hasOverflow);
			carousel.classList.toggle('can-scroll-right', hasOverflow);

			if (currentIndicator) {
				const currentIndex = step > 0 ? Math.round(getCycleOffset() / step) % items.length : 0;
				currentIndicator.textContent = String(currentIndex + 1).padStart(2, '0');
			}

			if (autoplayButton) {
				autoplayButton.hidden = !hasOverflow || prefersReducedMotion.matches;
				const label = userPaused ? 'Wznów automatyczne przesuwanie zdjęć' : 'Wstrzymaj automatyczne przesuwanie zdjęć';
				autoplayButton.setAttribute('aria-label', label);
				autoplayButton.title = label;
				const icon = autoplayButton.querySelector('i');
				icon?.classList.toggle('fa-play', userPaused);
				icon?.classList.toggle('fa-pause', !userPaused);
			}
		};

		const scheduleUpdate = () => {
			if (!updateFrame) {
				updateFrame = window.requestAnimationFrame(updateCarousel);
			}
		};

		const stopAutoplay = () => {
			window.cancelAnimationFrame(animationFrame);
			animationFrame = undefined;
			lastTimestamp = 0;
		};

		const canAutoplay = () => hasOverflow && isInView && !userPaused
			&& !isHovered && !pointerDown && !document.hidden && !prefersReducedMotion.matches
			&& !carousel.contains(document.activeElement) && !document.body.classList.contains('is-menu-open');

		const animate = (timestamp) => {
			if (!canAutoplay()) {
				stopAutoplay();
				return;
			}

			if (lastTimestamp) {
				const elapsed = Math.min(timestamp - lastTimestamp, 64) / 1000;
				// Keep a fractional position even on browsers that round scrollLeft.
				// Move by one photo every twelve seconds at a constant speed.
				autoPosition += elapsed * step / 12;
				if (autoPosition >= cycleWidth * 2) {
					autoPosition -= cycleWidth;
				}
				viewport.scrollLeft = autoPosition;
				scheduleUpdate();
			}

			lastTimestamp = timestamp;
			animationFrame = window.requestAnimationFrame(animate);
		};

		const startAutoplay = () => {
			window.clearTimeout(resumeTimer);
			if (!canAutoplay() || animationFrame) {
				return;
			}

			const delay = resumeAfter - performance.now();
			if (delay > 0) {
				resumeTimer = window.setTimeout(startAutoplay, delay);
				return;
			}

			normalizeScroll();
			autoPosition = viewport.scrollLeft;
			animationFrame = window.requestAnimationFrame(animate);
		};

		const pauseForInteraction = () => {
			resumeAfter = performance.now() + 6000;
			stopAutoplay();
			startAutoplay();
		};

		const measure = () => {
			const progress = cycleWidth > 0 ? getCycleOffset() / cycleWidth : 0;
			const styles = window.getComputedStyle(track);
			const gap = Number.parseFloat(styles.columnGap || styles.gap) || 0;
			// Computed width retains fractional pixels; transformed bounds do not.
			const itemWidth = Number.parseFloat(window.getComputedStyle(items[0]).width) || items[0].offsetWidth;
			step = itemWidth + gap;
			cycleWidth = step * items.length;
			viewportWidth = viewport.clientWidth;
			hasOverflow = cycleWidth - gap > viewportWidth + 2;
			[...beforeCopies, ...afterCopies].forEach((item) => { item.hidden = !hasOverflow; });
			viewport.scrollLeft = hasOverflow ? cycleWidth * (1 + progress) : 0;
			autoPosition = viewport.scrollLeft;
			scheduleUpdate();
			stopAutoplay();
			startAutoplay();
		};

		const moveCarousel = (direction) => {
			if (!hasOverflow || step <= 0) {
				return;
			}

			pauseForInteraction();
			normalizeScroll();
			const visibleItems = Math.max(1, Math.floor((viewport.clientWidth + 1) / step));
			const itemsPerMove = Math.max(1, Math.min(2, visibleItems - 1));
			const rawTarget = viewport.scrollLeft + direction * step * itemsPerMove;
			const target = Math.round(rawTarget / step) * step;

			viewport.scrollTo({
				left: target,
				behavior: prefersReducedMotion.matches ? 'auto' : 'smooth',
			});
		};

		previousButton.addEventListener('click', () => moveCarousel(-1));
		nextButton.addEventListener('click', () => moveCarousel(1));
		viewport.addEventListener('scroll', () => {
			scheduleUpdate();
			window.clearTimeout(settleTimer);
			settleTimer = window.setTimeout(() => {
				if (!animationFrame && !pointerDown) {
					normalizeScroll();
				}
			}, 180);
		}, { passive: true });

		carousel.addEventListener('pointerenter', (event) => {
			if (event.pointerType === 'mouse') {
				isHovered = true;
				stopAutoplay();
			}
		});
		carousel.addEventListener('pointerleave', () => {
			isHovered = false;
			startAutoplay();
		});
		viewport.addEventListener('pointerdown', () => {
			pointerDown = true;
			pauseForInteraction();
		}, { passive: true });
		const releasePointer = () => {
			if (pointerDown) {
				pointerDown = false;
				pauseForInteraction();
			}
		};
		window.addEventListener('pointerup', releasePointer, { passive: true });
		window.addEventListener('pointercancel', releasePointer, { passive: true });
		viewport.addEventListener('wheel', pauseForInteraction, { passive: true });
		carousel.addEventListener('focusin', stopAutoplay);
		carousel.addEventListener('focusout', () => window.setTimeout(startAutoplay, 0));

		autoplayButton?.addEventListener('click', () => {
			userPaused = !userPaused;
			resumeAfter = 0;
			stopAutoplay();
			startAutoplay();
			scheduleUpdate();
		});

		viewport.addEventListener('keydown', (event) => {
			if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
				return;
			}

			event.preventDefault();
			moveCarousel(event.key === 'ArrowLeft' ? -1 : 1);
		});

		if ('ResizeObserver' in window) {
			const resizeObserver = new ResizeObserver(measure);
			resizeObserver.observe(viewport);
			resizeObserver.observe(track);
		} else {
			window.addEventListener('resize', measure);
		}

		if ('IntersectionObserver' in window) {
			const visibilityObserver = new IntersectionObserver(([entry]) => {
				isInView = entry.isIntersecting;
				stopAutoplay();
				startAutoplay();
			}, { threshold: .1 });
			visibilityObserver.observe(carousel);
		}

		const syncMotion = () => {
			stopAutoplay();
			startAutoplay();
			scheduleUpdate();
		};
		prefersReducedMotion.addEventListener('change', syncMotion);
		document.addEventListener('visibilitychange', syncMotion);
		const menuObserver = new MutationObserver(syncMotion);
		menuObserver.observe(document.body, { attributes: true, attributeFilter: ['class'] });
		window.addEventListener('load', measure);
		measure();
	});
})();
