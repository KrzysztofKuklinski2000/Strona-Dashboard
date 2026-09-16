<?php
declare(strict_types=1);

namespace App\Repository\Analytics;

use App\Exception\RepositoryException;
use App\Repository\AbstractRepository;

class PageViewRepository extends AbstractRepository
{
    /**
     * @throws RepositoryException
     */
    public function record(string $path): void {
        try {
            $this->runQuery(
                'INSERT INTO page_views (path) VALUES (:path)',
                [':path' => $path]
            );
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się zapisać odsłony', 500, $e);
        }
    }
}