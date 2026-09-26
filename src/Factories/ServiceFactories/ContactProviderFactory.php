<?php
declare(strict_types=1);

namespace App\Factories\ServiceFactories;

use App\Repository\SiteRepository;
use App\Service\ContactProvider;
use App\Service\Contracts\ContactProviderInterface;
use PDO;

readonly class ContactProviderFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createService(): ContactProviderInterface
    {
        return  new ContactProvider(
            new SiteRepository($this->pdo),
        );
    }
}