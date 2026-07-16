<?php
$data = $params['data'];
$action = "/dashboard/start/delete/" . ($data->id ?? '');
$formTitle = "Usuwanie posta ze strony głównej";
$csrf = $params['csrf_token'] ?? '';

ob_start();
require "templates/dashboard/start/_post_details.php";
$postDetailsHtml = ob_get_clean();

require "templates/dashboard/_partials/_delete_form.php";
