<?php
$formTitle = "Tworzenie nowego ważnego posta";
$action = "?dashboard=important_posts&action=store";
$buttonTitle = "Stwórz";
$errors = $params['flash']['message'] ?? [];
$csrf = $params['csrf_token'] ?? '';


//Przykład dodania pola do formularza 
// Używamy buforowania wyjścia, aby "złapać" nasz dodatkowy HTML do zmiennej
// ob_start();
?>

<!-- <input type="text" name="postTitle" maxlength="100" placeholder="Tytuł posta">
<p class="validation-error"><?= $errors['postTitle'] ?? ""  ?></p> -->

<?php
// Zapisujemy "złapany" HTML do naszej specjalnej zmiennej
// $extraFieldsHtml = ob_get_clean();
require_once "templates/dashboard/_partials/_post_form.php";