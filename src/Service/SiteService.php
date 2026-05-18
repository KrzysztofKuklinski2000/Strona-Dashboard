<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\Dashboard\CampDto;
use App\DTO\Dashboard\ContactDto;
use App\DTO\Dashboard\FeesDto;
use App\DTO\Dashboard\GalleryDto;
use App\DTO\Dashboard\ImportantPostsDto;
use App\DTO\Dashboard\MainPageDto;
use App\DTO\Dashboard\NewsDto;
use App\DTO\Dashboard\TimetableDto;
use App\DTO\DataTransferObjectInterface;
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

            $news = array_map(fn(array $row) => NewsDto::fromArray($row), $news);

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
            $posts = $this->siteRepository->getData("main_page_posts");
            $importantPosts = $this->siteRepository->getData("important_posts");

            foreach ($posts as $key => $post) {
                if ($post['id'] === 1) {
                    $firstPost = MainPageDto::fromArray($post);
                    unset($posts[$key]);
                    break;
                }
            }

            $posts = array_map(fn(array $row) => MainPageDto::fromArray($row), $posts);
            $importantPosts =  array_map(fn(array $row) => ImportantPostsDto::fromArray($row), $importantPosts);

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
            return array_map(fn(array $row) => GalleryDto::fromArray($row), $this->siteRepository->getGallery($category));
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
    public function getContact(): DataTransferObjectInterface
    {
        try {
            return ContactDto::fromArray($this->siteRepository->getSingleRecord('contact'));
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych kontaktowych", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getCamp(): DataTransferObjectInterface
    {
        try {
            return CampDto::fromArray($this->siteRepository->getSingleRecord('camp'));
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych o obozach", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getFees(): DataTransferObjectInterface
    {
        try {
            return FeesDto::fromArray($this->siteRepository->getSingleRecord('fees'));
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych o składkach", 500, $e);
        }
    }

}