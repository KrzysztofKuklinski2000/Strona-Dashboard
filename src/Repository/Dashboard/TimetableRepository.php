<?php

namespace App\Repository\Dashboard;

use App\Exception\RepositoryException;
use App\Repository\AbstractRepository;
use PDO;

class TimetableRepository extends AbstractRepository {
    public function timetablePageData(): array
    {
        try {
        $sql = "SELECT * FROM timetable ORDER BY 
                CASE 
                    WHEN day = 'PON' THEN 1
                    WHEN day = 'WT' THEN 2
                    WHEN day = 'ŚR' THEN 3
                    WHEN day = 'CZW' THEN 4
                    WHEN day = 'PT' THEN 5
                    WHEN day = 'SOB' THEN 6
                END ASC, start ASC";

        return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
    } catch (RepositoryException $e) {
        throw new RepositoryException('Nie udało się pobrać danych grafiku.', 500, $e);
    }
  }
}