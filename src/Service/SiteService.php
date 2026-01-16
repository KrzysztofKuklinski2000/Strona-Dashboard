<?php 
declare(strict_types= 1);
namespace App\Service;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\SiteRepository;

class SiteService {
    public function __construct(public SiteRepository $siteRepository) {}

    public function getNews(int $page, int $perPage = 10): array {
        try {
            $totalPages = ceil($this->siteRepository->countData('news') / $perPage);
            $page = max(1, min($page, $totalPages));
            $offset = (int) (($page-1) * $perPage);
            $news = $this->siteRepository->getNews($perPage, $offset);

            return [
                'data' => $news, 
                'currentPage' => (int) $page,
                'totalPages' => $totalPages,
            ];
        }catch(RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych", 500, $e);
        }
    }

    public function getFrontPage(): array {
        try {
            $firstPost = [];
            $posts = $this->siteRepository->getData("main_page_posts");
            $importantPosts = $this->siteRepository->getData("important_posts");

            foreach($posts as $key =>  $post) {
                if($post['id'] === 1) {
                    $firstPost = $post;
                    unset($posts[$key]);
                    break;
                } 
            }

            return [$posts, $importantPosts, $firstPost];

        }catch(RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych",500, $e);
        }
    }

    public function getGallery(string $category = null): array {
        try {
            return $this->siteRepository->getGallery($category);
        }catch(RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać galeri",500, $e);
        }
    }

    public function getTimetable(): array {
        try {
            return $this->siteRepository->timetablePageData();
        }catch(RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać grafiku",500, $e);
        }
    }

    public function getContact(): array {
        try {
            return $this->siteRepository->getSingleRecord('contact');
        }catch(RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych kontaktowych",500, $e);
        }
    }

    public function getCamp(): array {
        try {
            return $this->siteRepository->getSingleRecord('camp');
        }catch(RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych o obozach",500, $e);
        }
    }

    public function getFees(): array { 
        try {
            return $this->siteRepository->getSingleRecord('fees');
        }catch(RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych o składkach",500, $e);
        }
    }

}