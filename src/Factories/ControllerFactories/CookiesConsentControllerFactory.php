<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Controller\CookiesConsentController;
use App\Core\ContextController;
use App\Repository\Analytics\UniqueVisitorRepository;
use App\Security\TokenGenerator;
use App\Service\Analytics\CookieConsentManager;
use App\Service\Analytics\UniqueVisitorTracker;
use App\Service\Analytics\VisitorCookieManager;
use PDO;

class CookiesConsentControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): CookiesConsentController
    {
        $secureCookie = $contextController->config->getEnv() !== 'dev';
        $cookiesConsentManager = new CookieConsentManager($secureCookie);
        $visitorCookieManager = new VisitorCookieManager(new TokenGenerator(), $secureCookie);
        $uniqueVisitorTracker = new UniqueVisitorTracker(new UniqueVisitorRepository($this->pdo));

        return new CookiesConsentController(
            $cookiesConsentManager,
            $visitorCookieManager,
            $uniqueVisitorTracker,
            $contextController
        );
    }
}
