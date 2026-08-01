<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\AbstractController;
use App\Controller\Dashboard\GalleryController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\GalleryServiceFactory;
use App\Mapper\Dashboard\ChangePositionRequestMapper;
use App\Mapper\Dashboard\GalleryRequestMapper;
use App\Mapper\Dashboard\PublicationRequestMapper;
use PDO;

readonly class GalleryControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {

    }

    public function createController(ContextController $contextController): AbstractController
    {
        $serviceFactory = new GalleryServiceFactory($this->pdo, $contextController->config);
        $service = $serviceFactory->createService();

        $galleryRequestMapper = new GalleryRequestMapper(
            $contextController->request,
            $contextController->validator,
            $contextController->config,
            new ChangePositionRequestMapper(
                $contextController->request,
                $contextController->validator
            ),
            new PublicationRequestMapper(
                $contextController->request,
                $contextController->validator,
            ),
        );

        return new GalleryController(
            $service,
            $galleryRequestMapper,
            $contextController
        );
    }
}
