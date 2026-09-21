<td class="links dashboard-table__actions">
  <a class="dashboard-table-action dashboard-table-action--edit" href="/dashboard/<?= e($moduleName) ?>/edit/<?= e($row->id) ?>" aria-label="Edytuj" title="Edytuj">
    <i class="fa-regular fa-pen-to-square" aria-hidden="true"></i>
  </a>
  <a class="dashboard-table-action dashboard-table-action--delete" href="/dashboard/<?= e($moduleName) ?>/confirmDelete/<?= e($row->id) ?>" aria-label="Usuń" title="Usuń">
    <i class="fa-solid fa-trash" aria-hidden="true"></i>
  </a>
  <a class="dashboard-table-action dashboard-table-action--show" href="/dashboard/<?= e($moduleName) ?>/show/<?= e($row->id) ?>" aria-label="Pokaż szczegóły" title="Pokaż szczegóły">
    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
  </a>
</td>
