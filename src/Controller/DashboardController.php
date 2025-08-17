<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\DashboardModel;
use App\Traits\GetDataMethods;
use App\Controller\AbstractController;
use App\Request;

class DashboardController extends AbstractController {

	public DashboardModel $dashboardModel;

	use GetDataMethods;

	public function __construct(Request $request, DashboardModel $dashboardModel) 
	{
		parent::__construct($request);
		$this->dashboardModel = $dashboardModel;
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
		$this->view->renderDashboardView(['page' => 'start', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	public function newsDashboardAction():void {
		$result = $this->operationRedirect("news");
		$this->view->renderDashboardView(['page' => 'news', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	
	public function timetableDashboardAction():void {
		$result = $this->operationRedirect("timetable");
		$this->view->renderDashboardView(['page' => 'timetable', 'operation' => $result["operation"] ,'data' => $result["data"]]);
	}

	public function important_postsDashboardAction(): void {
		$result = $this->operationRedirect("important_posts");
		$this->view->renderDashboardView(['page' => 'important_posts', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	private function create(string $table, string $redirectTo = ""): void {
		$data = match ($table) {
			"timetable" => $this->getDataToAddTimetable(),
			default => $this->getPostDataToCreate(),
		};

		$this->dashboardModel->create($data, $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function published(string $table, string $redirectTo = ""): void {
		$this->dashboardModel->published([
			'published' => $this->request->postParam('postPublished'),
			'id' => $this->request->postParam('postId')
		], $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function delete(string $table, string $redirectTo = ""): void {
		$id = (int) $this->request->postParam('postId');
		$this->dashboardModel->delete($id, $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function edit(string $table, string $redirectTo= ""): void {
		$data = match($table) {
			"camp" => $this->getDataToCampEdit(),
			"fees" => $this->getDataToFeesEdit(),
			"contact" => $this->getDataToContactEdit(),
			"timetable" => $this->getDataToEditTimetable(),
			default => $this->getPostDataToEdit(),
		};

		$this->dashboardModel->edit($table, $data);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function handlePost(string $table, callable $function): void
	{
		if ($this->request->isPost()) $function();
		$this->view->renderDashboardView(
			[
				'page' => $table,
				'data' => $this->dashboardModel->getDashboardData($table)[0]
			]
		);
	}

	private function handleCreate(string $table, string $subpage): string
	{
		if ($this->request->hasPost()) $this->create($table, $subpage);
		return "create";
	}

	private function handleEditOrDeleteOrShow(string $operation, callable $function): string {
		if ($this->request->isPost()) $function();
		return $operation; 
	}

	private function operationRedirect(string $table): array
	{
		$operation = $this->request->getParam('operation');
		$subpage = $this->request->getParam('subpage');
		$data = null;

		if(in_array($operation, ['edit', 'show', 'delete'])) $data = $this->getSingleData($table);
		else if(empty($operation)) {
			$data = $table === "timetable" 
							? $data = $this->dashboardModel->timetablePageData()
							: $this->dashboardModel->getDashboardData($table);
		}

		$operationSubpage = match ($operation) {
			"create" => $this->handleCreate($table, $subpage),
			"edit" => $this->handleEditOrDeleteOrShow("edit", fn() => $this->edit($table, $subpage)),
			"show" => $this->handleEditOrDeleteOrShow("show", fn() => $this->published($table, $subpage)),
			"delete" => $this->handleEditOrDeleteOrShow("delete", fn() => $this->delete($table, $subpage)),
			default => ""
		};

		return ["data" => $data, "operation" => $operationSubpage];
	}

	private function getSingleData(string $table): array
	{
		$postId = $this->request->getParam('id');

		if($postId === null || !ctype_digit((string) $postId) ) $this->redirect("/?dashboard=start");

		$postId = (int) $postId;

		return $this->dashboardModel->getPost($postId, $table);
	}
}

