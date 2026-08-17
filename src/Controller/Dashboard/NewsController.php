<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasMoveAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateNewsDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateNewsDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\NewsRequestMapper;
use App\Service\Dashboard\Contracts\NewsManagementServiceInterface;

class NewsController extends AbstractDashboardController
{
    use HasStoreAction, HasDeleteAction, HasUpdateAction, HasPublishedAction, HasMoveAction, HasSingleData;

    public function __construct(
        public NewsManagementServiceInterface $service,
        private readonly NewsRequestMapper    $requestMapper,
        ContextController                     $contextController,
    )
    {
        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'news/index',
            'data' => $this->service->getAllNews(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function editAction(): void
    {
        $this->renderPage([
            'page' => 'news/edit',
            'data' => $this->getSingleData(),
        ]);
    }

    public function createAction(): void
    {
        $this->renderPage([
            'page' => 'news/create',
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'news/show',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function confirmDeleteAction(): void
    {
        $this->renderPage([
            'page' => 'news/delete',
            'data' => $this->getSingleData(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'news';
    }

    protected function getDataToCreate(): CreateNewsDto
    {
        return $this->requestMapper->mapCreate();
    }

    protected function getDataToUpdate(): UpdateNewsDto
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

    protected function getDataToDelete(): ?int
    {
        return $this->requestMapper->mapDelete();
    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateNewsDto $data */
        $this->service->createNews($data);
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var UpdateNewsDto $data */
        $this->service->updateNews($data);
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteNews($id);
    }

    protected function handlePublish(DataTransferObjectInterface $data): void
    {
        /** @var PublishedDto $data */
        $this->service->publishedNews($data);
    }

    protected function handleMove(ChangePositionDto $changePositionDto): void
    {
        $this->service->moveNews($changePositionDto);
    }
}
