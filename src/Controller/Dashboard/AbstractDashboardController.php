<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use App\Traits\GetDataMethods;
use App\Middleware\CsrfMiddleware;
use App\Exception\NotFoundException;
use App\Controller\AbstractController;
use App\Service\Dashboard\SharedGetDataServiceInterface;

abstract class AbstractDashboardController extends AbstractController
{

    use GetDataMethods;

    public function __construct(
        Request                                 $request,
        protected SharedGetDataServiceInterface $dataService,
        View                                    $view,
        protected CsrfMiddleware                $csrfMiddleware
    )
    {
        parent::__construct($request, $view);
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

    /**
     * @throws NotFoundException
     */
    protected function getSingleData(): array
    {
        $postId = $this->request->getRouteParam('id');
        if ($postId === null || !ctype_digit((string)$postId)) {
            throw new NotFoundException("Required 'id' parameter is missing or invalid");
        }

        $postId = (int)$postId;
        return $this->dataService->getPost($this->getTableName(), $postId);
    }
}
