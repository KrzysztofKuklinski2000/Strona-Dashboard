<?php
$formTitle = "Tworzenie nowego posta Strona Główna";
$action = "/dashboard/start/store";
$buttonTitle = "Stwórz";
$errors = $params['flash_dashboard']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';
?>

<?php require_once "templates/dashboard/start/_form.php";
