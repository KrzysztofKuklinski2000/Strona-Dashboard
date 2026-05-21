<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\Dashboard\CampDto;
use App\DTO\Dashboard\ContactDto;
use App\DTO\Dashboard\FeesDto;
use App\DTO\Dashboard\TimetableDto;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\TimetableRepository;
use App\Repository\SiteRepository;

readonly class SiteService
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
    public function getNews(int $page, int $perPage = null): array
    {
        try {
            $limit = $perPage ?? $this->itemsPerPage;
            $totalPages = ceil($this->siteRepository->countData('news') / $limit);
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
    public function getFrontPage(): array
    {
        try {
            $firstPost = null;
            $posts = $this->siteRepository->getMainPagePosts();
            $importantPosts = $this->siteRepository->getImportantPosts();

            foreach ($posts as $key => $post) {
                if ($post->id === 1) {
                    $firstPost = $post;
                    unset($posts[$key]);
                    break;
                }
            }

            return [$posts, $importantPosts, $firstPost];

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

            return array_map(fn(array $row) => TimetableDto::fromArray($row), $this->timetableRepository->timetablePageData());
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