<?php 
$data = $params['data'] ?? [];
$action = "/dashboard/timetable/store";
$csrf = $params['csrf_token'] ?? '';
$error = $params['flash']['message'] ?? [];
$formTitle = "Nowy Post do grafiku";


require "templates/dashboard/_partials/_post_form_timetable.php";
?>