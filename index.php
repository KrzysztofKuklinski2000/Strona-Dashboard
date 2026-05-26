<?php
declare(strict_types=1);

use App\Core\Config;
use App\Core\ContextController;
use App\Core\Database;
use App\Core\ErrorHandler;
use App\Core\Request;
use App\Core\Router;
use App\Core\SessionManager;
use App\Core\Validator;
use App\Exception\NotFoundException;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\View\View;
use EasyCSRF\EasyCSRF;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use EasyCSRF\NativeSessionProvider;

require_once 'vendor/autoload.php';


$configurationArray = require_once('config/config.php');
$config = new Config($configurationArray);

$isDev = $config->getEnv() === 'dev';

if ($isDev) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}


$errorHandler = new ErrorHandler($isDev, "{$config->getTemplatesPath()}/errors");
$request = new Request($_GET, $_POST, $_SERVER);
$easyCSRF = new EasyCSRF(new NativeSessionProvider());
$sessionManager = new SessionManager();

$factories = require_once('config/factories.php');


try {
    $router = new Router($config->getRoutesPath());
    [$controllerClass, $action] = $router->dispatch($request);

    if (!isset($factories[$controllerClass])) {
        throw new Exception("Błąd konfiguracji: Brak fabryki dla kontrolera " . $controllerClass);
    }

    $factoryClass = $factories[$controllerClass];

    $database = new Database($config->getDbConfig());
    $pdo = $database->connect();

    $view = new View($config->getTemplatesPath());

    $authMiddleware = new AuthMiddleware($sessionManager, $config);

    $authMiddleware->handle($request);

    $csrfMiddleware = new CsrfMiddleware(
        $easyCSRF,
        $request,
        $config->getCsrfPrefix(),
        $config->getCsrfTokenName()
    );

    $validator = new Validator();
    $contextController = new ContextController($request, $view, $csrfMiddleware, $validator, $config, $sessionManager);

    $controllerFactory = new $factoryClass($pdo);
    $controller = $controllerFactory->createController($contextController);

    if (!method_exists($controller, $action)) {
        throw new Exception("Metoda $action nie istnieje w kontrolerze $controllerClass");
    }

    $controller->$action();

} catch (InvalidCsrfTokenException $e) {
    $uri = $_SERVER['REQUEST_URI'];
    $redirectPath = str_contains($uri, $config->getDashboardRoute()) ? "{$config->getDashboardRoute()}?error=csrf" : '/?error=csrf';

    header("Location: $redirectPath");
    exit;
} catch (NotFoundException $e) {
    http_response_code(404);
    $errorHandler->renderErrorPage('404.php', $e);
} catch (Throwable $e) {
    $errorHandler->handle($e);
}
