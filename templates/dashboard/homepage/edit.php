<?php
$data = $params['data'];
$action = "/dashboard/homepage/update/" . ($data->id ?? '');
$formTitle = "Edytowanie posta strony głównej";
$buttonTitle = "Edytuj";
$errors = $params['flash_dashboard']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';


require "templates/dashboard/homepage/_form.php";
