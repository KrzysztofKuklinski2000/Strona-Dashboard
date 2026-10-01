<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\LocationRepository;
use App\Service\Dashboard\LocationService;
use PDO;

readonly class LocationServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createService(): LocationService
    {
        $repository = new LocationRepository($this->pdo);

        return new LocationService($repository);
    }
}