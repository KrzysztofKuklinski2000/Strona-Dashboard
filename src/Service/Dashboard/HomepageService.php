<?php

namespace App\Service\Dashboard;

use App\Content\HomepagePostTypes;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateHomepagePostDto;
use App\DTO\Dashboard\HomepagePostDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateHomepagePostDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\FileException;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\HomepageRepository;
use App\Service\Dashboard\Contracts\HomepageManagementServiceInterface;
use App\Service\Dashboard\Homepage\ImageTextListImageProcessor;
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
        HomepageRepository                           $repository,
        private readonly ImageTextListImageProcessor $processor,
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
    public function getPost(int $id): DataTransferObjectInterface
    {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function updateHomepagePost(UpdateHomepagePostDto $data): void
    {
        /** @var HomepagePostDto $oldPost */
        $oldPost = $this->getPost($data->id);
        $oldImageName = $this->prepareImageForDeletion($oldPost);

        $dataToUpload = UpdateHomepagePostDto::fromArray([
            'id' => $data->id,
            'title' => $data->title,
            'updated' => $data->updated,
            'type' => $data->type,
            'payload' => $this->preparePayloadForPersistence($data)
        ]);

        if (!is_array($data->imageFile)) {
            $this->edit(self::TABLE, $dataToUpload);

            if ($data->type === HomepagePostTypes::IMAGE_TEXT_LIST) {
                return;
            }
        } else {
            try {
                $this->edit(self::TABLE, $dataToUpload);
            } catch (ServiceException $e) {
                try {
                    $newImageName = $this->prepareImageForDeletion($dataToUpload);
                    $this->processor->deleteImage($newImageName);
                } catch (FileException $e) {
                    throw new ServiceException('Nie udało się usunać nowego zdjęcia');
                }

                throw $e;
            }
        }

        try {
            if ($oldImageName === null) {
                return;
            }

            $this->processor->deleteImage($oldImageName);
        } catch (FileException $e) {
            throw new ServiceException(
                'Zmiany zapisano, ale nie udało się usunąć starego zdjęcia.',
                500,
                $e,
            );
        }
    }

    /**
     * @throws ServiceException
     * @throws FileException
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

        try {
            $this->create(self::TABLE, $dataToUpload, self::NEW_POST_POSITION);
        } catch (ServiceException $e) {
            try {
                $imageName = $this->prepareImageForDeletion($dataToUpload);
                if($imageName !== null) {
                    $this->processor->deleteImage($imageName);
                }
            }catch (FileException $cleanupException) {
                throw new ServiceException(
                    'Nie udało się zapisać posta ani usunąć przesłanego obrazu.',
                    500,
                    $cleanupException,
                );
            }
            throw $e;
        }
    }

    /**
     * @throws ServiceException
     */
    public function publishedHomepagePost(PublishedDto $data): void
    {
        $this->published(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function deleteHomepagePost(int $id): void
    {
        /** @var HomepagePostDto $post */
        $post = $this->getPost($id);

        $imageName = $this->prepareImageForDeletion($post);

        $this->delete(self::TABLE, $id);

        if ($imageName === null) {
            return;
        }

        try {
            $this->processor->deleteImage($imageName);
        } catch (FileException $e) {
            throw new ServiceException('Post został usunięty, ale nie udało się usunąć pliku obrazu.', 500, $e);
        }
    }

    public function moveHomepagePost(ChangePositionDto $data): void
    {
        $this->move(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    private function preparePayloadForPersistence(UpdateHomepagePostDto|CreateHomepagePostDto $data): ?string
    {
        if (
            $data->type !== HomepagePostTypes::IMAGE_TEXT_LIST
            || $data->imageFile === null
            || $data->payload === null
        ) {
            return $data->payload;
        }

        try {
            return $this->processor->process($data->payload, $data->imageFile);
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

    /**
     * @throws ServiceException
     */
    private function prepareImageForDeletion(
        HomepagePostDto|UpdateHomepagePostDto|CreateHomepagePostDto $data
    ): ?string
    {
        if ($data->type !== HomepagePostTypes::IMAGE_TEXT_LIST || $data->payload === null) {
            return null;
        }

        try {
            return $this->processor->extractImageName($data->payload);
        } catch (JsonException $e) {
            throw new ServiceException('Nie udało się odczytać danych obrazu.', 500, $e);
        }
    }
}
