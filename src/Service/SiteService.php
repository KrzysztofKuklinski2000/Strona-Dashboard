<?php 
declare(strict_types= 1);
namespace App\Service;

use App\Exception\StorageException;
use App\Model\SiteRepository;
use Throwable;

class SiteService {
    public function __construct(public SiteRepository $siteRepository) {}

    public function getNews(int $page): array {
        try {
            $perPage = 10;
            $totalPages = ceil($this->siteRepository->countData('news') / $perPage);
            $page = max(1, min($page, $totalPages));
            $offset = ($page-1) * $perPage;

            $news = $this->siteRepository->getNews($perPage, $offset);

            return [
                'data' => $news, 
                'currentPage' => $page,
                'totalPages' => $totalPages,
            ];
        }catch(Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych", 500, $e);
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

        }catch(Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych",500, $e);
        }
    }

    public function getGallery(string $category = null): array {
        try {
            return $this->siteRepository->getGallery($category);
        }catch(Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych",500, $e);
        }
    }

    public function getTimetable(): array {
        try {
            return $this->siteRepository->timetablePageData();
        }catch(Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych",500, $e);
        }
    }

    public function getContact(): array {
        try {
            return $this->siteRepository->getSingleRecord('contact');
        }catch(Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych",500, $e);
        }
    }

    public function getCamp(): array {
        try {
            return $this->siteRepository->getSingleRecord('camp');
        }catch(Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych",500, $e);
        }
    }

    public function getFees(): array { 
        try {
            return $this->siteRepository->getSingleRecord('fees');
        }catch(Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych",500, $e);
        }
    }

}