<?php

declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\TimetableDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\CanPublished;
use App\Repository\Dashboard\Traits\StandardCrud;
use PDO;

class TimetableRepository extends BaseDashboardRepository
{
    use StandardCrud;
    use CanPublished;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return TimetableDto::fromArray($data);
    }

    /**
     * @return TimetableDto[]
     * @throws RepositoryException
     */
    public function timetablePageData(?int $limit = null, bool $publishedOnly = false): array
    {
        try {
            $params = [];
            $sql = "SELECT * FROM timetable";

            if($publishedOnly === true) {
                $sql .= " WHERE status = 1";
            }

            $sql .= " ORDER BY
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

            if($limit !== null) {
                $sql .= " LIMIT :limit";
                $params[':limit'] = [$limit, PDO::PARAM_INT];
            }

            $result = $this->runQuery($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

            return array_map(fn (array $row) => $this->mapToDto($row), $result);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać danych grafiku.', 500, $e);
        }
    }
}
