<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\ContactDto;
use App\DTO\DataTransferObjectInterface;
use App\Factories\ServiceFactories\Dashboard\ContactServiceFactory;
use App\Mapper\Dashboard\ContactRequestMapper;
use App\Service\Dashboard\ContactManagementServiceInterface;

class ContactController extends AbstractDashboardController
{
    use HasUpdateAction;

    public function __construct(
        public ContactManagementServiceInterface $service,
        private ContactRequestMapper $contactRequestMapper,
        ContextController                        $contextController,
    )
    {
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

    protected function getDataToUpdate(): DataTransferObjectInterface
    {
        return $this->contactRequestMapper->mapUpdate();
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var ContactDto $data */
        $this->service->updateContact($data);
    }
}
