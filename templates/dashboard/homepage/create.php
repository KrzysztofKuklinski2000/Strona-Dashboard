<?php
$formTitle = "Tworzenie nowego posta strony głównej";
$action = "/dashboard/homepage/store";
$buttonTitle = "Stwórz";
$errors = $params['flash_dashboard']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';
?>

<?php require_once "templates/dashboard/homepage/_form.php";
