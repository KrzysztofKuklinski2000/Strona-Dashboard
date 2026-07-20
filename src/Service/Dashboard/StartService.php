<?php

namespace App\Service\Dashboard;

use App\Content\MainPagePostTypes;
use App\Core\FileHandler;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateMainPagePostDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\FileException;
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

    public function __construct(
        StartRepository            $repository,
        private readonly FileHandler $fileHandler,
        private readonly string $uploadUrl
    )
    {
        parent::__construct($repository);
    }

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

    /**
     * @throws ServiceException
     */
    public function createMain(DataTransferObjectInterface $data): void
    {
        $dataToUpload = $data;

        try {
            if($data->type === MainPagePostTypes::IMAGE_TEXT_LIST) {
                $imageName = $this->fileHandler->uploadImage($data->imageFile);
                $dir = $this->uploadUrl .'/'. $imageName;

                $payload = json_decode($data->payload, true);
                $payload['image']['src'] = $dir;

                $payload = json_encode($payload, JSON_UNESCAPED_UNICODE);

                $dataToUpload = CreateMainPagePostDto::fromArray([
                    'title' => $data->title,
                    'created' => $data->created,
                    'updated' => $data->updated,
                    'status' => $data->status,
                    'type' => $data->type,
                    'payload' => $payload,
                ]);
            }
        }catch (FileException $e) {
            throw new ServiceException("Nie udało się wgrać zdjęcia na serwer", 500, $e);
        }

        $this->create(self::TABLE, $dataToUpload);
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
