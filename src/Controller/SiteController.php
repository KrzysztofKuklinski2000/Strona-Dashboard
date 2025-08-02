<?php
declare(strict_types=1);

namespace App\Controller;

class SiteController extends AbstractController {

	public function aktualnosciAction(): void {
		$page = (int) $this->request->getParam('page');
		$this->view->renderPageView([
			'page' => 'news', 
			'content' => $this->contentModel->getData("news", "DESC", $page-1), 
			'numberOfRows' => $this->contentModel->countData('news'),
			'currentNumberOfPage' => $page,
		]);
	}

	public function przysiega_do_joAction():  void {
		$this->view->renderPageView(['page' => 'dojo-oath']);
	}

	public function wymaganiaAction(): void {
		$this->view->renderPageView(['page' => 'requirements']);
	}

	public function grafikAction(): void {
		$this->view->renderPageView(['page' => 'timetable', 'content' => $this->contentModel->timetablePageData()]);
	}

	public function regulaminAction(): void {
		$this->view->renderPageView(['page' => 'statute']);
	}

	public function oyamaAction(): void {
		$this->view->renderPageView(['page' => 'oyama']);
	}

	public function galeriaAction(): void {
		$this->view->renderPageView(['page' => 'gallery']);
	}

	public function obozyAction(): void {
		$this->view->renderPageView(['page' => 'camp-info', 'content' => $this->contentModel->getData("camp", "DESC")[0]]);
	}

	public function oplatyAction(): void {
		$this->view->renderPageView(['page' => 'fees-info', 'content' => $this->contentModel->getData("fees", "DESC")[0]]);
	}

	public function zapisyAction(): void {
		$this->view->renderPageView(['page' => 'entries-info', 'content' => $this->contentModel->getData("fees", "DESC")[0]]);
	}

	public function kontaktAction():void {
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