<?php
$data = $params['data'];
$action = "/dashboard/news/published/" . ($data->id ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta aktualności";

ob_start();
require "templates/dashboard/news/_post_details.php";
$postDetailsHtml = ob_get_clean();

require "templates/dashboard/_partials/_show_form.php";
