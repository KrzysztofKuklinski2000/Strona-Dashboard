(() => {
    const TOLERANCE = 1;

    function initializeSlider(section) {
        const scrollElement = section.querySelector('.important-info');
        const scrollShell = section.querySelector('.important-info-shell');
        const leftArrow = section.querySelector('.left-arrow');
        const rightArrow = section.querySelector('.right-arrow');
        const pagination = section.querySelector('[data-feed-slider-pagination]');
        let paginationOffsets = [];

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
            updatePaginationState();
        }

        function updatePaginationState() {
            if (!pagination || paginationOffsets.length === 0) {
                return;
            }

            const activeIndex = getActivePaginationIndex();

            pagination.querySelectorAll('button').forEach((dot, index) => {
                const isActive = index === activeIndex;
                dot.classList.toggle('is-active', isActive);

                if (isActive) {
                    dot.setAttribute('aria-current', 'true');
                } else {
                    dot.removeAttribute('aria-current');
                }
            });
        }

        function getActivePaginationIndex() {
            let activeIndex = 0;
            let smallestDistance = Number.POSITIVE_INFINITY;

            paginationOffsets.forEach((offset, index) => {
                const distance = Math.abs(scrollElement.scrollLeft - offset);

                if (distance < smallestDistance) {
                    smallestDistance = distance;
                    activeIndex = index;
                }
            });

            return activeIndex;
        }

        function rebuildPagination() {
            if (!pagination) {
                return;
            }

            const maxScrollLeft = Math.max(0, scrollElement.scrollWidth - scrollElement.clientWidth);
            const cards = [...scrollElement.querySelectorAll('.important-card')];
            const firstCardOffset = cards[0]?.offsetLeft ?? 0;

            paginationOffsets = cards
                .map((card) => Math.min(card.offsetLeft - firstCardOffset, maxScrollLeft))
                .filter((offset, index, offsets) => {
                    return index === 0 || Math.abs(offset - offsets[index - 1]) > TOLERANCE;
                });

            if (paginationOffsets.length === 0) {
                paginationOffsets = [0];
            }

            pagination.replaceChildren();
            pagination.hidden = paginationOffsets.length <= 1;

            paginationOffsets.forEach((offset, index) => {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.setAttribute('aria-label', `Pokaż pozycję ${index + 1} z ${paginationOffsets.length}`);
                dot.addEventListener('click', () => {
                    scrollElement.scrollTo({top: 0, left: offset, behavior: 'smooth'});
                });
                pagination.append(dot);
            });

            updatePaginationState();
        }

        rebuildPagination();
        updateArrowVisibility();
        window.addEventListener('resize', () => {
            rebuildPagination();
            updateArrowVisibility();
        });

        const observer = new MutationObserver(() => {
            requestAnimationFrame(() => {
                rebuildPagination();
                updateArrowVisibility();
            });
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
            document.querySelectorAll('.club-notice').forEach((card) => {
                const text = card.querySelector('[data-notice-text]');
                const toggle = card.querySelector('[data-notice-toggle]');

                if (!text || !toggle) {
                    return;
                }

                function updateToggle() {
                    if (!card.classList.contains('is-expanded')) {
                        toggle.hidden = text.scrollHeight <= text.clientHeight + 1;
                    }
                }

                toggle.addEventListener('click', () => {
                    const expanded = card.classList.toggle('is-expanded');
                    toggle.setAttribute('aria-expanded', String(expanded));
                    toggle.textContent = expanded ? 'Zwiń' : 'Rozwiń';
                    updateToggle();
                });

                updateToggle();
                window.addEventListener('resize', updateToggle);
            });
        });
    });
})();
