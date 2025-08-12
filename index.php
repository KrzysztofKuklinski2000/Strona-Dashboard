<?php
declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function (string $classNamespace) {
  	$path = str_replace(['\\', 'App/'], ['/', ''], $classNamespace);
  	$path = "src/$path.php";
  	require_once($path);
});

session_start();

use App\Request;
use App\Core\ControllerFactory;
use App\Exception\AppException;

$configuration = require_once('config/config.php');


$request = new Request($_GET, $_POST, $_SERVER, $_SESSION);

try {

	(new ControllerFactory($configuration))->createController($request)->run();

}catch (AppException $e){
	echo 'Błąd przechowywania: '. $e->getMessage();

}catch(\Throwable $e) {
	echo 'Nieoczekiwany błąd: '. $e;
}
