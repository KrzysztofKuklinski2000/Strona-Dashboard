<?php 
	$data = $params['data'];
	$data['day'] = trim($data['day']);
	$action = "/?dashboard=timetable&action=update&id=" . ($data['id'] ?? '');
	$csrf = $params['csrf_token'] ?? '';
	$error = $params['flash']['message'] ?? [];
	$formTitle = "Edytuj Post z grafiku";


	require "templates/dashboard/_partials/_post_form_timetable.php";

?>