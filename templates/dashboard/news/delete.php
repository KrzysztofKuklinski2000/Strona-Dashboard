<?php
$data = $params['data'];
$action = "/dashboard/news/delete/" . ($data->id ?? '');
$formTitle = "Usuń posta aktualności";
$buttonTitle = "Usuń";
$csrf = $params['csrf_token'] ?? '';

ob_start();
require "templates/dashboard/news/_post_details.php";
$postDetailsHtml = ob_get_clean();

require "templates/dashboard/_partials/_delete_form.php";
