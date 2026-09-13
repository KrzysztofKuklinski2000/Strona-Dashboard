<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\Content\NewsPostTypes;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\News\CreateNewsDto;
use App\DTO\Dashboard\News\NewsDto;
use App\DTO\Dashboard\News\UpdateNewsDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\FileException;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\NewsRepository;
use App\Service\Dashboard\Contracts\NewsManagementServiceInterface;
use App\Service\Dashboard\Payload\PayloadImageProcessor;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;
use JsonException;

/**
 * @property NewsRepository $repository
 */
class NewsService extends AbstractDashboardService implements NewsManagementServiceInterface
{
    use PositionableTrait;
    use CanPublished;
    use CanEdit;

    public function __construct(
        NewsRepository                         $repository,
        private readonly PayloadImageProcessor $imageProcessor
    )
    {
        parent::__construct($repository);
    }

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
    public function getPost(int $id): DataTransferObjectInterface
    {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function updateNews(UpdateNewsDto $data): void
    {
        /** @var NewsDto $oldPost */
        $oldPost = $this->getPost($data->id);

        try {
            $oldImageName = $this->imageProcessor->extractImageName($oldPost->payload);
        } catch (JsonException $e) {
            throw new ServiceException(
                'Nie udało się odczytać danych obrazu.',
                500,
                $e,
            );
        }

        $payload = $data->payload;
        $newImageName = null;
        $keepOldImage = NewsPostTypes::supportsImage($data->type)
            && $data->imageFile === null
            && !$data->removeImage;

        if (NewsPostTypes::supportsImage($data->type) && $data->imageFile !== null) {
            try {
                $payload = $this->imageProcessor->process($payload, $data->imageFile);
                $newImageName = $this->imageProcessor->extractImageName($payload);
            } catch (FileException|JsonException $e) {
                throw new ServiceException(
                    'Nie udało się przygotować obrazu.',
                    500,
                    $e,
                );
            }
        } elseif ($keepOldImage && $oldImageName !== null) {
            try {
                $payload = $this->imageProcessor->preserveImageSource(
                    $payload,
                    $oldImageName,
                );
            } catch (JsonException $e) {
                throw new ServiceException(
                    'Nie udało się zachować danych obrazu.',
                    500,
                    $e,
                );
            }
        }

        $dataToUpdate = UpdateNewsDto::fromArray([
            'id' => $data->id,
            'title' => $data->title,
            'updated' => $data->updated,
            'type' => $data->type,
            'payload' => $payload,
            'imageFile' => null,
            'removeImage' => false,
        ]);

        try {
            $this->edit(self::TABLE, $dataToUpdate);
        } catch (ServiceException $e) {
            if ($newImageName !== null) {
                try {
                    $this->imageProcessor->deleteImage($newImageName);
                } catch (FileException $cleanupException) {
                    throw new ServiceException(
                        'Nie udało się zapisać posta ani usunąć nowego obrazu.',
                        500,
                        $cleanupException,
                    );
                }
            }

            throw $e;
        }

        if ($oldImageName === null || $keepOldImage) {
            return;
        }

        try {
            $this->imageProcessor->deleteImage($oldImageName);
        } catch (FileException $e) {
            throw new ServiceException(
                'Zmiany zapisano, ale nie udało się usunąć starego obrazu.',
                500,
                $e,
            );
        }
    }

    /**
     * @throws ServiceException
     */
    public function createNews(CreateNewsDto $data): void
    {
        $imageFile = $data->imageFile ?? null;
        $payload = $data->payload ?? null;
        $dataToUpload = $data;
        $newImageName = null;

        if (NewsPostTypes::supportsImage($data->type) && $imageFile !== null) {
            try {
                $newPayload = $this->imageProcessor->process($payload, $imageFile);
                $newImageName = $this->imageProcessor->extractImageName($newPayload);
            } catch (FileException|JsonException $e) {
                throw new ServiceException(
                    'Nie udało się przygotować obrazu.',
                    500,
                    $e,
                );
            }



            $dataToUpload = CreateNewsDto::fromArray([
                'title' => $data->title,
                'created' => $data->created,
                'updated' => $data->updated,
                'status' => $data->status,
                'type' => $data->type,
                'payload' => $newPayload,
                'imageFile' => null
            ]);
        }

        try {
            $this->create(self::TABLE, $dataToUpload);
        } catch (ServiceException $e) {
            if ($newImageName !== null) {
                try {
                    $this->imageProcessor->deleteImage($newImageName);
                } catch (FileException $cleanupException) {
                    throw new ServiceException(
                        'Nie udało się zapisać posta ani usunąć przesłanego obrazu.',
                        500,
                        $cleanupException,
                    );
                }
            }

            throw $e;
        }
    }

    /**
     * @throws ServiceException
     */
    public function publishedNews(PublishedDto $data): void
    {
        $this->published(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function deleteNews(int $id): void
    {
        /** @var NewsDto $post */
        $post = $this->getPost($id);

        try {
            $imageName = $this->imageProcessor->extractImageName($post->payload);
        }catch (JsonException $e) {
            throw new ServiceException(
                'Nie udało się odczytać danych obrazu.',
                500,
                $e,
            );
        }

        $this->delete(self::TABLE, $id);

        if($imageName === null) {
            return;
        }

        try {
            $this->imageProcessor->deleteImage($imageName);
        }catch (FileException $e) {
            throw new ServiceException(
                'Post został usunięty, ale nie udało się usunąć pliku obrazu.',
                500,
                $e
            );
        }


    }

    /**
     * @throws ServiceException
     */
    public function moveNews(ChangePositionDto $data): void
    {
        $this->move(self::TABLE, $data);
    }
}
