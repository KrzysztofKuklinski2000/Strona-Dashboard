<?php

declare(strict_types=1);

namespace App\Factories\ServiceFactories\Dashboard;

use App\Core\Config;
use App\Core\FileHandler;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\HomepageRepository;
use App\Service\Dashboard\Homepage\ImageTextListImageProcessor;
use App\Service\Dashboard\HomepageService;
use PDO;

readonly class HomepageServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo, private Config $config)
    {
    }

    public function createService(): HomepageService
    {
        $repository = new HomepageRepository($this->pdo);
        $fileHandler = new FileHandler($this->config->getUploadDir(), $this->config->getFilePrefix());
        $imageProcessor = new ImageTextListImageProcessor($fileHandler, $this->config->getUploadUrl());


        return new HomepageService($repository, $imageProcessor);
    }
}
