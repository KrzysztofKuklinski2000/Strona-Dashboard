(() => {
	const nav = document.querySelector('.site-desktop-nav__links');
	const indicator = nav?.querySelector('.site-desktop-nav__indicator');

	if (!nav || !indicator) {
		return;
	}

	const items = [...nav.querySelectorAll(':scope > ul > li > a, :scope > ul > li > button')];
	const activeItem = nav.querySelector(':scope > ul > li > a.is-active, :scope > ul > li > button.is-active')
		|| items[0];
	let currentItem = activeItem;

	const moveIndicatorTo = (item) => {
		if (!item) {
			return;
		}

		const navRect = nav.getBoundingClientRect();
		const itemRect = item.getBoundingClientRect();

		indicator.style.width = `${itemRect.width}px`;
		indicator.style.transform = `translateX(${itemRect.left - navRect.left}px)`;
		indicator.style.opacity = '1';
		currentItem = item;
	};

	const resetIndicator = () => moveIndicatorTo(activeItem);
	const scheduleMove = (item) => window.requestAnimationFrame(() => moveIndicatorTo(item));

	items.forEach((item) => {
		item.addEventListener('mouseenter', () => scheduleMove(item));
		item.addEventListener('focus', () => scheduleMove(item));
	});

	nav.addEventListener('mouseleave', resetIndicator);
	nav.addEventListener('focusout', (event) => {
		if (!nav.contains(event.relatedTarget)) {
			resetIndicator();
		}
	});

	window.addEventListener('resize', () => moveIndicatorTo(currentItem));
	window.addEventListener('load', resetIndicator);
	window.requestAnimationFrame(resetIndicator);
})();
