<?php

namespace App\Controller\Dashboard;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\View;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\SubscribersManagementServiceInterface;

class SubscribersController extends AbstractDashboardController
{
    public function __construct(
        private SubscribersManagementServiceInterface $service,
        Request $request,
        EasyCSRF $easyCSRF,
        View $view,
        CsrfMiddleware $csrfMiddleware
    ) {

        parent::__construct($request, $easyCSRF, $service, $view, $csrfMiddleware);
    }

    public function indexAction(): void
    {
        $this->renderPage([
          'page' => 'subscribers/index',
          'data' => $this->service->getAllSubscribers(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'subscribers';
    }
}

