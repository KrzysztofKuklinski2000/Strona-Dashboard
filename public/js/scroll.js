(() => {
	const scrollElement = document.querySelector('.important-info');
	const leftArrow = document.querySelector('.left-arrow');
	const rightArrow = document.querySelector('.right-arrow');

	if (!scrollElement || !leftArrow || !rightArrow) {
		return;
	}

	const TOLERANCE = 1;

	function getScrollStep() {
		const firstCard = scrollElement.querySelector('.important-card');

		if (!firstCard) {
			return scrollElement.clientWidth;
		}

		const styles = window.getComputedStyle(scrollElement);
		const gap = parseFloat(styles.columnGap || styles.gap || '0') || 0;

		return firstCard.getBoundingClientRect().width + gap;
	}

	function updateArrowVisibility() {
		const hasMultipleCards = scrollElement.querySelectorAll('.important-card').length > 1;
		const maxScrollLeft = scrollElement.scrollWidth - scrollElement.clientWidth;

		if (!hasMultipleCards) {
			leftArrow.style.visibility = 'hidden';
			rightArrow.style.visibility = 'hidden';
			return;
		}

		leftArrow.style.visibility = scrollElement.scrollLeft <= TOLERANCE ? 'hidden' : 'visible';
		rightArrow.style.visibility =
			maxScrollLeft > TOLERANCE && scrollElement.scrollLeft >= maxScrollLeft - TOLERANCE ? 'hidden' : 'visible';
	}

	function init() {
		updateArrowVisibility();
		window.addEventListener('resize', updateArrowVisibility);

		const observer = new MutationObserver(() => {
			requestAnimationFrame(updateArrowVisibility);
		});
		observer.observe(scrollElement, { childList: true });
	}

	rightArrow.addEventListener('click', () => {
		const maxScrollLeft = scrollElement.scrollWidth - scrollElement.clientWidth;
		const remaining = maxScrollLeft - scrollElement.scrollLeft;
		const scrollAmount = Math.min(getScrollStep(), remaining);

		scrollElement.scrollBy({ top: 0, left: scrollAmount, behavior: 'smooth' });
	});

	leftArrow.addEventListener('click', () => {
		const scrollAmount = Math.min(getScrollStep(), scrollElement.scrollLeft);

		scrollElement.scrollBy({ top: 0, left: -scrollAmount, behavior: 'smooth' });
	});

	scrollElement.addEventListener('scroll', () => {
		setTimeout(updateArrowVisibility, 100);
	});

	window.addEventListener('load', () => {
		requestAnimationFrame(() => {
			setTimeout(init, 50);
		});
	});
})();
