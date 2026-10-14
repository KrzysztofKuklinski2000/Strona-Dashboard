<?php

declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Core\ContextController;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Service\Dashboard\Contracts\SubscribersManagementServiceInterface;

class SubscribersController extends AbstractDashboardController
{
    use HasDeleteAction;
    use HasSingleData;

    public function __construct(
        private readonly SubscribersManagementServiceInterface $service,
        private readonly DeleteRequestMapper $deleteRequestMapper,
        ContextController                                      $contextController
    ) {

        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'subscribers/index',
            'data' => $this->service->getAllSubscribers(),
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

    protected function getDataToDelete(): ?int
    {
        return $this->deleteRequestMapper->map();
    }

    protected function handleDelete(int $id): void
    {
        $this->service->deleteSubscriber($id);
    }
}
