<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\Core\Request;
use App\Exception\NotFoundException;
use App\View;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\SubscribersManagementServiceInterface;

class SubscribersController extends AbstractDashboardController
{
    use HasStoreAction, HasDeleteAction, HasUpdateAction, HasSingleData;

    public function __construct(
        private readonly SubscribersManagementServiceInterface $service,
        ContextController                                      $contextController
    )
    {

        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'subscribers/index',
            'data' => $this->service->getAllSubscribers(),
        ]);
    }

    public function createAction(): void
    {
        $this->renderPage([
            'page' => 'subscribers/create'
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function editAction(): void
    {
        $this->renderPage([
            'page' => 'subscribers/edit',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'subscribers/show',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function confirmDeleteAction(): void
    {
        $this->renderPage([
            'page' => 'subscribers/delete',
            'data' => $this->getSingleData(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'subscribers';
    }

    protected function getDataToCreate(): array
    {
        return $this->getEmailToCreate();
    }

    protected function getDataToUpdate(): array
    {
        return $this->getEmailToUpdate();
    }

    protected function handleCreate(array $data): void
    {
        $this->service->createSubscriber($data);
    }

    protected function handleUpdate(array $data): void
    {
        $this->service->updateSubscriber($data);
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteSubscriber($id);
    }
}

