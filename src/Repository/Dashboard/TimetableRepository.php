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
            WHEN TRIM(day) = 'PON' THEN 1
            WHEN TRIM(day) = 'WT' THEN 2
            WHEN TRIM(day) = 'ŚR' THEN 3
            WHEN TRIM(day) = 'CZW' THEN 4
            WHEN TRIM(day) = 'PT' THEN 5
            WHEN TRIM(day) = 'SOB' THEN 6
            WHEN TRIM(day) = 'NIEDZ' THEN 7
            ELSE 8
        END ASC, start ASC";

            $result = $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);

            return array_map(fn(array $row) => $this->mapToDto($row), $result);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać danych grafiku.', 500, $e);
        }
    }
}