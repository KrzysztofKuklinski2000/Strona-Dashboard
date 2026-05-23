<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\ImportantPostsDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;

use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class ImportantPostsService extends AbstractDashboardService implements ImportantPostsManagementServiceInterface
{
    use PositionableTrait, CanPublished, CanEdit;

    private const TABLE = 'important_posts';

    /**
     * @throws ServiceException
     */
    public function getAllImportantPosts(): array
    {

        return $this->getAll(self::TABLE);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     */
    public function updateImportantPost(DataTransferObjectInterface $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    public function createImportantPost(DataTransferObjectInterface $data): void
    {
        $this->create(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function publishedImportantPost(DataTransferObjectInterface $data): void
    {
        $this->published(self::TABLE, $data);
    }

    public function deleteImportantPost(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    public function moveImportantPost(ChangePositionDto $data): void
    {
        $this->move(self::TABLE, $data);
    }
}
