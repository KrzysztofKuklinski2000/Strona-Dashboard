<?php

namespace App\Controller\Dashboard;

use App\Controller\AbstractController;
use App\Core\ContextController;

abstract class AbstractDashboardController extends AbstractController
{

    public function __construct(
        ContextController $contextController,
    )
    {
        parent::__construct($contextController);
    }

    abstract protected function getModuleName(): string;

    protected function renderPage(array $params): void
    {
        $params['flash_dashboard'] = $this->sessionManager->getFlash();
        $params['csrf_token'] = $this->csrfMiddleware->generateToken('admin');
        $this->view->renderDashboardView($params);
    }
}
