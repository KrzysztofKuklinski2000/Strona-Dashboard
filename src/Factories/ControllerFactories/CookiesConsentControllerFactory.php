<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Controller\CookiesConsentController;
use App\Core\ContextController;
use App\Security\TokenGenerator;
use App\Service\Analytics\CookieConsentManager;
use App\Service\Analytics\VisitorCookieManager;

class CookiesConsentControllerFactory implements ControllerFactoryInterface
{
    public function createController(ContextController $contextController): CookiesConsentController
    {
        $secureCookie = $contextController->config->getEnv() !== 'dev';
        $cookiesConsentManager = new CookieConsentManager($secureCookie);
        $visitorCookieManager = new VisitorCookieManager(new TokenGenerator(), $secureCookie);

        return new CookiesConsentController(
            $cookiesConsentManager,
            $visitorCookieManager,
            $contextController
        );
    }
}