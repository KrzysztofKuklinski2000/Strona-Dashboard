<?php
$data = $params['data'];
$action = "/dashboard/homepage/published/" . ($data->id ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta strony głównej";

ob_start();
require "templates/dashboard/homepage/_post_details.php";
$postDetailsHtml = ob_get_clean();

require "templates/dashboard/_partials/_show_form.php";
