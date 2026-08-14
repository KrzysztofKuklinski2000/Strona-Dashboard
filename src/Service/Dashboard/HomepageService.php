<?php

namespace App\Service\Dashboard;

use App\Content\HomepagePostTypes;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateHomepagePostDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateHomepagePostDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\FileException;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\HomepageRepository;
use App\Service\Dashboard\Contracts\HomepageManagementServiceInterface;
use App\Service\Dashboard\Homepage\ImageTextListUploadProcessor;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;
use JsonException;

/**
 * @property HomepageRepository $repository
 */
class HomepageService extends AbstractDashboardService implements HomepageManagementServiceInterface
{
    use CanPublished, CanEdit, PositionableTrait;

    private const TABLE = 'homepage_posts';
    private const NEW_POST_POSITION = 2;

    public function __construct(
        HomepageRepository                            $repository,
        private readonly ImageTextListUploadProcessor $uploadProcessor,
    )
    {
        parent::__construct($repository);
    }

    /**
     * @throws ServiceException
     */
    public function getAllHomepagePosts(): array
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
    public function updateHomepagePost(UpdateHomepagePostDto $data): void
    {
        $dataToUpload = UpdateHomepagePostDto::fromArray([
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
    public function createHomepagePost(CreateHomepagePostDto $data): void
    {
        $dataToUpload = CreateHomepagePostDto::fromArray([
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
    public function publishedHomepagePost(PublishedDto $data): void
    {
        $this->published(self::TABLE, $data);
    }

    public function deleteHomepagePost(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    public function moveHomepagePost(ChangePositionDto $data): void
    {
        $this->move(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    private function preparePayloadForPersistence(UpdateHomepagePostDto | CreateHomepagePostDto $data): ?string
    {
        if (
            $data->type !== HomepagePostTypes::IMAGE_TEXT_LIST
            || $data->imageFile === null
            || $data->payload === null
        ) {
            return $data->payload;
        }

        try {
            return $this->uploadProcessor->process($data->payload, $data->imageFile);
        } catch (FileException $e) {
            throw new ServiceException("Nie udało się wgrać zdjęcia na serwer", 500, $e);
        } catch (JsonException $e) {
            throw new ServiceException(
                'Nie udało się przygotować danych obrazu',
                500,
                $e,
            );
        }
    }
}
