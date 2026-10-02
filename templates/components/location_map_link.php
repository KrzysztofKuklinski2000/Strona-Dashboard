<?php if ($mapLocation['map_url'] !== ''): ?>
    <a
        class="timetable-map-button"
        href="<?= e($mapLocation['map_url']) ?>"
        target="_blank"
        rel="noopener noreferrer"
        data-location-map
        data-location-name="<?= e($mapLocation['name'] ?: 'Lokalizacja') ?>"
        data-location-details="<?= e($mapLocation['details']) ?>"
        aria-label="<?= e('Pokaż mapę: ' . ($mapLocation['name'] ?: 'Lokalizacja')) ?>"
    >
        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
        Pokaż mapę
    </a>
<?php endif ?>
