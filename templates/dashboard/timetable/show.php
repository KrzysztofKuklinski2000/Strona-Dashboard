<?php

declare(strict_types=1);

$data = $params['data'];
$action = '/dashboard/timetable/published/' . $data->id;
$csrf = $params['csrf_token'] ?? '';
$formTitle = 'Szczegóły wpisu w grafiku';
$statusLegend = 'Widoczność zajęć';
$enabledStatusTitle = 'Publiczny';
$enabledStatusDescription = 'Zajęcia są widoczne w publicznym grafiku i na stronie głównej.';
$disabledStatusTitle = 'Niepubliczny';
$disabledStatusDescription = 'Zajęcia są ukryte na stronie, ale pozostają w panelu zarządzania.';

ob_start();
require 'templates/dashboard/timetable/_post_details.php';
$postDetailsHtml = ob_get_clean();

ob_start();
?>

<label class="dashboard-form-check">
    <input type="checkbox" name="is_notify">
    <span>
        <strong>Powiadom subskrybentów</strong>
        <small>Wyślij wiadomość o zmianie widoczności zajęć w grafiku.</small>
    </span>
</label>

<?php
$additionalFieldsHtml = ob_get_clean();

require 'templates/dashboard/_partials/_show_form.php';
