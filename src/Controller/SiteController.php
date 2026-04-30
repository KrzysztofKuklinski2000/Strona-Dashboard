<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\Exception\ServiceException;
use App\Service\SiteService;

class SiteController extends AbstractController
{
    public function __construct(
        public SiteService $siteService,
        ContextController  $contextController,
    )
    {
        parent::__construct($contextController);
    }

    /**
     * @throws ServiceException
     */
    public function indexAction(): void
    {

        $this->renderPage([
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


        $this->renderPage([
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
        $this->renderPage([
            'page' => 'timetable',
            'content' => $this->siteService->getTimetable()
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function galleryAction(): void
    {
        $this->renderPage([
            'page' => 'gallery',
            'content' => $this->siteService->getGallery($this->request->getRouteParam('category')),
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function campAction(): void
    {
        $this->renderPage([
            'page' => 'camp-info',
            'content' => $this->siteService->getCamp()
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function feesAction(): void
    {
        $this->renderPage([
            'page' => 'fees-info',
            'content' => $this->siteService->getFees()
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function registrationAction(): void
    {
        $this->renderPage([
            'page' => 'entries-info',
            'content' => $this->siteService->getFees()
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function contactAction(): void
    {
        $this->renderPage([
            'page' => 'contact',
        ]);
    }


    /**
     * @throws ServiceException
     */
    public function statuteAction(): void
    {
        $this->renderPage(['page' => 'statute']);
    }

    /**
     * @throws ServiceException
     */
    public function oyamaAction(): void
    {
        $this->renderPage(['page' => 'oyama']);
    }


    /**
     * @throws ServiceException
     */
    public function dojoOathAction(): void
    {
        $this->renderPage(['page' => 'dojo-oath']);
    }

    /**
     * @throws ServiceException
     */
    public function requirementsAction(): void
    {
        $this->renderPage(['page' => 'requirements']);
    }

    /**
     * @throws ServiceException
     */
    private function renderPage(array $params): void
    {
        $params['contact'] = $this->siteService->getContact();
        $params['csrf_token'] = $this->csrfMiddleware->generateToken('public');
        $params['flash_public'] = $this->getFlash('public');

        $this->view->renderPageView($params);
    }
}