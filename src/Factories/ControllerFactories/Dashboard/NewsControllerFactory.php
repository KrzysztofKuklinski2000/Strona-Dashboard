<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Content\NewsPostTypes;
use App\Controller\AbstractController;
use App\Controller\Dashboard\NewsController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\NewsServiceFactory;
use App\Mapper\Dashboard\ChangePositionRequestMapper;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Mapper\Dashboard\News\NewsPostPayloadNormalizer;
use App\Mapper\Dashboard\News\Payload\ArticleNormalizer;
use App\Mapper\Dashboard\News\Payload\EventNormalizer;
use App\Mapper\Dashboard\NewsRequestMapper;
use App\Mapper\Dashboard\PublicationRequestMapper;
use PDO;

class NewsControllerFactory implements ControllerFactoryInterface
{
    private NewsServiceFactory $serviceFactory;

    public function __construct(PDO $pdo)
    {
        $this->serviceFactory = new NewsServiceFactory($pdo);
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = $this->serviceFactory->createService();

        $newsNormalizer = new NewsPostPayloadNormalizer(
            validator: $contextController->validator,
            normalizers: [
                NewsPostTypes::ARTICLE => new ArticleNormalizer($contextController->validator),
                NewsPostTypes::EVENT => new EventNormalizer($contextController->validator),
            ]
        );

        $requestMapper = new NewsRequestMapper(
            $contextController->request,
            $contextController->validator,
            $newsNormalizer,
            new ChangePositionRequestMapper(
                $contextController->request,
                $contextController->validator,
            ),
            new PublicationRequestMapper(
                $contextController->request,
                $contextController->validator,
            ),
            new DeleteRequestMapper(
                $contextController->request,
                $contextController->validator,
            )
        );

        return new NewsController(
            $service,
            $requestMapper,
            $contextController,
        );
    }
}
