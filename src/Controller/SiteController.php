<?php
declare(strict_types=1);

namespace App\Controller;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use App\Service\SiteService;

class SiteController extends AbstractController {
	public function __construct(
		Request $request, 
		public SiteService $siteService, 
		EasyCSRF $easyCSRF,
		View $view, 
		ActionResolver $actionResolver
		) {
		parent::__construct($request, $easyCSRF, $view, $actionResolver);
	}

	public function indexAction(): void {
		$this->renderPage([
			'page'=> 'start',
			'content' => $this->siteService->getFrontPage(),
		]);
	}

	public function newsAction(): void {
		$page = (int) $this->request->getQueryParam('page');
		$result = $this->siteService->getNews($page);
		

		$this->renderPage([
			'page' => 'news', 
			'content' =>$result['data'], 
			'numberOfRows' => $result['totalPages'],
			'currentNumberOfPage' => $result['currentPage'],
		]);
	}


	public function timetableAction(): void {
		$this->renderPage([
			'page' => 'timetable', 
			'content' => $this->siteService->getTimetable()
		]);
	}

	public function galleryAction(): void {
		$this->renderPage([
			'page' => 'gallery',
			'content' => $this->siteService->getGallery($this->request->getQueryParam('category')),
		]);
	}

	public function campAction(): void {
		$this->renderPage([
			'page' => 'camp-info', 
			'content' => $this->siteService->getCamp()
		]);
	}

	public function feesAction(): void {
		$this->renderPage([
			'page' => 'fees-info', 
			'content' => $this->siteService->getFees()
		]);
	}

	public function registrationAction(): void {
		$this->renderPage([
			'page' => 'entries-info', 
			'content' => $this->siteService->getFees()
		]);
	}

	public function contactAction():void {
		$this->renderPage([
			'page' => 'contact', 
			'content' => $this->siteService->getContact()
		]);
	}	


	public function statuteAction(): void {
		$this->renderPage(['page' => 'statute']);
	}

	public function oyamaAction(): void {
		$this->renderPage(['page' => 'oyama']);
	}


	public function dojoOathAction():  void {
		$this->renderPage(['page' => 'dojo-oath']);
	}

	public function requirementsAction(): void {
		$this->renderPage(['page' => 'requirements']);
	}

	private function renderPage(array $params): void {
		$params['contact'] = $this->siteService->getContact();
		$this->view->renderPageView($params);
	}
}