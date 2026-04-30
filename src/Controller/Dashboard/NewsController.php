<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasMoveAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\View;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\NewsManagementServiceInterface;

class NewsController extends AbstractDashboardController
{
    use HasStoreAction, HasDeleteAction, HasUpdateAction, HasPublishedAction, HasMoveAction, HasSingleData;

    public function __construct(
        public NewsManagementServiceInterface $service,
        ContextController $contextController
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

    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'news/show',
            'data' => $this->getSingleData(),
        ]);
    }

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

    protected function getDataToCreate(): array
    {
        return $this->getPostDataToCreate();
    }

    protected function getDataToUpdate(): array
    {
        return $this->getPostDataToEdit();
    }

    protected function handleCreate(array $data): void
    {
        $this->service->createNews($data);
    }

    protected function handleUpdate(array $data): void
    {
        $this->service->updateNews($data);
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteNews($id);
    }

    protected function handlePublish(array $data): void
    {
        $this->service->publishedNews($data);
    }

    protected function handleMove(array $data): void
    {
        $this->service->moveNews($data);
    }
}