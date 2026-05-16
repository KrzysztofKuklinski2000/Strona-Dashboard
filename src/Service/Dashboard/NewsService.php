<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\NewsDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class NewsService extends AbstractDashboardService implements NewsManagementServiceInterface
{
    use PositionableTrait, CanPublished, CanEdit;

    private const TABLE = 'news';

    /**
     * @throws ServiceException
     */
    public function getAllNews(): array
    {
        return array_map(fn(array $row) => NewsDto::fromArray($row), $this->getAll(self::TABLE));
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {

        return NewsDto::fromArray($this->getRow($table, $id));
    }

    /**
     * @throws ServiceException
     */
    public function updateNews(DataTransferObjectInterface $data): void
    {
        $this->edit(self::TABLE, $data->toArray());
    }

    public function createNews(DataTransferObjectInterface $data): void
    {
        $this->create(self::TABLE, $data->toArray());
    }

    /**
     * @throws ServiceException
     */
    public function publishedNews(DataTransferObjectInterface $data): void
    {
        $this->published(self::TABLE, $data->toArray());
    }

    public function deleteNews(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    public function moveNews(DataTransferObjectInterface $data): void
    {
        $this->move(self::TABLE, $data->toArray());
    }


}
