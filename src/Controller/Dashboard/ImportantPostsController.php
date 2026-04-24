<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasMoveAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Exception\NotFoundException;
use App\View;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\ImportantPostsManagementServiceInterface;

class ImportantPostsController extends AbstractDashboardController
{

    use HasStoreAction, HasDeleteAction, HasUpdateAction, HasPublishedAction, HasMoveAction, HasSingleData;

    public function __construct(
        public ImportantPostsManagementServiceInterface $service,
        Request                                         $request,
        View                                            $view,
        CsrfMiddleware                                  $csrfMiddleware
    )
    {
        parent::__construct($request, $service, $view, $csrfMiddleware);
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
        $this->service->createImportantPost($data);
    }

    protected function handleUpdate(array $data): void
    {
        $this->service->updateImportantPost($data);
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteImportantPost($id);
    }

    protected function handlePublish(array $data): void
    {
        $this->service->publishedImportantPost($data);
    }

    protected function handleMove(array $data): void
    {
        $this->service->moveImportantPost($data);
    }
}
