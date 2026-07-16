<?php
$data = $params['data'];
$action = "/dashboard/start/update/" . ($data->id ?? '');
$formTitle = "Edytowanie posta strony głównej";
$buttonTitle = "Edytuj";
$errors = $params['flash_dashboard']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';


require "templates/dashboard/start/_form.php";
