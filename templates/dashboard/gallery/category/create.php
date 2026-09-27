<?php

declare(strict_types=1);

$data = null;
$formTitle = 'Tworzenie kategorii galerii';
$action = '/dashboard/gallery/categories/store';
$buttonTitle = 'Dodaj kategorię';
$sectionDescription = 'Podaj czytelną nazwę. Slug zostanie utworzony automatycznie na jej podstawie.';
$actionDescription = 'Po utworzeniu kategoria będzie dostępna podczas przypisywania zdjęć.';

require 'templates/dashboard/gallery/category/_form.php';
