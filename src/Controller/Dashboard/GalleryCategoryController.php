<?php
declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Core\ContextController;
use App\DTO\Dashboard\GalleryCategory\CreateGalleryCategoryDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\GalleryCategoryRequestMapper;
use App\Service\Dashboard\Contracts\GalleryCategoryManagementServiceInterface;

class GalleryCategoryController extends AbstractDashboardController
{
    use HasSingleData;
    use HasStoreAction;

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
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/category/show',
            'data' => $this->getSingleData(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'gallery/categories';
    }

    protected function getDataToCreate(): CreateGalleryCategoryDto
    {
        $data = $this->mapper->mapCreate();

        if (!$this->validator->getErrors() &&
            $this->service->existsBySlug($data->slug)
        ) {
            $this->validator->addError(
                'name',
                'Kategoria o takiej lub podobnej nazwie już istnieje.'
            );
        }

        return $data;

    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateGalleryCategoryDto $data */
        $this->service->createGalleryCategory($data);
    }
}