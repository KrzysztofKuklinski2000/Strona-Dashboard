<?php

declare(strict_types=1);

$data = $params['data'];
$formTitle = 'Edytowanie kategorii galerii';
$action = '/dashboard/gallery/categories/update/' . ($data->id ?? '');
$buttonTitle = 'Zapisz zmiany';
$sectionDescription = 'Zmień nazwę kategorii. Slug zostanie ponownie utworzony na jej podstawie.';
$actionDescription = 'Zmiany będą widoczne przy zdjęciach przypisanych do tej kategorii.';

require 'templates/dashboard/gallery/category/_form.php';
