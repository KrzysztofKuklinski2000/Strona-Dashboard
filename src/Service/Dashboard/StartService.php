<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\StartRepository;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

/**
 * @property StartRepository $repository
 */
class StartService extends AbstractDashboardService implements StartManagementServiceInterface
{
    use CanPublished, CanEdit, PositionableTrait;

    private const TABLE = 'main_page_posts';

    /**
     * @throws ServiceException
     */
    public function getAllMain(): array
    {
        return $this->getAll(self::TABLE);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     */
    public function updateMain(DataTransferObjectInterface $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    public function createMain(DataTransferObjectInterface $data): void
    {
        $this->create(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function publishedMain(DataTransferObjectInterface $data): void
    {
        $this->published(self::TABLE, $data);
    }

    public function deleteMain(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    public function moveMain(ChangePositionDto $data): void
    {
        $this->move(self::TABLE, $data);
    }
}