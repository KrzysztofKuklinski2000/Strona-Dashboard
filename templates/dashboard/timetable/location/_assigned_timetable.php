<?php

/** @var \App\DTO\Dashboard\Timetable\TimetableDto[] $assignedTimetable */
$assignedTimetable = array_values($params['timetableData'] ?? []);
$assignedDayLabels = [
    'PON' => 'Poniedziałek',
    'WT' => 'Wtorek',
    'ŚR' => 'Środa',
    'CZW' => 'Czwartek',
    'PT' => 'Piątek',
    'SOB' => 'Sobota',
    'NIEDZ' => 'Niedziela',
];
$assignedDayOrder = array_flip(array_keys($assignedDayLabels));

usort($assignedTimetable, static function ($first, $second) use ($assignedDayOrder): int {
    return [
        $assignedDayOrder[$first->day] ?? 99,
        $first->start,
        $first->id,
    ] <=> [
        $assignedDayOrder[$second->day] ?? 99,
        $second->start,
        $second->id,
    ];
});
?>

<section class="dashboard-post-preview" aria-labelledby="location-timetable-title">
    <div class="dashboard-post-preview__heading">
        <span class="dashboard-post-preview__icon" aria-hidden="true">
            <i class="fa-regular fa-calendar-days"></i>
        </span>
        <div>
            <h4 id="location-timetable-title">Przypisane zajęcia</h4>
            <p>Liczba zajęć w tej lokalizacji: <?= count($assignedTimetable) ?>. Lista obejmuje również niepubliczne wpisy.</p>
        </div>
    </div>

    <?php if ($assignedTimetable === []): ?>
        <div class="dashboard-post-preview__empty" role="status">
            <i class="fa-regular fa-calendar" aria-hidden="true"></i>
            <p>Ta lokalizacja nie jest przypisana do żadnych zajęć.</p>
        </div>
    <?php else: ?>
        <div class="dashboard-table-wrapper">
            <table class="dashboard-table" aria-labelledby="location-timetable-title">
                <thead>
                    <tr>
                        <th scope="col">Lp.</th>
                        <th scope="col">Dzień</th>
                        <th scope="col">Godziny</th>
                        <th scope="col">Grupa</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="dashboard-table__actions-heading">Szczegóły</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assignedTimetable as $assignedIndex => $assignedEntry): ?>
                        <?php
                        $assignedDayLabel = $assignedDayLabels[$assignedEntry->day] ?? $assignedEntry->day;
                        $assignedStart = substr($assignedEntry->start, 0, 5);
                        $assignedEnd = substr($assignedEntry->end, 0, 5);
                        $assignedIsPublic = $assignedEntry->status === 1;
                        ?>
                        <tr>
                            <td class="dashboard-table__index"><?= $assignedIndex + 1 ?>.</td>
                            <td class="dashboard-table__primary"><?= e($assignedDayLabel) ?></td>
                            <td>
                                <time datetime="<?= e($assignedStart) ?>"><?= e($assignedStart) ?></time>
                                –
                                <time datetime="<?= e($assignedEnd) ?>"><?= e($assignedEnd) ?></time>
                            </td>
                            <td><?= e($assignedEntry->advancementGroup) ?></td>
                            <td>
                                <span class="dashboard-status-badge <?= $assignedIsPublic ? 'published' : 'no-published' ?>">
                                    <i class="fa-solid <?= $assignedIsPublic ? 'fa-circle-check' : 'fa-circle-xmark' ?>" aria-hidden="true"></i>
                                    <?= $assignedIsPublic ? 'Publiczny' : 'Niepubliczny' ?>
                                </span>
                            </td>
                            <td class="dashboard-table__actions">
                                <a
                                    class="dashboard-table-action dashboard-table-action--show"
                                    href="/dashboard/timetable/show/<?= e($assignedEntry->id) ?>"
                                    title="Szczegóły zajęć"
                                    aria-label="<?= e('Szczegóły zajęć: ' . $assignedDayLabel . ', ' . $assignedStart . ' – ' . $assignedEnd . ', ' . $assignedEntry->advancementGroup) ?>"
                                >
                                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
