<?php

namespace App\Controller\Dashboard;

use App\Core\ContextController;
use App\View;
use App\Traits\GetDataMethods;
use App\Middleware\CsrfMiddleware;
use App\Controller\AbstractController;

abstract class AbstractDashboardController extends AbstractController
{

    use GetDataMethods;

    public function __construct(
        ContextController $contextController,
    )
    {
        parent::__construct($contextController);
    }

    abstract protected function getModuleName(): string;

    protected function getTableName(): string
    {
        return $this->getModuleName();
    }

    protected function renderPage(array $params): void
    {
        $params['flash_dashboard'] = $this->getFlash();
        $params['csrf_token'] = $this->csrfMiddleware->generateToken('admin');
        $this->view->renderDashboardView($params);
    }
}
