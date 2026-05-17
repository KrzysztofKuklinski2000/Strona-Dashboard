<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\FeesDto;
use App\DTO\DataTransferObjectInterface;
use App\Service\Dashboard\FeesManagementServiceInterface;

class FeesController extends AbstractDashboardController
{
    use HasUpdateAction;

    public function __construct(
        public FeesManagementServiceInterface $service,
        ContextController                     $contextController,
    )
    {
        parent::__construct($contextController);
    }

    public function editAction(): void
    {
        $this->renderPage([
            'page' => 'fees/edit',
            'data' => $this->service->getFees(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'fees';
    }

    protected function getDataToUpdate(): DataTransferObjectInterface
    {
        return $this->getDataToFeesEdit();
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var FeesDto $data */
        $this->service->updateFees($data);
    }
}
