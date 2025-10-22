<?php
declare(strict_types=1);

$configuration = require_once('config/config.php');
$isDev = ($configuration['env'] ?? 'prod') === 'dev';

if($isDev) {
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
}else {
	ini_set('display_errors', '0');
	ini_set('display_startup_errors', '0');
	error_reporting(0);
}

require_once 'vendor/autoload.php';

session_start();

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use App\Core\Request;
use App\Core\ErrorHandler;

$factories = require_once('config/factories.php');


$errorHandler = new ErrorHandler($isDev, __DIR__."/templates/errors");
$request = new Request($_GET, $_POST, $_SERVER, $_SESSION);
$easyCSRF = new EasyCSRF(new NativeSessionProvider());

try {
	$mainKey = $request->resolverControllerKey($factories);
	$factoryConfig = $factories[$mainKey] ?? $factories['site'];

	$factoryClass = null;

	if(is_array($factoryConfig)) {
		$subpage = $request->getQueryParam($mainKey);
		if(isset($factoryConfig[$subpage])) {
			$factoryClass = $factoryConfig[$subpage];
		}else {
			$factoryClass = $factoryConfig['_default'];
		}
	}else {
		$factoryClass = $factoryConfig;
	}

	$controllerFactory = new $factoryClass($configuration['db']);
	$controller = $controllerFactory->createController($request, $easyCSRF);


	if($controller instanceof \App\Controller\Dashboard\AbstractDashboardController && empty($request->getSession('user'))) {
		header('Location: /?auth&action=login');
		exit;
	}

	$controller->run();

} catch(\Throwable $e) {
	$errorHandler->handle($e);
}
