<?php
$formTitle = "Tworzenie nowego posta aktualności";
$action = "/dashboard/news/store";
$buttonTitle = "Zapisz szkic";
$errors = $params['flash_dashboard']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';

require_once "templates/dashboard/news/_form.php";
