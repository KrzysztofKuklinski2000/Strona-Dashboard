<?php
declare(strict_types=1);

namespace App\View;

use App\Core\ContextController;
use App\Exception\ServiceException;
use App\Service\SiteService;

readonly class PublicPageRenderer
{
    public function __construct(
        private ContextController $context,
        private SiteService       $siteService
    )
    {
    }

    /**
     * @throws ServiceException
     */
    public function render(array $pageSpecificParams): void
    {
        $globalParams = [
            'contact'      => $this->siteService->getContact(),
            'csrf_token'   => $this->context->csrfMiddleware->generateToken(),
            'flash_public' => $this->context->sessionManager->getFlash('public'),
        ];

        $finalParams = array_merge($globalParams, $pageSpecificParams);

        $this->context->view->renderPageView($finalParams);
    }
}