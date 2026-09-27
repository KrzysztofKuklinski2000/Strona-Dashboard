<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\AbstractController;
use App\Controller\Dashboard\GalleryCategoryController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\GalleryCategoryServiceFactory;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Mapper\Dashboard\GalleryCategoryRequestMapper;
use App\Mapper\Dashboard\PublicationRequestMapper;
use App\Mapper\SlugNormalizer;
use PDO;

readonly class GalleryCategoryControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = (new GalleryCategoryServiceFactory($this->pdo))->createService();
        $mapper = new GalleryCategoryRequestMapper(
            $contextController->request,
            $contextController->validator,
            new SlugNormalizer(),
            new DeleteRequestMapper(
                $contextController->request,
                $contextController->validator,
            ),
            new PublicationRequestMapper(
                $contextController->request,
                $contextController->validator,
            )
        );

        return new GalleryCategoryController(
            $service,
            $mapper,
            $contextController
        );
    }
}