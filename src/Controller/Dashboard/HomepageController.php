<?php

namespace App\Controller\Dashboard;

use App\Content\HomepagePostTypes;
use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasMoveAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateHomepagePostDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateHomepagePostDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\Homepage\HomepagePostRequestMapper;
use App\Service\Dashboard\Contracts\HomepageManagementServiceInterface;

class HomepageController extends AbstractDashboardController
{
    use HasStoreAction, HasDeleteAction, HasUpdateAction, HasPublishedAction, HasMoveAction, HasSingleData;

    public function __construct(
        public HomepageManagementServiceInterface  $service,
        private readonly HomepagePostRequestMapper $requestMapper,
        ContextController                          $contextController,
    )
    {
        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'homepage/index',
            'data' => $this->service->getAllHomepagePosts(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function editAction(): void
    {
        $this->renderPage([
            'page' => 'homepage/edit',
            'data' => $this->getSingleData(),
            'postTypes' => HomepagePostTypes::all()
        ]);
    }

    public function createAction(): void
    {
        $this->renderPage([
            'page' => 'homepage/create',
            'postTypes' => HomepagePostTypes::all()
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'homepage/show',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function confirmDeleteAction(): void
    {
        $this->renderPage([
            'page' => 'homepage/delete',
            'data' => $this->getSingleData(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'homepage';
    }

    protected function getTableName(): string
    {
        return 'homepage_posts';
    }

    protected function getDataToCreate(): CreateHomepagePostDto
    {
        return $this->requestMapper->mapCreate();
    }

    protected function getDataToUpdate(): UpdateHomepagePostDto
    {
        return $this->requestMapper->mapUpdate();
    }

    protected function getDataToPublished(): PublishedDto
    {
        return $this->requestMapper->mapPublication();
    }

    protected function getDataToChangePostPosition(): ChangePositionDto
    {
        return $this->requestMapper->mapChangePosition();
    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateHomepagePostDto $data */
        $this->service->createHomepagePost($data);
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var UpdateHomepagePostDto $data */
        $this->service->updateHomepagePost($data);
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteHomepagePost($id);
    }

    protected function handlePublish(DataTransferObjectInterface $data): void
    {
        /** @var PublishedDto $data */
        $this->service->publishedHomepagePost($data);
    }

    protected function handleMove(ChangePositionDto $changePositionDto): void
    {
        $this->service->moveHomepagePost($changePositionDto);
    }
}
