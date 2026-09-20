<?php
declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\Exception\RepositoryException;
use App\Repository\AbstractRepository;
use PDO;

class OverviewRepository extends AbstractRepository
{

    /**
     * @throws RepositoryException
     */
    public function getContentSummary(): array {
        try {
            $sql = "SELECT 
            (SELECT COUNT(*) FROM news) AS totalNews,
            (SELECT COUNT(*) FROM news WHERE status = 1) AS publishedNews,
            (SELECT COUNT(*) FROM homepage_posts) AS totalHomepagePosts,
            (SELECT COUNT(*) FROM homepage_posts WHERE status = 1) AS publishedHomepagePosts,
            (SELECT COUNT(*) FROM gallery) AS totalGallery,
            (SELECT COUNT(*) FROM gallery WHERE status = 1) AS publishedGallery,
            (SELECT COUNT(*) FROM important_posts) AS totalImportantPosts,
            (SELECT COUNT(*) FROM important_posts WHERE status = 1) AS publishedImportantPosts,
            (SELECT COUNT(*) FROM timetable) AS totalTimetable,
            (SELECT COUNT(*) FROM timetable WHERE status = 1) AS publishedTimetable,
            (SELECT COUNT(*) FROM subscribers) AS totalSubscribers,
            (SELECT COUNT(*) FROM subscribers WHERE is_active = 1) AS activeSubscribers";

            $result = $this->runQuery($sql)->fetch(PDO::FETCH_ASSOC);

            return array_map(fn(mixed $item): int => (int) $item, $result);
        }catch (RepositoryException $e) {
            throw new RepositoryException(
                'Nie udało się pobrać podsumowania zawartości strony',
                500,
                $e
            );
        }
    }
}