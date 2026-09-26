<?php
declare(strict_types=1);

namespace App\Factories\ServiceFactories;

use App\Core\Config;
use App\Repository\PublicNewsRepository;
use App\Service\PublicNewsService;
use PDO;

readonly class PublicNewsServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo, private Config $config)
    {
    }

    public function createService(): PublicNewsService
    {
        $repository = new PublicNewsRepository($this->pdo);

        return new PublicNewsService(
            $repository,
            $this->config->getItemsPerPage()
        );
    }
}