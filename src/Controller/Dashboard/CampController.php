<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\CampDto;
use App\Mapper\Dashboard\CampRequestMapper;
use App\Service\Dashboard\CampManagementServiceInterface;

class CampController extends AbstractDashboardController
{
    use HasUpdateAction;
    public function __construct(
        public CampManagementServiceInterface $service,
        private readonly CampRequestMapper    $campRequestMapper,
        ContextController                     $contextController,
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
        return $this->campRequestMapper->mapUpdate();
    }

    protected function handleUpdate(array|object $data): void
    {
        /** @var CampDto $data */
        $this->service->updateCamp($data);
    }
}
