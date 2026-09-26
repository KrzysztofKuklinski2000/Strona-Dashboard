<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\Exception\ServiceException;
use App\Service\PublicNewsService;
use App\View\PublicPageRenderer;

class PublicNewsController extends AbstractController
{
    public function __construct(
        private readonly PublicNewsService  $publicNewsService,
        private readonly PublicPageRenderer $renderer,
        ContextController                   $contextController,
    )
    {
        parent::__construct($contextController);
    }

    /**
     * @throws ServiceException
     */
    public function indexAction(): void
    {
        $page = (int)$this->request->getRouteParam('page');
        $result = $this->publicNewsService->getNews($page);

        $this->renderer->render([
            'page' => 'news',
            'content' => $result['data'],
            'numberOfRows' => $result['totalPages'],
            'currentNumberOfPage' => $result['currentPage'],
        ]);
    }
}