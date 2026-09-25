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
use App\Mapper\Dashboard\News\NewsPostRequestMapper;
use App\Mapper\Dashboard\News\Payload\ArticleNormalizer;
use App\Mapper\Dashboard\News\Payload\CompetitionResultsNormalizer;
use App\Mapper\Dashboard\News\Payload\EventNormalizer;
use App\Mapper\Dashboard\News\Payload\FundingNormalizer;
use App\Mapper\Dashboard\Payload\OptionalLinkNormalizer;
use App\Mapper\Dashboard\Payload\PostPayloadNormalizer;
use App\Mapper\Dashboard\PublicationRequestMapper;
use App\Mapper\Dashboard\SubmissionActionRequestMapper;
use App\Validator\Dashboard\PostPublicationValidator;
use PDO;

readonly class NewsControllerFactory implements ControllerFactoryInterface
{

    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = (new NewsServiceFactory($this->pdo, $contextController->config))->createService();
        $linkNormalizer = new OptionalLinkNormalizer($contextController->validator);

        $newsNormalizer = new PostPayloadNormalizer(
            validator: $contextController->validator,
            normalizers: [
                NewsPostTypes::ARTICLE => new ArticleNormalizer($contextController->validator),
                NewsPostTypes::EVENT => new EventNormalizer(
                    $contextController->validator,
                    $linkNormalizer,
                ),
                NewsPostTypes::COMPETITION_RESULTS => new CompetitionResultsNormalizer(
                    $contextController->validator,
                    $linkNormalizer,
                ),
                NewsPostTypes::FUNDING => new FundingNormalizer($contextController->validator),
            ]
        );

        $requestMapper = new NewsPostRequestMapper(
            $contextController->request,
            $contextController->validator,
            $contextController->config,
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
            ),
            new SubmissionActionRequestMapper(
                $contextController->request,
                $contextController->validator,
            ),
        );

        $postPublicationValidator = new PostPublicationValidator(
            $contextController->validator,
            $newsNormalizer
        );

        return new NewsController(
            $service,
            $requestMapper,
            $postPublicationValidator,
            $contextController,
        );
    }
}
