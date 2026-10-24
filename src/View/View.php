<?php

declare(strict_types=1);

namespace App\View;

readonly class View
{
    public function __construct(private string $templatePath)
    {
    }

    public function renderPageView(array $params): void
    {
        $this->loadHelpers();

        $path = rtrim($this->templatePath, '/') . '/layout.php';

        if (file_exists($path)) {
            require $path;
        }
    }

    public function renderDashboardView(array $params): void
    {
        $this->loadHelpers();

        $path = rtrim($this->templatePath, '/') . '/dashboard/layout.php';

        if (file_exists($path)) {
            require $path;
        }
    }

    public function renderSeoView(string $template, array $params): void
    {
        if (!in_array($template, ['robots', 'sitemap'], true)) {
            throw new \InvalidArgumentException('Nieobsługiwany szablon SEO.');
        }

        require rtrim($this->templatePath, '/') . '/seo/' . $template . '.php';
    }

    private function loadHelpers(): void
    {
        $helpersPath = rtrim($this->templatePath, '/') . '/_helpers.php';

        if (file_exists($helpersPath)) {
            require_once $helpersPath;
        }
    }
}
