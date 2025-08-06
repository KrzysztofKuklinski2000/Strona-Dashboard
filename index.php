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

use App\Controller\SiteController;
use App\Controller\DashboardController;
use App\Controller\AuthController;
use App\Exception\AppException;
use App\Model\ContentModel;
use App\Model\DashboardModel;
use App\Model\UserModel;
use App\Request;


$configuration = require_once('config/config.php');
if (empty($configuration)) {
	throw new Exception('Configuration Error');
}

$request = new Request($_GET, $_POST, $_SERVER, $_SESSION);

try {
	if($request->getParam('auth')) {
		(new AuthController($request, new UserModel($configuration['db'])))->run();
	}else if($request->getParam('dashboard') && $request->getParam('dashboard') === 'start') {
		(new DashboardController($request, new DashboardModel($configuration['db'])))->run();
	}else {
		(new SiteController($request, new ContentModel($configuration['db'])))->run();
	}


}catch (AppException $e){
	echo 'Błąd przechowywania: '. $e->getMessage();

}catch(\Throwable $e) {
	echo 'Nieoczekiwany błąd: '. $e;
}
