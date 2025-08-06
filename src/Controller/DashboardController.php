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
	}
	
	public function feesDashboardAction(): void {
		if(empty($this->request->getSession('user'))) header('location: /?auth=start');
		$this->handlePost('fees', fn()=>$this->editFees());
	}

	public function contactDashboardAction(): void {
		if (empty($this->request->getSession('user'))) header('location: /?auth=start&subpage=login');
		$this->handlePost('contact', fn() => $this->editContact());
	}

	public function campDashboardAction(): void {
		if (empty($this->request->getSession('user'))) header('location: /?auth=start');
		$this->handlePost('camp', fn() => $this->editCamp());
	}

	public function startDashboardAction(): void {
		if (empty($this->request->getSession('user'))) header('location: /?auth=start');
		$result = $this->operationRedirect("main_page_posts");
		$this->view->renderDashboardView(['page' => 'start', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	public function newsDashboardAction():void {
		if (empty($this->request->getSession('user'))) header('location: /?auth=start');
		$result = $this->operationRedirect("news");
		$this->view->renderDashboardView(['page' => 'news', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	
	public function timetableDashboardAction():void {
		if (empty($this->request->getSession('user'))) header('location: /?auth=start');
		$result = $this->operationRedirect("timetable");
		$this->view->renderDashboardView(['page' => 'timetable', 'operation' => $result["operation"] ,'data' => $result["data"]]);
	}

	public function important_postsDashboardAction(): void {
		if(empty($this->request->getSession('user'))) header('location: /?auth=start');

		$result = $this->operationRedirect("important_posts");
		$this->view->renderDashboardView(['page' => 'important_posts', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	private function edit(string $table, string $redirectTo = ""): void {
		$this->dashboardModel->edit($this->getPostDataToEdit(), $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function create(string $table, string $redirectTo = ""): void {
		$this->dashboardModel->create($this->getPostDataToCreate(), $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function published(string $table, string $redirectTo = ""): void {
		$this->dashboardModel->published([
			'published' => $this->request->postParam('postPublished'),
			'id' => $this->request->postParam('postId')
		], $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function delete(string $table, string $redirectTo = "") {
		$id = (int) $this->request->postParam('postId');
		$this->dashboardModel->delete($id, $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	private function editCamp(): void { 
		$this->dashboardModel->editCamp($this->getDataToCampEdit());
		$this->redirect("/?dashboard=start&subpage=obozy");
	}

	private function editFees(): void {
		$this->dashboardModel->editFees($this->getDataToFeesEdit());
		$this->redirect("/?dashboard=start&subpage=oplaty");
 	}

 	private function editContact(): void {
 		$this->dashboardModel->editContact($this->getDataToContactEdit());
		$this->redirect("/?dashboard=start&subpage=kontakt");
 	}

	private function addDayToTimetable(): void {
		$this->dashboardModel->addDayToTimetable($this->getDataToAddTimetable());
		$this->redirect("/?dashboard=start&subpage=grafik");
	}

	private function editTimetable(): void {
		$this->dashboardModel->editTimetable($this->getDataToEditTimetable());
		$this->redirect("/?dashboard=start&subpage=grafik");
	}

	private function handlePost(string $table, callable $function)
	{
		if ($this->request->isPost()) {
			$function();
		}
		$this->view->renderDashboardView(
			[
				'page' => $table,
				'data' => $this->dashboardModel->getDashboardData($table)[0] ?? []
			]
		);
	}

	private function handleCreate(string $table, string $subpage): string
	{
		if ($this->request->hasPost()) {
			($subpage === "grafik" ? $this->addDayToTimetable() : $this->create($table, $subpage));
		}

		return "create";
	}

	private function handleEditOrDeleteOrShow(
		string $operation,
		string $subpage,
		callable $function,
		?callable $functionTimeTable = null
	): string {

		if ($this->request->isPost()) {
			($subpage === "grafik" && $functionTimeTable ? $functionTimeTable() : $function());
		}

		return $operation; 
	}

	private function getSingleData(string $table): array
	{
		$postId = (int) $this->request->getParam('id');
		return $postId ? $this->dashboardModel->getPost($postId, $table) : [];
	}

	private function operationRedirect(string $table): array
	{
		$operation = $this->request->getParam('operation');
		$subpage = $this->request->getParam('subpage');
		$data = null;

		if(in_array($operation, ['edit', 'show', 'delete'])) $data = $this->getSingleData($table);
		else {
			$data = $table === "timetable" 
							? $data = $this->dashboardModel->timetablePageData() 
							: $this->dashboardModel->getDashboardData($table) ?? [];
		}

		$operationSubpage = match ($operation) {
			"create" => $this->handleCreate($table, $subpage),
			"edit" => $this->handleEditOrDeleteOrShow(
				"edit",
				$subpage,
				fn() => $this->edit($table, $subpage),
				fn() => $this->editTimetable()
			),
			"show" => $this->handleEditOrDeleteOrShow(
				"show",
				$subpage,
				fn() => $this->published($table, $subpage),
			),
			"delete" => $this->handleEditOrDeleteOrShow(
				"delete",
				$subpage,
				fn() => $this->delete($table, $subpage),
			),
			default => ""
		};

		return ["data" => $data, "operation" => $operationSubpage];
	}
}

