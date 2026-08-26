(() => {
    const TOLERANCE = 1;

    function initializeSlider(section) {
        const scrollElement = section.querySelector('.important-info');
        const scrollShell = section.querySelector('.important-info-shell');
        const leftArrow = section.querySelector('.left-arrow');
        const rightArrow = section.querySelector('.right-arrow');

        if (!scrollElement || !scrollShell || !leftArrow || !rightArrow) {
            return;
        }

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
            const isAtStart = scrollElement.scrollLeft <= TOLERANCE;
            const isAtEnd = maxScrollLeft <= TOLERANCE || scrollElement.scrollLeft >= maxScrollLeft - TOLERANCE;

            if (!hasMultipleCards) {
                leftArrow.style.visibility = 'hidden';
                rightArrow.style.visibility = 'hidden';
                scrollShell?.classList.remove('has-left-fade', 'has-right-fade');
                return;
            }

            leftArrow.style.visibility = isAtStart ? 'hidden' : 'visible';
            rightArrow.style.visibility = isAtEnd ? 'hidden' : 'visible';
            scrollShell?.classList.toggle('has-left-fade', !isAtStart);
            scrollShell?.classList.toggle('has-right-fade', !isAtEnd);
        }

        updateArrowVisibility();
        window.addEventListener('resize', updateArrowVisibility);

        const observer = new MutationObserver(() => {
            requestAnimationFrame(updateArrowVisibility);
        });
        observer.observe(scrollElement, {childList: true});


        rightArrow.addEventListener('click', () => {
            const maxScrollLeft = scrollElement.scrollWidth - scrollElement.clientWidth;
            const remaining = maxScrollLeft - scrollElement.scrollLeft;
            const scrollAmount = Math.min(getScrollStep(), remaining);

            scrollElement.scrollBy({top: 0, left: scrollAmount, behavior: 'smooth'});
        });

        leftArrow.addEventListener('click', () => {
            const scrollAmount = Math.min(getScrollStep(), scrollElement.scrollLeft);

            scrollElement.scrollBy({top: 0, left: -scrollAmount, behavior: 'smooth'});
        });

        scrollElement.addEventListener('scroll', () => {
            setTimeout(updateArrowVisibility, 100);
        });
    }

    window.addEventListener('load', () => {
        requestAnimationFrame(() => {
            document.querySelectorAll('.important-section').forEach(initializeSlider);
        });
    });
})();
