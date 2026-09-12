<?php

declare(strict_types=1);

namespace App\Factories\ServiceFactories\Dashboard;

use App\Core\Config;
use App\Core\FileHandler;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\NewsRepository;
use App\Service\Dashboard\NewsService;
use App\Service\Dashboard\Payload\PayloadImageProcessor;
use PDO;

class NewsServiceFactory implements ServiceFactoryInterface
{
    public function __construct(
        private PDO $pdo,
        private Config $config
    )
    {
    }

    public function createService(): NewsService
    {
        $repository = new NewsRepository($this->pdo);
        $fileHandler = new FileHandler($this->config->getUploadDir(), $this->config->getFilePrefix());
        $imageProcessor = new PayloadImageProcessor($fileHandler, $this->config->getUploadUrl());

        return new NewsService($repository, $imageProcessor);
    }
}
