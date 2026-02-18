<?php
declare(strict_types=1);

use App\Core\Database;
use App\Core\ErrorHandler;
use App\Core\Request;
use App\Core\Router;
use App\Exception\NotFoundException;
use EasyCSRF\EasyCSRF;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use EasyCSRF\NativeSessionProvider;

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


$errorHandler = new ErrorHandler($isDev, __DIR__."/templates/errors");
$request = new Request($_GET, $_POST, $_SERVER, $_SESSION);
$easyCSRF = new EasyCSRF(new NativeSessionProvider());
$router = new Router();

$factories = require_once('config/factories.php');


try {
	[$controllerClass, $action] = $router->dispatch($request);

	if(!isset($factories[$controllerClass])) {
		throw new \Exception("Błąd konfiguracji: Brak fabryki dla kontrolera " . $controllerClass);
	}

	$factoryClass = $factories[$controllerClass];

	$database = new Database($configuration['db']);
	$pdo = $database->connect();

	$controllerFactory = new $factoryClass($pdo);
	$controller = $controllerFactory->createController($request, $easyCSRF);

	if ($controller instanceof \App\Controller\Dashboard\AbstractDashboardController && empty($request->getSession('user'))) {
		header('Location: /login');
		exit;
	}

	if (!method_exists($controller, $action)) {
		throw new \Exception("Metoda $action nie istnieje w kontrolerze $controllerClass");
	}

	$controller->$action();

} catch (InvalidCsrfTokenException $e) {
	header('Location: /dashboard?error=csrf');
	exit;
} catch (NotFoundException $e) {
	http_response_code(404);
	$errorHandler->renderErrorPage('404.php', $e);
} catch (\Throwable $e) {
	$errorHandler->handle($e);
}
