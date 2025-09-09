<?php
declare(strict_types=1);
namespace App\Controller;

use App\Traits\GetDataMethods;
use App\Controller\AbstractController;
use App\Middleware\CsrfMiddleware;
use App\Request;
use App\Service\DashboardService;
use EasyCSRF\EasyCSRF;

class DashboardController extends AbstractController {

	private CsrfMiddleware $csrfMiddleware;

	use GetDataMethods;

	public function __construct(Request $request, public DashboardService $dashboardService, EasyCSRF $easyCSRF) 
	{
		parent::__construct($request, $easyCSRF);

		$this->csrfMiddleware = new \App\Middleware\CsrfMiddleware($easyCSRF, $this->request);

		if (empty($this->request->getSession('user'))) header('location: /?auth=start');
	}
	
	public function feesDashboardAction(): void {
		$this->handlePost('fees', fn()=>$this->edit("fees", "oplaty"));
	}

	public function contactDashboardAction(): void {
		$this->handlePost('contact', fn() => $this->edit("contact", "kontakt"));
	}

	public function campDashboardAction(): void {
		$this->handlePost('camp', fn() => $this->edit("camp", "obozy"));
	}

	public function startDashboardAction(): void {
		$result = $this->operationRedirect("main_page_posts");
		$this->renderPage(['page' => 'start', 'operation' => $result["operation"], 'data' => $result["data"] , 'csrf_token' => $result["csrf_token"]]);
	}

	public function newsDashboardAction():void {
		$result = $this->operationRedirect("news");
		$this->renderPage(['page' => 'news', 'operation' => $result["operation"], 'data' => $result["data"] , 'csrf_token' => $result["csrf_token"]]);
	}

	
	public function timetableDashboardAction():void {
		$result = $this->operationRedirect("timetable");
		$this->renderPage(['page' => 'timetable', 'operation' => $result["operation"] ,'data' => $result["data"] , 'csrf_token' => $result["csrf_token"]]);
	}

	public function important_postsDashboardAction(): void {
		$result = $this->operationRedirect("important_posts");
		$this->renderPage(['page' => 'important_posts', 'operation' => $result["operation"], 'data' => $result["data"] , 'csrf_token' => $result["csrf_token"]]);
	}

	public function galleryDashboardAction():void {	
		$result = $this->operationRedirect("gallery");
		$this->renderPage(['page' => 'gallery', 'operation' => $result["operation"], 'data' => $result["data"] , 'csrf_token' => $result["csrf_token"]]);
	}

	private function create(string $table, string $redirectTo = ""): void {
		$data = match ($table) {
			"timetable" => $this->getDataToAddTimetable(),
			"gallery" => $this->getDataToAddImage(),
			default => $this->getPostDataToCreate(),
		};

		if(!$this->request->getErrors()) {
			if($table === "gallery")
				$this->dashboardService->addImage($data);
			else 
				$this->dashboardService->create($table, $data);

			$this->setFlash("success","Udało się utworzyć nowy wpis");
			$this->redirect("/?dashboard=start&subpage=$redirectTo");
		}

		$this->setFlash("errors", $this->request->getErrors());	
	}

	private function published(string $table, string $redirectTo = ""): void {
		$this->dashboardService->published($table, [
			'published' => $this->request->postParam('postPublished'),
			'id' => $this->request->postParam('postId')
		]);

		$this->setFlash('info','Udało się zmienić status');
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function delete(string $table, string $redirectTo = ""): void {
		$id = (int) $this->request->postParam('postId');
		$this->dashboardService->delete($id, $table);
		$this->setFlash('success','Udało się usunąć');
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function edit(string $table, string $redirectTo= ""): void {
		$data = match($table) {
			"camp" => $this->getDataToCampEdit(),
			"fees" => $this->getDataToFeesEdit(),
			"contact" => $this->getDataToContactEdit(),
			"timetable" => $this->getDataToEditTimetable(),
			"gallery" => $this->getDataToEditImage(),
			default => $this->getPostDataToEdit(),
		};

		if(!$this->request->getErrors()){
			$this->dashboardService->edit($table, $data);
			$this->setFlash("success","Udało się edytować");
			$this->redirect("/?dashboard=start&subpage=$redirectTo");
			
		}
		$this->setFlash("errors", $this->request->getErrors());	
	}

	private function move(string $table, string $redirectTo= ""): void {
		$data = $this->getDataToChangePostPosition();
		$this->dashboardService->move($table, $data);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function handlePost(string $table, callable $function, string $redirectTo = ""): void
	{
		$this->csrfMiddleware->verify();

		if ($this->request->isPost()) $function();

		$this->renderPage(
			[
				'page' => $table,
				'data' => $this->dashboardService->getDashboardData($table)[0],
				'csrf_token' => $this->csrfMiddleware->generateToken(),
			]
		);
	}

	private function operationRedirect(string $table): array
	{
		$operation = $this->request->getParam('operation');
		$subpage = $this->request->getParam('subpage');
		$data = null;

		if(in_array($operation, ['edit', 'show', 'delete'])) $data = $this->getSingleData($table);
		else if(empty($operation)) {
			$data = $table === "timetable" 
							? $this->dashboardService->timetablePageData()
							: $this->dashboardService->getDashboardData($table);
		}

		$this->csrfMiddleware->verify();

		if ($this->request->isPost()) {
			match ($operation) {
				"create" => $this->create($table, $subpage),
				"edit" => $this->edit($table, $subpage),
				"show" => $this->published($table, $subpage),
				"delete" => $this->delete($table, $subpage),
				"move" => $this->move(table: $table, redirectTo: $subpage),
				default => null
			};
		}

		return [
			"data" => $data, 
			"operation" => $operation,
			"csrf_token" => $this->csrfMiddleware->generateToken(),
		];
	}

	private function getSingleData(string $table): array
	{
		$postId = $this->request->getParam('id');

		if($postId === null || !ctype_digit((string) $postId) ) $this->redirect("/?dashboard=start");

		$postId = (int) $postId;

		return $this->dashboardService->getPost($postId, $table);
	}

	private function renderPage(array $params): void {
		$params['flash'] = $this->getFlash();

		$this->view->renderDashboardView($params);
	}
}

