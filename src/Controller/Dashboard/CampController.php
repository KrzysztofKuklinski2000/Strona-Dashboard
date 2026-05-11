<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\CampDto;
use App\Service\Dashboard\CampManagementServiceInterface;

class CampController extends AbstractDashboardController
{
    use HasUpdateAction;
    public function __construct(
        public CampManagementServiceInterface $service,
        ContextController $contextController,
    )
    {
        parent::__construct($contextController);
    }

    public function editAction(): void
    {
        $this->renderPage([
            'page' => 'camp/edit',
            'data' => $this->service->getCamp(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'camp';
    }

    protected function getDataToUpdate(): CampDto
    {
        return $this->getDataToCampEdit();
    }

    protected function handleUpdate(array|object $data): void
    {
        $this->service->updateCamp($data);
    }
}
