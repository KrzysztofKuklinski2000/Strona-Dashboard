<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateNewsDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateNewsDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\NewsRepository;
use App\Service\Dashboard\Contracts\NewsManagementServiceInterface;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

/**
 * @property NewsRepository $repository
 */
class NewsService extends AbstractDashboardService implements NewsManagementServiceInterface
{
    use PositionableTrait, CanPublished, CanEdit;

    private const TABLE = 'news';

    /**
     * @throws ServiceException
     */
    public function getAllNews(): array
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
    public function updateNews(UpdateNewsDto $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    public function createNews(CreateNewsDto $data): void
    {
        $this->create(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function publishedNews(PublishedDto $data): void
    {
        $this->published(self::TABLE, $data);
    }

    public function deleteNews(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    public function moveNews(ChangePositionDto $data): void
    {
        $this->move(self::TABLE, $data);
    }
}