<?php
$data = $params['data'];
$action = "/dashboard/news/update/" . ($data['id'] ?? '');
$formTitle = "Edytowanie posta aktualności";
$buttonTitle = "Edytuj";
$errors = $params['flash_dashboard']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';


require "templates/dashboard/_partials/_post_form.php";