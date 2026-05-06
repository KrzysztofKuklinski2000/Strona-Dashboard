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

    public function getUrl(): string{
        return $this->config['app_url'] ?? 'http://localhost:8000';
    }

    public function getTemplatesPath(): string{
        return $this->config['paths']['templates'] ?? dirname(__DIR__, 2) . '/templates';
    }

    public function getUploadDir(): string{
        return $this->config['paths']['uploads_dir'] ?? dirname(__DIR__, 2) . '/public/uploads';
    }

    public function getUploadUrl(): string{
        return $this->config['paths']['uploads_url'] ?? '/public/uploads';
    }

    public function getMaxUploadSize(): int{
        return $this->config['app_settings']['upload_max_size'] ?? 5_000_000;
    }

    public function getFilePrefix(): string{
        return $this->config['app_settings']['file_prefix'] ?? 'karate_';
    }

    public function getDashboardRoute(): string{
        return $this->config['app_settings']['dashboard_route'] ?? '/dashboard';
    }

    public function getLoginRoute(): string{
        return $this->config['app_settings']['login_route'] ?? '/auth/login';
    }

    public function getHomeRoute(): string{
        return $this->config['app_settings']['home_route'] ?? '/';
    }

    public function getRoutesPath(): string{
        return $this->config['paths']['routes'] ?? dirname(__DIR__, 2) . '/config/routes.php';
    }

}