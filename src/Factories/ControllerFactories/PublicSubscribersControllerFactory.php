<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Controller\PublicSubscribersController;
use App\Core\ContextController;
use App\Factories\ServiceFactories\ContactProviderFactory;
use App\Factories\ServiceFactories\SubscriptionServiceFactory;
use App\View\PublicPageRenderer;
use PDO;

readonly class PublicSubscribersControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): PublicSubscribersController
    {
        $serviceFactory = new SubscriptionServiceFactory(
            $this->pdo,
            $contextController->config
        );

        $service = $serviceFactory->createService();

        $contactProvider = (new ContactProviderFactory($this->pdo))
            ->createService();

        $renderer = new PublicPageRenderer(
            $contextController,
            $contactProvider,
        );

        return new PublicSubscribersController(
            $service,
            $renderer,
            $contextController,
        );
    }
}
