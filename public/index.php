<?php
declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\Dashboard\AbstractDashboardController;
use App\Controller\PublicNewsController;
use App\Controller\PublicSubscribersController;
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
use App\Redirects\LegacyRedirector;
use App\Seo\SearchIndexing;
use App\View\View;
use EasyCSRF\EasyCSRF;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use EasyCSRF\NativeSessionProvider;
use App\Controller\SiteController;
use App\Repository\Analytics\PageViewRepository;
use App\Service\Analytics\PageViewTracker;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\ExceptionInterface as DotenvException;

chdir(dirname(__DIR__));
require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    (new Dotenv())->loadEnv(
        dirname(__DIR__) . '/.env',
        defaultEnv: 'prod',
    );
} catch (DotenvException $e) {
    error_log('Nie udało się wczytać konfiguracji środowiska: ' . $e::class);
    http_response_code(500);
    require dirname(__DIR__) . '/templates/errors/500.php';
    exit;
}

$configurationArray = require dirname(__DIR__) . '/config/config.php';
$configurationArray['seo'] = require dirname(__DIR__) . '/config/seo.php';
$configurationArray['redirects'] = require dirname(__DIR__) . '/config/redirects.php';
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

if (!(new SearchIndexing($config))->isAllowed($request)) {
    header('X-Robots-Tag: noindex, nofollow');
}

$sessionManager = new SessionManager(secureCookies: !$isDev);
$easyCSRF = new EasyCSRF(new NativeSessionProvider());


$factories = require dirname(__DIR__) . '/config/factories.php';


try {
    $redirectsConfig = $config->getRedirectsConfig();

    if (($redirectsConfig['enabled'] ?? false) === true) {
        $legacyRedirects = require $redirectsConfig['map'];
        $legacyRedirector = new LegacyRedirector($legacyRedirects['paths'], $legacyRedirects['news_offsets']);
        $legacyTarget = $legacyRedirector->getTarget($request);

        if ($legacyTarget !== null) {
            header('Location: ' . $legacyTarget, true, 301);
            exit;
        }
    }

    $router = new Router($config->getRoutesPath());
    [$controllerClass, $action] = $router->dispatch($request);

    if (is_a($controllerClass, AbstractDashboardController::class, true)
        || in_array($controllerClass, [AuthController::class, PublicSubscribersController::class], true)) {
        header('X-Robots-Tag: noindex, nofollow');
    }

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
