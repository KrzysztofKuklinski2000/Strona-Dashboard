<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\MainPageDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class StartService extends AbstractDashboardService implements StartManagementServiceInterface
{
    use CanPublished, CanEdit, PositionableTrait;

    private const TABLE = 'main_page_posts';

    /**
     * @throws ServiceException
     */
    public function getAllMain(): array
    {
        return array_map(fn(array $row) => MainPageDto::fromArray($row), $this->getAll(self::TABLE));
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {
        return MainPageDto::fromArray($this->getRow($table, $id));
    }

    /**
     * @throws ServiceException
     */
    public function updateMain(DataTransferObjectInterface $data): void
    {
        $this->edit(self::TABLE, $data->toArray());
    }

    public function createMain(DataTransferObjectInterface $data): void
    {
        $this->create(self::TABLE, $data->toArray());
    }

    /**
     * @throws ServiceException
     */
    public function publishedMain(DataTransferObjectInterface $data): void
    {
        $this->published(self::TABLE, $data->toArray());
    }

    public function deleteMain(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    public function moveMain(DataTransferObjectInterface $data): void
    {
        $this->move(self::TABLE, $data->toArray());
    }
}
