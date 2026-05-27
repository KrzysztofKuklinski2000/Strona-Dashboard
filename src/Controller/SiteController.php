<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\Exception\ServiceException;
use App\Service\SiteService;
use App\View\PublicPageRenderer;

class SiteController extends AbstractController
{
    public function __construct(
        public SiteService                  $siteService,
        ContextController                   $contextController,
        private readonly PublicPageRenderer $renderer
    )
    {
        parent::__construct($contextController);
    }

    /**
     * @throws ServiceException
     */
    public function indexAction(): void
    {
        $this->renderer->render([
            'page' => 'start',
            'content' => $this->siteService->getFrontPage(),
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function newsAction(): void
    {
        $page = (int)$this->request->getRouteParam('page');
        $result = $this->siteService->getNews($page);

        $this->renderer->render([
            'page' => 'news',
            'content' => $result['data'],
            'numberOfRows' => $result['totalPages'],
            'currentNumberOfPage' => $result['currentPage'],
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function timetableAction(): void
    {
        $this->renderer->render([
            'page' => 'timetable',
            'content' => $this->siteService->getTimetable()
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function galleryAction(): void
    {
        $this->renderer->render([
            'page' => 'gallery',
            'content' => $this->siteService->getGallery($this->request->getRouteParam('category')),
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function campAction(): void
    {
        $this->renderer->render([
            'page' => 'camp-info',
            'content' => $this->siteService->getCamp()
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function feesAction(): void
    {
        $this->renderer->render([
            'page' => 'fees-info',
            'content' => $this->siteService->getFees()
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function registrationAction(): void
    {
        $this->renderer->render([
            'page' => 'entries-info',
            'content' => $this->siteService->getFees()
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function contactAction(): void
    {
        $this->renderer->render([
            'page' => 'contact',
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function statuteAction(): void
    {
        $this->renderer->render(['page' => 'statute']);
    }

    /**
     * @throws ServiceException
     */
    public function oyamaAction(): void
    {
        $this->renderer->render(['page' => 'oyama']);
    }

    /**
     * @throws ServiceException
     */
    public function dojoOathAction(): void
    {
        $this->renderer->render(['page' => 'dojo-oath']);
    }

    /**
     * @throws ServiceException
     */
    public function requirementsAction(): void
    {
        $this->renderer->render(['page' => 'requirements']);
    }
}