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

$configuration = require_once('config/config.php');

use App\Controller\pageController;
use App\Controller\AbstractController;
use App\Controller\DashboardController;
use App\Exception\AppException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use App\Request;

$request = new Request($_GET, $_POST, $_SERVER);

try {
	AbstractController::initConfiguration($configuration);
	$request->getParam('dashboard')
		? (new DashboardController($request))->run()
		: (new pageController($request))->run();


}catch (AppException $e){
	echo 'Błąd przechowywania: '. $e->getMessage();

}catch(\Throwable $e) {
	echo 'Nieoczekiwany błąd: '. $e;
}
