<?php

namespace App\Service\Dashboard;

use App\Content\MainPagePostTypes;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateMainPagePostDto;
use App\DTO\Dashboard\UpdateMainPagePostDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\FileException;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\StartRepository;
use App\Service\Dashboard\Contracts\StartManagementServiceInterface;
use App\Service\Dashboard\MainPage\ImageTextListUploadProcessor;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;
use JsonException;

/**
 * @property StartRepository $repository
 */
class StartService extends AbstractDashboardService implements StartManagementServiceInterface
{
    use CanPublished, CanEdit, PositionableTrait;

    private const TABLE = 'main_page_posts';
    private const NEW_POST_POSITION = 2;

    public function __construct(
        StartRepository            $repository,
        private readonly ImageTextListUploadProcessor $uploadProcessor,
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
        $dataToUpload = UpdateMainPagePostDto::fromArray([
            'id' => $data->id,
            'title' => $data->title,
            'updated' => $data->updated,
            'type' => $data->type,
            'payload' => $this->preparePayloadForPersistence($data)
        ]);

        $this->edit(self::TABLE, $dataToUpload);
    }

    /**
     * @throws ServiceException
     */
    public function createMain(DataTransferObjectInterface $data): void
    {
        $dataToUpload = CreateMainPagePostDto::fromArray([
            'title' => $data->title,
            'created' => $data->created,
            'updated' => $data->updated,
            'status' => $data->status,
            'position' => self::NEW_POST_POSITION,
            'type' => $data->type,
            'payload' => $this->preparePayloadForPersistence($data)
        ]);

        $this->create(
            self::TABLE,
            $dataToUpload,
            self::NEW_POST_POSITION,
        );
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

    /**
     * @throws ServiceException
     */
    private function preparePayloadForPersistence(DataTransferObjectInterface $data): ?string {
        if(
            $data->type !== MainPagePostTypes::IMAGE_TEXT_LIST
            || $data->imageFile === null
            || $data->payload === null
        ) {
            return $data->payload;
        }

        try {
            return $this->uploadProcessor->process($data->payload, $data->imageFile);
        }catch (FileException $e) {
            throw new ServiceException("Nie udało się wgrać zdjęcia na serwer", 500, $e);
        }catch (JsonException $e) {
            throw new ServiceException(
                'Nie udało się przygotować danych obrazu',
                500,
                $e,
            );
        }
    }
}
