<?php

declare(strict_types=1);

namespace App\Service;

use App\Content\HomepageFeedModules;
use App\Content\HomepagePostTypes;
use App\DTO\Dashboard\CampDto;
use App\DTO\Dashboard\ContactDto;
use App\DTO\Dashboard\FeesDto;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\TimetableRepository;
use App\Repository\SiteRepository;
use App\Service\Contracts\ContactProviderInterface;

readonly class SiteService implements ContactProviderInterface
{
    public function __construct(
        private SiteRepository      $siteRepository,
        private TimetableRepository $timetableRepository,
        private int                 $itemsPerPage
    )
    {
    }

    /**
     * @throws ServiceException
     */
    public function getNews(int $page, ?int $perPage = null): array
    {
        try {
            $limit = $perPage ?? $this->itemsPerPage;
            $totalPages = (int)ceil($this->siteRepository->countPublishedNews() / $limit);
            $totalPages = max(1, $totalPages);
            $page = max(1, min($page, $totalPages));
            $offset = (int)(($page - 1) * $limit);

            $news = $this->siteRepository->getNews($limit, $offset);

            return [
                'data' => $news,
                'currentPage' => (int)$page,
                'totalPages' => $totalPages,
            ];
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getHomepageData(): array
    {
        try {
            $posts = $this->siteRepository->getHomepagePosts();
            $importantPosts = $this->siteRepository->getImportantPosts();


            $homepageFeeds = [];

            foreach ($posts as $post) {
                if ($post->type !== HomepagePostTypes::MODULE_FEED) {
                    continue;
                }

                $payload = json_decode($post->payload ?? '', true);


                if (!is_array($payload)) {
                    continue;
                }

                $limit = max(1, min(12, (int)($payload['limit'] ?? 3)));

                $homepageFeeds[$post->id] = match ($payload['module'] ?? null) {
                    HomepageFeedModules::NEWS => $this->siteRepository->getNews($limit, 0),
                    HomepageFeedModules::GALLERY => $this->siteRepository->getGallery(limit: $limit),
                    default => [],
                };
            }


            return [
                'homepagePosts' => $posts,
                'importantPosts' => $importantPosts,
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
            return $this->timetableRepository->timetablePageData();
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać grafiku", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getContact(): ContactDto
    {
        try {
            return $this->siteRepository->getContact();
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych kontaktowych", 500, $e);
        }
    }

    /**
     * @throws ServiceException
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
