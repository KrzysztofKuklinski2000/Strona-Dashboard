<?php

declare(strict_types=1);

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\OverviewRepository;
use App\Service\Dashboard\OverviewService;
use PDO;

readonly class OverviewServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createService(): OverviewService
    {
        return new OverviewService(new OverviewRepository($this->pdo));
    }
}
