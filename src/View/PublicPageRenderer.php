<?php

declare(strict_types=1);

namespace App\View;

use App\Core\ContextController;
use App\Seo\PublicPageMetadata;
use App\Seo\SearchIndexing;
use App\Service\Contracts\ContactProviderInterface;

readonly class PublicPageRenderer
{
    public function __construct(
        private ContextController        $context,
        private ContactProviderInterface $contactProvider,
    ) {
    }

    public function render(array $pageSpecificParams): void
    {
        $globalParams = [
            'contact' => $this->contactProvider->getContact(),
            'csrf_token' => $this->context->csrfMiddleware->generateToken(),
            'flash_public' => $this->context->sessionManager->getFlash('public'),
            'base_url' => $this->context->config->getUrl(),
        ];

        $finalParams = array_merge($globalParams, $pageSpecificParams);
        $finalParams['seo'] = PublicPageMetadata::forPage(
            $finalParams,
            $this->context->config->getUrl(),
            (new SearchIndexing($this->context->config))->isAllowed($this->context->request),
        );

        $this->context->view->renderPageView($finalParams);
    }
}
