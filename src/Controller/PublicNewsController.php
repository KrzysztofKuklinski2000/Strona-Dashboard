<?php
declare(strict_types=1);

namespace App\Controller;

use App\Content\NewsPostTypes;
use App\Core\ContextController;
use App\Exception\NotFoundException;
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

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function showAction(): void {
        $id = (int)$this->request->getRouteParam('id');

        $post = $this->publicNewsService->getSingleNews($id);
        $partial = NewsPostTypes::detailsPartial($post->type);

        if($partial === null) {
            throw new NotFoundException(
                'Nieobsługiwany typ wpisu',
                404
            );
        }

        $this->renderer->render([
            'page' => 'news_details',
            'content' => $post,
            'detailsPartial' => $partial,
        ]);
    }
}