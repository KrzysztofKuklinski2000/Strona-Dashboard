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

$configuration = require_once('config/config.php');

use App\Controller\SiteController;
use App\Controller\AbstractController;
use App\Controller\DashboardController;
use App\Controller\AuthController;
use App\Exception\AppException;
use App\Request;

$request = new Request($_GET, $_POST, $_SERVER, $_SESSION);

try {
	AbstractController::initConfiguration($configuration);
	
	if($request->getParam('auth')) {
		(new AuthController($request))->run();
	}else if($request->getParam('dashboard') && $request->getParam('dashboard') === 'start') {
		(new DashboardController($request))->run();
	}else {
		(new SiteController($request))->run();
	}


}catch (AppException $e){
	echo 'Błąd przechowywania: '. $e->getMessage();

}catch(\Throwable $e) {
	echo 'Nieoczekiwany błąd: '. $e;
}
