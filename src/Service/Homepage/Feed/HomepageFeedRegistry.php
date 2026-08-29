<?php
declare(strict_types=1);

namespace App\Service\Homepage\Feed;

final readonly class HomepageFeedRegistry
{
    /** @var array<string, HomepageFeedProviderInterface> */
    private array $providers;

    /** @param array<HomepageFeedProviderInterface> $providers */
    public function __construct(array $providers)
    {
        $indexedProviders = [];

        foreach ($providers as $provider) {
            $indexedProviders[$provider->module()] = $provider;
        }

        $this->providers = $indexedProviders;
    }

    public function getItems(string $module, int $limit): array {
        $provider = $this->providers[$module] ?? null;

        return $provider?->getItems($limit) ?? [];
    }
}
