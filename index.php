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
use App\Request;
use App\Core\ControllerFactory;
use App\Core\ErrorHandler;

$easyCSRF = new EasyCSRF(new NativeSessionProvider());

$configuration = require_once('config/config.php');
$isDev = $configuration['env'] ?? false;

$errorHandler = new ErrorHandler($isDev, __DIR__."/templates/errors");

$request = new Request($_GET, $_POST, $_SERVER, $_SESSION);

try {
	(new ControllerFactory($configuration))->createController($request, $easyCSRF)->run();

} catch(\Throwable $e) {
	$errorHandler->handle($e);
}
