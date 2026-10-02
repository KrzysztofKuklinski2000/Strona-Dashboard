(() => {
    const links = document.querySelectorAll('[data-location-map]');

    if (links.length === 0 || typeof HTMLDialogElement === 'undefined') {
        return;
    }

    const dialog = document.createElement('dialog');
    dialog.id = 'location-map-dialog';
    dialog.className = 'location-map-dialog';
    dialog.setAttribute('aria-labelledby', 'location-map-title');
    dialog.innerHTML = `
        <div class="location-map-dialog__header">
            <div>
                <h2 id="location-map-title"></h2>
                <p data-location-map-details></p>
            </div>
            <button class="location-map-dialog__close" type="button" aria-label="Zamknij mapę" autofocus>
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <iframe
            class="location-map-dialog__frame"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen
        ></iframe>
    `;
    document.body.append(dialog);

    const title = dialog.querySelector('h2');
    const details = dialog.querySelector('[data-location-map-details]');
    const frame = dialog.querySelector('iframe');
    let activeLink = null;

    links.forEach((link) => {
        link.setAttribute('aria-haspopup', 'dialog');
        link.setAttribute('aria-controls', dialog.id);
        link.addEventListener('click', (event) => {
            if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) {
                return;
            }

            let mapUrl;
            try {
                mapUrl = new URL(link.href);
            } catch {
                return;
            }

            if (
                mapUrl.protocol !== 'https:'
                || !['www.google.com', 'maps.google.com'].includes(mapUrl.hostname)
                || !(mapUrl.pathname === '/maps/embed' || mapUrl.pathname.startsWith('/maps/embed/'))
            ) {
                return;
            }

            event.preventDefault();
            activeLink = link;
            title.textContent = link.dataset.locationName;
            details.textContent = link.dataset.locationDetails;
            details.hidden = details.textContent === '';
            frame.title = `Mapa lokalizacji: ${link.dataset.locationName}`;
            dialog.showModal();
            frame.src = mapUrl.href;
            document.documentElement.classList.add('has-location-map-open');
        });
    });

    dialog.querySelector('button').addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', (event) => {
        if (event.target !== dialog) {
            return;
        }

        const bounds = dialog.getBoundingClientRect();
        if (
            event.clientX < bounds.left || event.clientX > bounds.right
            || event.clientY < bounds.top || event.clientY > bounds.bottom
        ) {
            dialog.close();
        }
    });
    dialog.addEventListener('close', () => {
        frame.removeAttribute('src');
        document.documentElement.classList.remove('has-location-map-open');
        activeLink?.focus({preventScroll: true});
        activeLink = null;
    });
})();
