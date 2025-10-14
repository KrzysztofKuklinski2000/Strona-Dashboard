<?php
declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/gilbitron/easycsrf/autoload.php';

spl_autoload_register(function (string $classNamespace) {
	$path = str_replace(['\\', 'App/'], ['/', ''], $classNamespace);
	$path = "src/$path.php";
	require_once($path);
});

session_start();

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use App\Core\Request;
use App\Core\ErrorHandler;


$configuration = require_once('config/config.php');
$factories = require_once('config/factories.php');

$isDev = $configuration['env'] ?? false;

$errorHandler = new ErrorHandler($isDev, __DIR__."/templates/errors");
$request = new Request($_GET, $_POST, $_SERVER, $_SESSION);
$easyCSRF = new EasyCSRF(new NativeSessionProvider());

try {
	$mainKey = $request->resolverControllerKey($factories);
	$factoryConfig = $factories[$mainKey] ?? $factories['site'];

	$factoryClass = null;

	if(is_array($factoryConfig)) {
		$subpage = $request->getParam($mainKey);
		if(isset($factoryConfig[$subpage])) {
			$factoryClass = $factoryConfig[$subpage];
		}else {
			$factoryClass = $factoryConfig['_default'];
		}
	}else {
		$factoryClass = $factoryConfig;
	}

	$controllerFactory = new $factoryClass($configuration['db']);

	$controllerFactory->createController($request, $easyCSRF)->run();

} catch(\Throwable $e) {
	$errorHandler->handle($e);
}
