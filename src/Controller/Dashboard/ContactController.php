<?php

declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\ContactDto;
use App\DTO\DataTransferObjectInterface;
use App\Mapper\Dashboard\ContactRequestMapper;
use App\Service\Dashboard\Contracts\ContactManagementServiceInterface;

class ContactController extends AbstractDashboardController
{
    use HasUpdateAction;

    public function __construct(
        public ContactManagementServiceInterface $service,
        private readonly ContactRequestMapper    $contactRequestMapper,
        ContextController                        $contextController,
    ) {
        parent::__construct($contextController);
    }

    protected function getModuleName(): string
    {
        return 'contact';
    }

    public function editAction(): void
    {
        $this->renderPage([
            'page' => 'contact/edit',
            'data' => $this->service->getContact(),
        ]);
    }

    protected function getDataToUpdate(): ContactDto
    {
        return $this->contactRequestMapper->mapUpdate();
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var ContactDto $data */
        $this->service->updateContact($data);
    }
}
