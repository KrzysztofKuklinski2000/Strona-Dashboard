<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\ContentModel;
use App\Request;
use EasyCSRF\EasyCSRF;

class SiteController extends AbstractController {

	public ContentModel $contentModel;

	public function __construct(Request $request, ContentModel $contentModel, EasyCSRF $easyCSRF) {
		parent::__construct($request, $easyCSRF);
		$this->contentModel = $contentModel;
	}

	public function newsAction(): void {
		$page = (int) $this->request->getParam('page');
		$this->renderPage([
			'page' => 'news', 
			'content' => $this->contentModel->getData("news", "DESC", $page), 
			'numberOfRows' => $this->contentModel->countData('news'),
			'currentNumberOfPage' => $page,
		]);
	}

	public function dojoOathAction():  void {
		$this->renderPage(['page' => 'dojo-oath']);
	}

	public function requirementsAction(): void {
		$this->renderPage(['page' => 'requirements']);
	}

	public function timetableAction(): void {
		$this->renderPage([
			'page' => 'timetable', 
			'content' => $this->contentModel->timetablePageData()
		]);
	}

	public function statuteAction(): void {
		$this->renderPage(['page' => 'statute']);
	}

	public function oyamaAction(): void {
		$this->renderPage(['page' => 'oyama']);
	}

	public function galleryAction(): void {
		$this->renderPage(['page' => 'gallery']);
	}

	public function campAction(): void {
		$this->renderPage([
			'page' => 'camp-info', 
			'content' => $this->contentModel->getData("camp", "DESC")[0]
		]);
	}

	public function feesAction(): void {
		$this->renderPage([
			'page' => 'fees-info', 
			'content' => $this->contentModel->getData("fees", "DESC")[0]
		]);
	}

	public function registrationAction(): void {
		$this->renderPage([
			'page' => 'entries-info', 
			'content' => $this->contentModel->getData("fees", "DESC")[0]
		]);
	}

	public function contactAction():void {
		$this->renderPage([
			'page' => 'contact', 
			'content' => $this->contentModel->getData("contact", "DESC")[0]
		]);
	}	

	public function startAction(): void {
		$firstPost = [];
		$posts = $this->contentModel->getData("main_page_posts", "DESC");
		$importantPosts = $this->contentModel->getData("important_posts", "DESC");

		foreach($posts as $key =>  $post) {
			if($post['id'] === 1) {
				$firstPost = $post;
				unset($posts[$key]);
				break;
			} 
		}

		$this->renderPage([
			'page'=> 'start',
			'content' => [$posts, $importantPosts, $firstPost],
		]);
	}

	private function renderPage(array $params): void {
		$params['contact'] = $this->contentModel->getData('contact', 'DESC')[0];
		$this->view->renderPageView($params);
	}
}