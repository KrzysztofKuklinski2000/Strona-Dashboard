<?php
declare(strict_types=1);

use App\Core\ContextController;
use App\Core\Database;
use App\Core\ErrorHandler;
use App\Core\Request;
use App\Core\Router;
use App\Exception\NotFoundException;
use App\Middleware\CsrfMiddleware;
use App\View;
use EasyCSRF\EasyCSRF;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use EasyCSRF\NativeSessionProvider;

session_start();

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




$errorHandler = new ErrorHandler($isDev, __DIR__."/templates/errors");
$request = new Request($_GET, $_POST, $_SERVER, $_SESSION);
$easyCSRF = new EasyCSRF(new NativeSessionProvider());
$router = new Router();

$factories = require_once('config/factories.php');


try {
	[$controllerClass, $action] = $router->dispatch($request);

	if(!isset($factories[$controllerClass])) {
		throw new Exception("Błąd konfiguracji: Brak fabryki dla kontrolera " . $controllerClass);
	}

	$factoryClass = $factories[$controllerClass];

	$database = new Database($configuration['db']);
	$pdo = $database->connect();

    $view = new View();
    $csrfMiddleware = new CsrfMiddleware($easyCSRF, $request);
    $contextController = new ContextController($request, $view, $csrfMiddleware);

	$controllerFactory = new $factoryClass($pdo);
	$controller = $controllerFactory->createController($contextController);

	$uri = $request->getServerParam('REQUEST_URI');
	$isDashboardRoute = str_starts_with($uri, '/dashboard');

	if ($isDashboardRoute && empty($request->getSession('user'))) {
		header('Location: /auth/login');
		exit;
	}

	if (!method_exists($controller, $action)) {
		throw new Exception("Metoda $action nie istnieje w kontrolerze $controllerClass");
	}

	$controller->$action();

} catch (InvalidCsrfTokenException $e) {
	$uri = $_SERVER['REQUEST_URI'];
    $redirectPath = str_contains($uri, '/dashboard') ? '/dashboard?error=csrf' : '/?error=csrf';
    
    header("Location: $redirectPath");
    exit;
} catch (NotFoundException $e) {
	http_response_code(404);
	$errorHandler->renderErrorPage('404.php', $e);
} catch (Throwable $e) {
	$errorHandler->handle($e);
}
