<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\Location\LocationDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\CanCreate;
use App\Repository\Dashboard\Traits\CanDelete;
use App\Repository\Dashboard\Traits\CanEdit;
use App\Repository\Dashboard\Traits\CanPublished;

class LocationRepository extends BaseDashboardRepository
{
    use CanCreate;
    use CanEdit;
    use CanDelete;
    use CanPublished;

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

    /**
     * @throws RepositoryException
     */
    public function getActiveLocations(): array {
        try {
            $locations = $this->runQuery('SELECT * FROM locations WHERE status = 1')->fetchAll();

            return array_map(fn($location) => LocationDto::fromArray($location), $locations);
        }catch (RepositoryException $e){
            throw new RepositoryException(
                'Nie udało się pobrać aktywnych lokalizacji.',
                500,
                $e,
            );
        }
    }

}