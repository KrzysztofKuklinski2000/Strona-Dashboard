<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Service\SiteService;
use App\View\PublicPageRenderer;

class SiteController extends AbstractController
{
    public function __construct(
        public SiteService                  $siteService,
        ContextController                   $contextController,
        private readonly PublicPageRenderer $renderer
    ) {
        parent::__construct($contextController);
    }

    /**
     * @throws ServiceException
     */
    public function indexAction(): void
    {
        $this->renderer->render([
            'page' => 'homepage',
            'content' => $this->siteService->getHomepageData(),
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
        $categories = $this->siteService->getGalleryCategoriesWithImages();
        $requestedCategory = $this->request->getRouteParam('category');

        $activeSlugs = array_map(
            fn($category) => $category->slug,
            $categories
        );

        $category = is_string($requestedCategory) && in_array($requestedCategory, $activeSlugs, true)
            ? $requestedCategory
            : null;

        $this->renderer->render([
            'page' => 'gallery',
            'content' => $this->siteService->getGallery($category),
            'categories' => $categories,
            'category' => $category,
        ]);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
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
     * @throws NotFoundException
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
     * @throws NotFoundException
     */
    public function registrationAction(): void
    {
        $this->renderer->render([
            'page' => 'entries-info',
            'content' => $this->siteService->getFees()
        ]);
    }

    public function contactAction(): void
    {
        $this->renderer->render([
            'page' => 'contact',
        ]);
    }

    public function statuteAction(): void
    {
        $this->renderer->render(['page' => 'statute']);
    }

    public function oyamaAction(): void
    {
        $this->renderer->render(['page' => 'oyama']);
    }

    public function dojoOathAction(): void
    {
        $this->renderer->render(['page' => 'dojo-oath']);
    }

    public function requirementsAction(): void
    {
        $this->renderer->render(['page' => 'requirements']);
    }
}
