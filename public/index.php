<?php
declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\Dashboard\AbstractDashboardController;
use App\Controller\PublicNewsController;
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
use App\Controller\SiteController;
use App\Repository\Analytics\PageViewRepository;
use App\Service\Analytics\PageViewTracker;

// Starsze widoki używają ścieżek względem katalogu projektu.
chdir(dirname(__DIR__));
require_once dirname(__DIR__) . '/vendor/autoload.php';


$configurationArray = require dirname(__DIR__) . '/config/config.php';
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
$request = new Request($_GET, $_POST, $_SERVER, $_FILES);

$sessionManager = new SessionManager(secureCookies: !$isDev);
$easyCSRF = new EasyCSRF(new NativeSessionProvider());


$factories = require dirname(__DIR__) . '/config/factories.php';


try {
    $router = new Router($config->getRoutesPath());
    [$controllerClass, $action] = $router->dispatch($request);

    if (!isset($factories[$controllerClass])) {
        throw new Exception("Błąd konfiguracji: Brak fabryki dla kontrolera " . $controllerClass);
    }

    $authMiddleware = new AuthMiddleware($sessionManager, $config);
    $authMiddleware->handle($controllerClass);

    $factoryClass = $factories[$controllerClass];

    $database = new Database($config->getDbConfig());
    $pdo = $database->connect();

    $view = new View($config->getTemplatesPath());

    $csrfMiddleware = new CsrfMiddleware(
        $easyCSRF,
        $request,
        $sessionManager,
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

    if ($controller instanceof SiteController || $controller instanceof PublicNewsController) {
        $pageViewRepository = new PageViewRepository($pdo);
        $pageViewTracker = new PageViewTracker($pageViewRepository);

        $pageViewTracker->track($request);
    }

} catch (InvalidCsrfTokenException) {
    $isDashboardRequest = $controller instanceof AbstractDashboardController
        || $controller instanceof AuthController;

    $sessionManager->setFlash(
        'warning',
        'Formularz wygasł lub jest nieprawidłowy. '
        . 'Operacja nie została wykonana. '
        . 'Otwórz formularz ponownie i spróbuj jeszcze raz.',
        $isDashboardRequest ? 'dashboard' : 'public',
    );

    $redirectPath = $isDashboardRequest
        ? $config->getDashboardRoute()
        : $config->getHomeRoute();

    header("Location: $redirectPath", true, 303);
    exit;
} catch (NotFoundException $e) {
    http_response_code(404);
    $errorHandler->renderErrorPage('404.php', $e);
} catch (Throwable $e) {
    $errorHandler->handle($e);
}
