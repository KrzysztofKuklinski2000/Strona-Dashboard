<?php
declare(strict_types=1);

namespace App\Controller;

use App\View;
use App\Request;
use App\Model\ContentModel;
use App\Model\DashboardModel;
use App\Exception\NotFoundException; 
use App\Exception\StorageException;
use App\Controller\DashboardController;
use Exception;


class AbstractController {
	public View $view;
	public Request $request;
	public ContentModel $contentModel;
	public DashboardModel $dashboardModel;
	private static array $configuration = [];
	private const DEFAULT_ACTION = 'start';
	private const DEFAULT_ACTION_FOR_DASHBOARD = 'start';

	public static function initConfiguration(array $configuration):void {
		self::$configuration = $configuration;
	}

	public function __construct($request) {
		if(empty(self::$configuration['db'])) {
			throw new Exception('Configuration Error');
		}

		$this->contentModel = new ContentModel(self::$configuration['db']);
		$this->dashboardModel = new DashboardModel(self::$configuration['db']);
		$this->view = new View();
		$this->request = $request;

	}

	public function run(): void {
		try{
			$dashboard = $this->request->getParam('dashboard');
			if($dashboard === 'start') {
				$action = $this->dashboardAction().'DashboardAction';
				if(!method_exists($this, $action)){
					$action = self::DEFAULT_ACTION_FOR_DASHBOARD.'DashboardAction';
				}
				$this->$action();
			}else {
				$takeAction = $this->takeAction().'Action';
				if(!method_exists($this, $takeAction)){
					$takeAction = self::DEFAULT_ACTION.'Action';
				}
				$this->$takeAction();
			}
		}catch(StorageException $e){
				echo 'Błąd: ' .$e->getMessage();
		}catch(NotFoundException $e) {
			$this->redirect('/');
		}
	}

	public function redirect(string $to) {
		$location = $to == '/' ? '?dashboard=start' : $to;
		header("Location: $location");
		exit();
	}

	private function takeAction(): string {
		return $this->request->getParam('view', self::DEFAULT_ACTION);
	}

	private function dashboardAction() {
		return $this->request->getParam('subpage', self::DEFAULT_ACTION_FOR_DASHBOARD);
	}
}