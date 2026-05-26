<?php

namespace App\Controller\Dashboard;

use App\Controller\AbstractController;
use App\Core\ContextController;
use App\Traits\GetDataMethods;

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
