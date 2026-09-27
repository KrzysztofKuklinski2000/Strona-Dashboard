<?php
declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasMoveAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\GalleryCategory\CreateGalleryCategoryDto;
use App\DTO\Dashboard\GalleryCategory\UpdateGalleryCategoryDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\GalleryCategoryRequestMapper;
use App\Service\Dashboard\Contracts\GalleryCategoryManagementServiceInterface;

class GalleryCategoryController extends AbstractDashboardController
{
    use HasSingleData;
    use HasStoreAction;
    use HasUpdateAction;
    use HasDeleteAction;
    use HasPublishedAction;
    use HasMoveAction;

    public function __construct(
        private readonly GalleryCategoryManagementServiceInterface $service,
        private readonly GalleryCategoryRequestMapper              $mapper,
        ContextController                                          $contextController
    )
    {
        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/category/index',
            'data' => $this->service->getAllCategories(),
        ]);
    }

    public function createAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/category/create',
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function editAction(): void {
        $this->renderPage([
            'page' => 'gallery/category/edit',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/category/show',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function confirmDeleteAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/category/delete',
            'data' => $this->getSingleData(),
        ]);
    }


    protected function getModuleName(): string
    {
        return 'gallery/categories';
    }

    protected function getDataToUpdate(): DataTransferObjectInterface
    {
        $data = $this->mapper->mapUpdate();

        $this->checkSlug($data);

        return $data;
    }

    protected function getDataToCreate(): CreateGalleryCategoryDto
    {
        $data = $this->mapper->mapCreate();

        $this->checkSlug($data);

        return $data;

    }

    protected function getDataToDelete(): ?int
    {
        return $this->mapper->mapDelete();
    }

    protected function getDataToPublished(): PublishedDto
    {
        return $this->mapper->mapPublished();
    }

    protected function getDataToChangePostPosition(): ChangePositionDto
    {
        return $this->mapper->mapChangePosition();
    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateGalleryCategoryDto $data */
        $this->service->createGalleryCategory($data);
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var UpdateGalleryCategoryDto $data */
        $this->service->updateGalleryCategory($data);
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteGalleryCategory($id);
    }

    protected function handlePublish(PublishedDto $data): void
    {
        $this->service->publishedGalleryCategory($data);
    }

    protected function handleMove(ChangePositionDto $changePositionDto): void
    {
        $this->service->moveGalleryCategory($changePositionDto);
    }

    private function checkSlug(DataTransferObjectInterface $data): void {
        $excludedId = $data instanceof UpdateGalleryCategoryDto ? $data->id : null;

        if (!$this->validator->getErrors() &&
            $this->service->existsBySlug($data->slug, $excludedId)
        ) {
            $this->validator->addError(
                'name',
                'Kategoria o takiej lub podobnej nazwie już istnieje.'
            );
        }
    }
}