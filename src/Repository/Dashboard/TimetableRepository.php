<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\TimetableDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\CanPublished;
use App\Repository\Dashboard\Traits\StandardCrud;
use PDO;

class TimetableRepository extends BaseDashboardRepository {

    use StandardCrud, CanPublished;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return TimetableDto::fromArray($data);
    }

    /**
     * @return TimetableDto[]
     * @throws RepositoryException
     */
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

            $result = $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);

            return array_map(fn(array $row) => $this->mapToDto($row), $result);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać danych grafiku.', 500, $e);
        }
    }
}