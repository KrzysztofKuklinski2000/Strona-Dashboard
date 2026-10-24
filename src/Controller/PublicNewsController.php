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
     * @throws NotFoundException
     */
    public function indexAction(): void
    {
        $routePage = $this->request->getRouteParam('page');
        $page = $routePage === null ? 1 : (int) $routePage;
        $result = $this->publicNewsService->getNews($page);

        if ($routePage !== null && ($page === 1 || (string) $routePage !== (string) $page)) {
            $this->redirect($page === 1 ? '/aktualnosci' : '/aktualnosci/' . $page, 301);
        }

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
