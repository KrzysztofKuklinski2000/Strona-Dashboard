<?php
declare(strict_types=1);
namespace App\Controller;

use App\Controller\AbstractController;

class DashboardController extends AbstractController {
	
	public function handlePost(string $table, callable $editFunction) {
		if ($this->request->isPost()) {
			$editFunction();
		}

		$this->view->renderDashboardView(
			['page' => $table, 
			'data' => $this->dashboardModel->getData($table)[0]
		]);
	}

	public function oplatyDashboardAction(): void {
		if($this->request->isPost()) {
			$this->editFees();
		}

		$this->view->renderDashboardView(['page' => 'fees', 'data'=> $this->dashboardModel->getData("fees")[0]]);
	}

	public function kontaktDashboardAction(): void {
		if($this->request->isPost()) {
			$this->editContact();
		}
		$this->view->renderDashboardView(['page' => 'contact', 'data' => $this->dashboardModel->getData("contact")[0]]);
	}

	public function logoutDashboardAction(): void {
		$this->view->renderDashboardView(['page' => 'logout']);
	}

	public function obozyDashboardAction(): void {
		if( $this->request->isPost() ) {
			$this->editCamp();
		}

		$this->view->renderDashboardView(['page' => 'camp-info', 'data' => $this->dashboardModel->getData("camp")[0]]);
	}

	public function operationRedirect(string $table): array {
		$operation = $this->request->getParam('operation');
		$subpage = $this->request->getParam('subpage');
		$data = $this->dashboardModel->getData($table);
		$operationSubpage = '';

		switch ($operation) {
			case 'create':
				if ($this->request->hasPost()) {
					($subpage === "grafik" ? $this->addDayToTimetable() : $this->create($table, $subpage));
				}
				$data = '';
				$operationSubpage = $operation;
				break;
			case 'edit':
				if ($this->request->isPost()) {
					($subpage === "grafik" ? $this->editTimetable() : $this->edit($table, $subpage));
				}
				$data = $this->getSingleData($table);
				$operationSubpage = $operation;
				break;
			case 'delete':
				if ($this->request->isPost()) {
					$this->delete($table, $subpage);
				}
				$operationSubpage = $operation;
				$data = $this->getSingleData($table);
				break;
			case 'show':
				if ($this->request->isPost()) {
					$this->published($table, $subpage);
				}
				$operationSubpage = $operation;
				$data = $this->getSingleData($table);
				break;
		}

		return ["data" => $data, "operation" => $operation];
	}

	public function startDashboardAction(): void {
		$result = $this->operationRedirect("main_page_posts");
		$this->view->renderDashboardView(['page' => 'start', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	public function aktualnosciDashboardAction():void {
		$result = $this->operationRedirect("news");
		$this->view->renderDashboardView(['page' => 'news', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	
	public function grafikDashboardAction():void {
		$result = $this->operationRedirect("timetable");
		$this->view->renderDashboardView(['page' => 'timetable', 'operation' => $result["operation"] ,'data' => $result["data"]]);
	}

	public function important_postsDashboardAction(): void {
		$result = $this->operationRedirect("important_posts");
		$this->view->renderDashboardView(['page' => 'important_posts', 'operation' => $result["operation"], 'data' => $result["data"]]);
	}

	private function getSingleData(string $table): array {
		$postId = (int) $this->request->getParam('id');
		if(!$postId) {
			$this->redirect('/');
		}
		return $this->dashboardModel->getPost($postId, $table);
	}

	public function edit(string $table, string $redirectTo = ""): void {
		$data = [
			'id' => $this->request->postParam('postId'),
			'title' => $this->request->postParam('postTitle'),
			'description' => $this->request->postParam('postDescription'),
			'date' => date('Y-m-d')
		];
					
		$this->dashboardModel->edit($data, $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	public function create(string $table, string $redirectTo = ""): void {
		$data = [
			'title' => $this->request->postParam('postTitle'),
			'description' => $this->request->postParam('postDescription'),
			'date' => date('Y-m-d')
		];

		$this->dashboardModel->create($data, $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	public function published(string $table, string $redirectTo = ""): void {
		$data = [
			'published' => $this->request->postParam('postPublished'),
			'id' => $this->request->postParam('postId')
		];
		$this->dashboardModel->published($data, $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	public function delete(string $table, string $redirectTo = "") {
		$id = (int) $this->request->postParam('postId');
		$this->dashboardModel->delete($id, $table);
		$this->redirect("/?dashboard=start&subpage=$redirectTo");
	}

	public function editCamp(): void {
		$data = [
			'city' => $this->request->postParam('town'),
			'guesthouse' => $this->request->postParam('guesthouse'),
			'townStart' => $this->request->postParam('townStart'),
			'dateStart' => $this->request->postParam('dateStart'),
			'dateEnd' => $this->request->postParam('dateEnd'),
			'timeStart' => $this->request->postParam('timeStart'),
			'timeEnd' => $this->request->postParam('timeEnd'),
			'place' => $this->request->postParam('place'),
			'accommodation' => $this->request->postParam('accommodation'),
			'meals' => $this->request->postParam('meals'),
			'trips' => $this->request->postParam('trips'),
			'staff' => $this->request->postParam('staff'),
			'transport' => $this->request->postParam('transport'),
			'training' => $this->request->postParam('training'),
			'insurance' => $this->request->postParam('insurance'),
			'cost' => $this->request->postParam('cost'),
			'advancePayment' => $this->request->postParam('advancePayment'),
			'advanceDate' => $this->request->postParam('advanceDate')
		];

		$this->dashboardModel->editCamp($data);
		$this->redirect("/?dashboard=start&subpage=obozy");
	}

	public function editFees(): void {
		$data = [
			'fees1' => $this->request->postParam('n1'),
			'fees2' => $this->request->postParam('n2'),
			'fees3' => $this->request->postParam('n3'),
			'fees4' => $this->request->postParam('n4'),
			'fees5' => $this->request->postParam('n5'),
			'fees6' => $this->request->postParam('n6'),
			'fees7' => $this->request->postParam('n7'),
			'fees8' => $this->request->postParam('n8'),
			'fees9' => $this->request->postParam('n9'),
		];

		$this->dashboardModel->editFees($data);
		$this->redirect("/?dashboard=start&subpage=oplaty");
 	}

 	public function editContact(): void {
 		$data = [
 			'email' => $this->request->postParam('email'),
 			'phone' => $this->request->postParam('phone'),
 			'address' => $this->request->postParam('address')
 		];

 		$this->dashboardModel->editContact($data);
		$this->redirect("/?dashboard=start&subpage=kontakt");
 	}

	public function addDayToTimetable(): void {
		$data = [
			'day' => $this->request->postParam('day'),
			'city' => $this->request->postParam('city'),
			'group' => $this->request->postParam('group'),
			'place' => $this->request->postParam('place'),
			'startTime' => $this->request->postParam('startTime'),
			'endTime' => $this->request->postParam('endTime')
		];

		$this->dashboardModel->addDayToTimetable($data);
		$this->redirect("/?dashboard=start&subpage=grafik");
	}

	public function editTimetable(): void {
		$data = [
			"id" => $this->request->postParam('id'),
			'day' => $this->request->postParam('day'),
			'city' => $this->request->postParam('city'),
			'group' => $this->request->postParam('group'),
			'place' => $this->request->postParam('place'),
			'startTime' => $this->request->postParam('startTime'),
			'endTime' => $this->request->postParam('endTime')
		];

		$this->dashboardModel->editTimetable($data);
		$this->redirect("/?dashboard=start&subpage=grafik");
	}
}