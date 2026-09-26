<?php

declare(strict_types=1);

namespace App\Service;

use App\Content\HomepagePostTypes;
use App\DTO\Dashboard\Camp\CampDto;
use App\DTO\Dashboard\Fees\FeesDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\TimetableRepository;
use App\Repository\SiteRepository;
use App\Service\Homepage\Feed\HomepageFeedRegistry;

readonly class SiteService
{
    public function __construct(
        private SiteRepository      $siteRepository,
        private TimetableRepository $timetableRepository,
        private HomepageFeedRegistry $homepageFeedRegistry,
    )
    {
    }
    /**
     * @throws ServiceException
     */
    public function getHomepageData(): array
    {
        try {
            $posts = $this->siteRepository->getHomepagePosts();

            $homepageFeeds = [];

            foreach ($posts as $post) {
                if ($post->type !== HomepagePostTypes::MODULE_FEED) {
                    continue;
                }

                $payload = json_decode($post->payload ?? '', true);



                if (!is_array($payload)) {
                    continue;
                }

                $module = $payload['module'] ?? null;

                if(!is_string($module)) {
                    continue;
                }

                $limit = max(1, min(12, (int)($payload['limit'] ?? 3)));

                $homepageFeeds[$post->id] = $this->homepageFeedRegistry->getItems(
                    $module,
                    $limit
                );
            }


            return [
                'homepagePosts' => $posts,
                'homepageFeeds' => $homepageFeeds,
            ];

        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getGallery(?string $category = null): array
    {
        try {
            return $this->siteRepository->getGallery($category);
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać galeri", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getTimetable(): array
    {
        try {
            return $this->timetableRepository->timetablePageData(
                publishedOnly: true,
            );
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać grafiku", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getCamp(): CampDto
    {
        try {
            return $this->siteRepository->getCamp();
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych o obozach", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getFees(): FeesDto
    {
        try {
            return $this->siteRepository->getFees();
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych o składkach", 500, $e);
        }
    }
}
