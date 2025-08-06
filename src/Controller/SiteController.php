<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\ContentModel;
use App\Request;

class SiteController extends AbstractController {

	public ContentModel $contentModel;

	public function __construct(Request $request, ContentModel $contentModel) {
		parent::__construct($request);
		$this->contentModel = $contentModel;
	}

	public function newsAction(): void {
		$page = (int) $this->request->getParam('page');
		$this->view->renderPageView([
			'page' => 'news', 
			'content' => $this->contentModel->getData("news", "DESC", $page-1), 
			'numberOfRows' => $this->contentModel->countData('news'),
			'currentNumberOfPage' => $page,
		]);
	}

	public function dojoOathAction():  void {
		$this->view->renderPageView(['page' => 'dojo-oath']);
	}

	public function requirementsAction(): void {
		$this->view->renderPageView(['page' => 'requirements']);
	}

	public function timetableAction(): void {
		$this->view->renderPageView(['page' => 'timetable', 'content' => $this->contentModel->timetablePageData()]);
	}

	public function statuteAction(): void {
		$this->view->renderPageView(['page' => 'statute']);
	}

	public function oyamaAction(): void {
		$this->view->renderPageView(['page' => 'oyama']);
	}

	public function galleryAction(): void {
		$this->view->renderPageView(['page' => 'gallery']);
	}

	public function campAction(): void {
		$this->view->renderPageView(['page' => 'camp-info', 'content' => $this->contentModel->getData("camp", "DESC")[0]]);
	}

	public function feesAction(): void {
		$this->view->renderPageView(['page' => 'fees-info', 'content' => $this->contentModel->getData("fees", "DESC")[0]]);
	}

	public function registrationAction(): void {
		$this->view->renderPageView(['page' => 'entries-info', 'content' => $this->contentModel->getData("fees", "DESC")[0]]);
	}

	public function contactAction():void {
		$this->view->renderPageView(['page' => 'contact', 'content' => $this->contentModel->getData("contact", "DESC")[0]]);
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

		$this->view->renderPageView(['page' => 'start', 'content' => [$posts, $importantPosts, $firstPost]]);
	}
}