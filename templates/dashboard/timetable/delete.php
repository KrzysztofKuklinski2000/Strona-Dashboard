<?php

declare(strict_types=1);

$data = $params['data'];
$action = '/dashboard/timetable/delete/' . $data->id;
$csrf = $params['csrf_token'] ?? '';
$formTitle = 'Usuwanie wpisu z grafiku';

ob_start();
require 'templates/dashboard/timetable/_post_details.php';
$postDetailsHtml = ob_get_clean();

ob_start();
?>

<label class="dashboard-form-check">
    <input type="checkbox" name="is_notify">
    <span>
        <strong>Powiadom subskrybentów</strong>
        <small>Wyślij wiadomość o usunięciu zajęć z grafiku.</small>
    </span>
</label>

<?php
$additionalFieldsHtml = ob_get_clean();

require 'templates/dashboard/_partials/_delete_form.php';
