<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\Dashboard\News\NewsDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\PublicNewsRepository;

readonly class PublicNewsService
{

    public function __construct(
        private PublicNewsRepository $repository,
        private int            $itemsPerPage
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
            $totalPages = (int)ceil($this->repository->countPublishedNews() / $limit);
            $totalPages = max(1, $totalPages);
            $page = max(1, min($page, $totalPages));
            $offset = (int)(($page - 1) * $limit);

            $news = $this->repository->getNews($limit, $offset);

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
    public function getSingleNews(int $id): NewsDto {
        try {
            return $this->repository->getSingleNews($id);
        }catch (RepositoryException | NotFoundException $e) {
            throw new ServiceException('Nie udało się pobrać wpisu', 500, $e);
        }
    }
}