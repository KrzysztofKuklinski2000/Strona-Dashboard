<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\LocationRepository;
use App\Repository\Dashboard\TimetableRepository;
use App\Service\Dashboard\LocationService;
use PDO;

readonly class LocationServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createService(): LocationService
    {
        $locationRepository = new LocationRepository($this->pdo);
        $timetableRepository = new TimetableRepository($this->pdo);

        return new LocationService(
            $locationRepository,
            $timetableRepository
        );
    }
}