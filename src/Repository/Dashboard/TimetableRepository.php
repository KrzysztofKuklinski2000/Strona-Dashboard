<?php

declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\Timetable\TimetableDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
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
     * @throws RepositoryException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): TimetableDto
    {
        try {
            $result = $this->runQuery(
                $this->selectWithLocation($table) . ' WHERE t.id = :id',
                [':id' => $id],
            )->fetch(PDO::FETCH_ASSOC);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać wpisu grafiku.', 500, $e);
        }

        if ($result === false) {
            throw new NotFoundException('Nie ma takiego wpisu grafiku.', 404);
        }

        return TimetableDto::fromArray($result);
    }

    private function selectWithLocation(string $table): string
    {
        return "SELECT
                    t.*,
                    l.name AS location_name,
                    l.city AS location_city,
                    l.address AS location_address,
                    l.map_embed_url AS location_map_embed_url
                FROM {$table} AS t
                LEFT JOIN locations AS l ON l.id = t.location_id";
    }

    /**
     * @return TimetableDto[]
     * @throws RepositoryException
     */
    public function timetablePageData(?int $limit = null, bool $publishedOnly = false): array
    {
        try {
            $params = [];
            $sql = $this->selectWithLocation('timetable');

            if($publishedOnly === true) {
                $sql .= " WHERE t.status = 1";
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
                END ASC, t.start ASC";

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
