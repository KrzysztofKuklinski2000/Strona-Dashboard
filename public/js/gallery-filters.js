(() => {
    const TOLERANCE = 2;
    const SCROLL_TO_RESULTS_KEY = 'gallery-scroll-to-results';

    function rememberResultsScroll() {
        try {
            window.sessionStorage.setItem(SCROLL_TO_RESULTS_KEY, 'true');
        } catch (error) {
            // Filtrowanie nadal działa, nawet gdy pamięć przeglądarki jest niedostępna.
        }
    }

    function scrollToResultsAfterFiltering() {
        try {
            if (window.sessionStorage.getItem(SCROLL_TO_RESULTS_KEY) !== 'true') {
                return;
            }

            window.sessionStorage.removeItem(SCROLL_TO_RESULTS_KEY);
        } catch (error) {
            return;
        }

        const filters = document.querySelector('#gallery-filters');

        if (!filters) {
            return;
        }

        window.requestAnimationFrame(() => {
            filters.scrollIntoView({behavior: 'smooth', block: 'start'});
        });
    }

    function initializeGalleryFilters(form) {
        const slider = form.querySelector('.gallery-filters__slider');
        const track = form.querySelector('.gallery-filters__options');
        const leftArrow = form.querySelector('.gallery-filters__arrow--left');
        const rightArrow = form.querySelector('.gallery-filters__arrow--right');
        const clearFilters = form.querySelector('.gallery-filters__clear');

        if (!slider || !track || !leftArrow || !rightArrow) {
            return;
        }

        function updateArrows() {
            const items = Array.from(track.children);
            const styles = window.getComputedStyle(track);
            const gap = parseFloat(styles.columnGap || styles.gap || '0') || 0;
            const contentWidth = items.reduce(
                (width, item) => width + item.getBoundingClientRect().width,
                0
            ) + Math.max(0, items.length - 1) * gap;
            const hasOverflow = contentWidth > slider.clientWidth + TOLERANCE;

            slider.classList.toggle('has-overflow', hasOverflow);

            const maxScrollLeft = track.scrollWidth - track.clientWidth;
            const isAtStart = track.scrollLeft <= TOLERANCE;
            const isAtEnd = track.scrollLeft >= maxScrollLeft - TOLERANCE;

            leftArrow.classList.toggle('is-visible', hasOverflow && !isAtStart);
            rightArrow.classList.toggle('is-visible', hasOverflow && !isAtEnd);
            slider.classList.toggle('has-left-fade', hasOverflow && !isAtStart);
            slider.classList.toggle('has-right-fade', hasOverflow && !isAtEnd);
        }

        function getScrollDistance() {
            return Math.max(220, track.clientWidth * 0.7);
        }

        leftArrow.addEventListener('click', () => {
            track.scrollBy({left: -getScrollDistance(), behavior: 'smooth'});
        });

        rightArrow.addEventListener('click', () => {
            track.scrollBy({left: getScrollDistance(), behavior: 'smooth'});
        });

        form.addEventListener('submit', rememberResultsScroll);
        clearFilters?.addEventListener('click', rememberResultsScroll);

        track.addEventListener('scroll', () => window.requestAnimationFrame(updateArrows));
        window.addEventListener('resize', updateArrows);
        window.addEventListener('load', updateArrows);

        if ('ResizeObserver' in window) {
            new ResizeObserver(updateArrows).observe(track);
        }

        updateArrows();
    }

    document.querySelectorAll('.gallery-filters').forEach(initializeGalleryFilters);
    window.addEventListener('load', scrollToResultsAfterFiltering, {once: true});
})();
