<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\Location\LocationDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\CanCreate;
use App\Repository\Dashboard\Traits\CanDelete;
use App\Repository\Dashboard\Traits\CanEdit;

class LocationRepository extends BaseDashboardRepository
{
    use CanCreate;
    use CanEdit;
    use CanDelete;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return LocationDto::fromArray($data);
    }

    /**
     * @throws RepositoryException
     */
    public function isUsedByTimetable(int $id): bool {
        try {
            return $this->runQuery('SELECT 1 FROM timetable WHERE location_id = :id LIMIT 1', [
                ':id' => $id
            ])->fetchColumn() !== false;
        }catch (RepositoryException $e){
            throw new RepositoryException(
                'Nie udało się sprawdzić, czy lokalizacja jest używana.',
                500,
                $e,
            );
        }
    }
}