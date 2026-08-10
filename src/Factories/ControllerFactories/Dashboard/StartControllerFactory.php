<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Content\MainPagePostTypes;
use App\Controller\AbstractController;
use App\Controller\Dashboard\StartController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\StartServiceFactory;
use App\Mapper\Dashboard\ChangePositionRequestMapper;
use App\Mapper\Dashboard\MainPage\MainPagePayloadNormalizer;
use App\Mapper\Dashboard\MainPage\MainPagePostRequestMapper;
use App\Mapper\Dashboard\MainPage\Payload\CardsGridNormalizer;
use App\Mapper\Dashboard\MainPage\Payload\ImageTextListNormalizer;
use App\Mapper\Dashboard\MainPage\Payload\SimpleTextNormalizer;
use App\Mapper\Dashboard\PublicationRequestMapper;
use PDO;

class StartControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {

    }

    public function createController(ContextController $contextController): AbstractController
    {
        $serviceFactory = new StartServiceFactory($this->pdo, $contextController->config);
        $service = $serviceFactory->createService();

        $payloadNormalizer = new MainPagePayloadNormalizer(
            validator: $contextController->validator,
            normalizers: [
                MainPagePostTypes::SIMPLE_TEXT => new SimpleTextNormalizer(
                    $contextController->validator,
                ),
                MainPagePostTypes::CARDS_GRID => new CardsGridNormalizer(
                    $contextController->validator,
                ),
                MainPagePostTypes::IMAGE_TEXT_LIST => new ImageTextListNormalizer(
                    $contextController->validator,
                ),
                MainPagePostTypes::TRIAL_BANNER => new SimpleTextNormalizer(
                    $contextController->validator,
                )
            ],
        );

        $requestMapper = new MainPagePostRequestMapper(
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
            )
        );

        return new StartController(
            $service,
            $requestMapper,
            $contextController,
        );
    }
}
