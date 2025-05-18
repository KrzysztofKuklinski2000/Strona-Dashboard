let scrollElement = document.querySelector('.important-info');
let leftArrow = document.querySelector('.left-arrow');
let rightArrow = document.querySelector('.right-arrow');

// Ustalony krok przewijania
const SCROLL_STEP = 330;
const TOLERANCE = 1;

// Funkcja aktualizująca widoczność strzałek
function updateArrowVisibility() {
	const maxScrollLeft = scrollElement.scrollWidth - scrollElement.clientWidth;

	if (maxScrollLeft <= TOLERANCE) {
		leftArrow.style.visibility = 'hidden';
		rightArrow.style.visibility = 'hidden';
	} else {
		leftArrow.style.visibility =
			scrollElement.scrollLeft <= TOLERANCE ? 'hidden' : 'visible';

		rightArrow.style.visibility =
			scrollElement.scrollLeft >= maxScrollLeft - TOLERANCE ? 'hidden' : 'visible';
	}
}

// Przewijanie w prawo z ograniczeniem
rightArrow.addEventListener('click', () => {
	const maxScrollLeft = scrollElement.scrollWidth - scrollElement.clientWidth;
	const remaining = maxScrollLeft - scrollElement.scrollLeft;
	const scrollAmount = Math.min(SCROLL_STEP, remaining);
	scrollElement.scrollBy({ top: 0, left: scrollAmount, behavior: 'smooth' });
});

// Przewijanie w lewo z ograniczeniem
leftArrow.addEventListener('click', () => {
	const scrollAmount = Math.min(SCROLL_STEP, scrollElement.scrollLeft);
	scrollElement.scrollBy({ top: 0, left: -scrollAmount, behavior: 'smooth' });
});

// Aktualizacja widoczności strzałek po scrollu z opóźnieniem
scrollElement.addEventListener('scroll', () => {
	setTimeout(updateArrowVisibility, 100);
});

// Pierwsze sprawdzenie po załadowaniu strony
window.addEventListener('load', updateArrowVisibility);
