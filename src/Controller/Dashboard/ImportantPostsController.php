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
use App\DTO\Dashboard\CreateImportantPostDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateImportantPostDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\ImportantPostsRequestMapper;
use App\Service\Dashboard\Contracts\ImportantPostsManagementServiceInterface;

class ImportantPostsController extends AbstractDashboardController
{

    use HasStoreAction, HasDeleteAction, HasUpdateAction, HasPublishedAction, HasMoveAction, HasSingleData;

    public function __construct(
        public ImportantPostsManagementServiceInterface $service,
        private readonly ImportantPostsRequestMapper    $importantPostsRequestMapper,
        ContextController                               $contextController,
    )
    {
        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'important_posts/index',
            'data' => $this->service->getAllImportantPosts(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function editAction(): void
    {
        $this->renderPage([
            'page' => 'important_posts/edit',
            'data' => $this->getSingleData(),
        ]);
    }

    public function createAction(): void
    {
        $this->renderPage([
            'page' => 'important_posts/create',
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'important_posts/show',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function confirmDeleteAction(): void
    {
        $this->renderPage([
            'page' => 'important_posts/delete',
            'data' => $this->getSingleData(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'important_posts';
    }

    protected function getDataToCreate(): CreateImportantPostDto
    {
        return $this->importantPostsRequestMapper->mapCreate();
    }

    protected function getDataToUpdate(): UpdateImportantPostDto
    {
        return $this->importantPostsRequestMapper->mapUpdate();
    }

    protected function getDataToPublished(): PublishedDto
    {
        return $this->importantPostsRequestMapper->mapPublication();
    }

    protected function getDataToChangePostPosition(): ChangePositionDto
    {
        return $this->importantPostsRequestMapper->mapChangePosition();
    }

    protected function getDataToDelete(): ?int
    {
        return $this->importantPostsRequestMapper->mapDelete();
    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateImportantPostDto $data */
        $this->service->createImportantPost($data);
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var UpdateImportantPostDto $data */
        $this->service->updateImportantPost($data);
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteImportantPost($id);
    }

    protected function handlePublish(DataTransferObjectInterface $data): void
    {
        /** @var PublishedDto $data */
        $this->service->publishedImportantPost($data);
    }

    protected function handleMove(ChangePositionDto $changePositionDto): void
    {
        $this->service->moveImportantPost($changePositionDto);
    }
}
