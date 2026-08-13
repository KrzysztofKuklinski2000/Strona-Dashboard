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
use App\DTO\Dashboard\CreateGalleryDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateGalleryDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\GalleryRequestMapper;
use App\Service\Dashboard\Contracts\GalleryManagementServiceInterface;

class GalleryController extends AbstractDashboardController
{
    use HasStoreAction, HasDeleteAction, HasUpdateAction, HasPublishedAction, HasMoveAction, HasSingleData;

    public function __construct(
        public GalleryManagementServiceInterface $service,
        private readonly GalleryRequestMapper    $galleryRequestMapper,
        ContextController                        $contextController,
    )
    {
        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/index',
            'data' => $this->service->getAllGallery(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function editAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/edit',
            'data' => $this->getSingleData(),
        ]);
    }

    public function createAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/create',
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/show',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function confirmDeleteAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/delete',
            'data' => $this->getSingleData(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'gallery';
    }

    protected function getDataToCreate(): CreateGalleryDto
    {
        return $this->galleryRequestMapper->mapCreate();
    }

    protected function getDataToUpdate(): UpdateGalleryDto
    {
        return $this->galleryRequestMapper->mapUpdate();
    }

    protected function getDataToPublished(): PublishedDto
    {
        return $this->galleryRequestMapper->mapPublication();
    }

    protected function getDataToChangePostPosition(): ChangePositionDto
    {
        return $this->galleryRequestMapper->mapChangePosition();
    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateGalleryDto $data */
        $this->service->createGallery($data);
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var UpdateGalleryDto $data */
        $this->service->updateGallery($data);
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteGallery($id);
    }

    protected function handlePublish(DataTransferObjectInterface $data): void
    {
        /** @var PublishedDto $data */
        $this->service->publishedGallery($data);
    }

    protected function handleMove(ChangePositionDto $changePositionDto): void
    {
        $this->service->moveGallery($changePositionDto);
    }
}
