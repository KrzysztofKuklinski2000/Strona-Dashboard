<?php

namespace App\Core;

readonly class Config
{
    public function __construct(private array $config)
    {
    }

    public function getDbConfig(): array {
        return $this->config['db'] ?? [];
    }

    public function getEnv(): string{
        return $this->config['env'] ?? 'prod';
    }
}