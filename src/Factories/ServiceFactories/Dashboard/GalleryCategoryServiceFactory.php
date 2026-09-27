<?php
declare(strict_types=1);

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\GalleryCategoryRepository;
use App\Service\Dashboard\GalleryCategoryService;
use PDO;

readonly class GalleryCategoryServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createService(): GalleryCategoryService
    {
        $repository = new GalleryCategoryRepository($this->pdo);

        return new GalleryCategoryService($repository);
    }
}