<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Content\HomepagePostTypes;
use App\Controller\AbstractController;
use App\Controller\Dashboard\HomepageController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\HomepageServiceFactory;
use App\Mapper\Dashboard\ChangePositionRequestMapper;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Mapper\Dashboard\Homepage\HomepagePostPayloadNormalizer;
use App\Mapper\Dashboard\Homepage\HomepagePostRequestMapper;
use App\Mapper\Dashboard\Homepage\Payload\CardsGridNormalizer;
use App\Mapper\Dashboard\Homepage\Payload\ImageTextListNormalizer;
use App\Mapper\Dashboard\Homepage\Payload\SimpleTextNormalizer;
use App\Mapper\Dashboard\PublicationRequestMapper;
use PDO;

class HomepageControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {

    }

    public function createController(ContextController $contextController): AbstractController
    {
        $serviceFactory = new HomepageServiceFactory($this->pdo, $contextController->config);
        $service = $serviceFactory->createService();

        $payloadNormalizer = new HomepagePostPayloadNormalizer(
            validator: $contextController->validator,
            normalizers: [
                HomepagePostTypes::SIMPLE_TEXT => new SimpleTextNormalizer(
                    $contextController->validator,
                ),
                HomepagePostTypes::CARDS_GRID => new CardsGridNormalizer(
                    $contextController->validator,
                ),
                HomepagePostTypes::IMAGE_TEXT_LIST => new ImageTextListNormalizer(
                    $contextController->validator,
                ),
                HomepagePostTypes::TRIAL_BANNER => new SimpleTextNormalizer(
                    $contextController->validator,
                )
            ],
        );

        $requestMapper = new HomepagePostRequestMapper(
            $contextController->request,
            $contextController->validator,
            $contextController->config,
            $payloadNormalizer,
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

        return new HomepageController(
            $service,
            $requestMapper,
            $contextController,
        );
    }
}
