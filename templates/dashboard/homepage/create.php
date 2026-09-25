<?php
$formTitle = "Tworzenie nowego posta strony głównej";
$action = "/dashboard/homepage/store";
$errors = $params['flash_dashboard']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';
?>

<?php require_once "templates/dashboard/homepage/_form.php";
