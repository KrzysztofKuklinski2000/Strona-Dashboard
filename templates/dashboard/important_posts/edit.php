<?php
$data = $params['data'];
$action = "/?dashboard=important_posts&action=update&id=" . ($data['id'] ?? '');
$formTitle = "Edytowanie ważnego posta";
$buttonTitle = "Edytuj";
$errors = $params['flash']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';


require "templates/dashboard/_partials/_post_form.php";