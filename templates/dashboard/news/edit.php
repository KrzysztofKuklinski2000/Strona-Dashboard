<?php
$data = $params['data'];
$action = "/?dashboard=news&action=update&id=" . ($data['id'] ?? '');
$formTitle = "Edytowanie posta aktualności";
$buttonTitle = "Edytuj";
$errors = $params['flash']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';


require "templates/dashboard/_partials/_post_form.php";