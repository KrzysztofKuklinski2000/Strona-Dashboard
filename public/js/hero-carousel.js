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

		if (!viewport || !track || items.length === 0 || !previousButton || !nextButton) {
			return;
		}

		let updateFrame;

		const getStep = () => {
			const styles = window.getComputedStyle(track);
			const gap = Number.parseFloat(styles.columnGap || styles.gap) || 0;

			return items[0].getBoundingClientRect().width + gap;
		};

		const getCurrentIndex = () => {
			const step = getStep();

			if (step <= 0) {
				return 0;
			}

			return Math.min(items.length - 1, Math.max(0, Math.round(viewport.scrollLeft / step)));
		};

		const updateCarousel = () => {
			const tolerance = 2;
			const maximumScroll = Math.max(0, viewport.scrollWidth - viewport.clientWidth);
			const hasOverflow = maximumScroll > tolerance;
			const canScrollLeft = hasOverflow && viewport.scrollLeft > tolerance;
			const canScrollRight = hasOverflow && viewport.scrollLeft < maximumScroll - tolerance;

			previousButton.hidden = !canScrollLeft;
			nextButton.hidden = !canScrollRight;
			carousel.classList.toggle('can-scroll-left', canScrollLeft);
			carousel.classList.toggle('can-scroll-right', canScrollRight);

			if (currentIndicator) {
				currentIndicator.textContent = String(getCurrentIndex() + 1).padStart(2, '0');
			}
		};

		const scheduleUpdate = () => {
			window.cancelAnimationFrame(updateFrame);
			updateFrame = window.requestAnimationFrame(updateCarousel);
		};

		const moveCarousel = (direction) => {
			const step = getStep();
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
		viewport.addEventListener('scroll', scheduleUpdate, { passive: true });

		viewport.addEventListener('keydown', (event) => {
			if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
				return;
			}

			event.preventDefault();
			moveCarousel(event.key === 'ArrowLeft' ? -1 : 1);
		});

		if ('ResizeObserver' in window) {
			const resizeObserver = new ResizeObserver(scheduleUpdate);
			resizeObserver.observe(viewport);
			resizeObserver.observe(track);
		} else {
			window.addEventListener('resize', scheduleUpdate);
		}

		window.addEventListener('load', scheduleUpdate);
		scheduleUpdate();
	});
})();
