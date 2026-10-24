<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\Seo\SearchIndexing;
use App\Service\SitemapService;

final class SeoController extends AbstractController
{
    public function __construct(
        private readonly SitemapService $sitemapService,
        ContextController $contextController,
    ) {
        parent::__construct($contextController);
    }

    public function robotsAction(): void
    {
        $indexingAllowed = (new SearchIndexing($this->contextController->config))->isAllowed($this->request);

        header('Content-Type: text/plain; charset=UTF-8');
        header('Cache-Control: no-cache');

        $this->view->renderSeoView('robots', [
            'indexing_allowed' => $indexingAllowed,
            'sitemap_url' => $this->contextController->config->getUrl() . '/sitemap.xml',
        ]);
    }

    public function sitemapAction(): void
    {
        $urls = $this->sitemapService->getUrls();

        header('Content-Type: application/xml; charset=UTF-8');
        header('Cache-Control: no-cache');

        $this->view->renderSeoView('sitemap', ['urls' => $urls]);
    }
}
