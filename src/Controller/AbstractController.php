<?php
declare(strict_types=1);

namespace App\Controller;

use App\View;
use App\Request;
use App\Model\ContentModel;
use App\Model\DashboardModel;
use App\Model\UserModel;
use App\Exception\NotFoundException; 
use App\Exception\StorageException;
use App\Controller\DashboardController;
use Exception;


class AbstractController {
	public View $view;
	public Request $request;
	public ContentModel $contentModel;
	public DashboardModel $dashboardModel;
	public UserModel $userModel;
	private static array $configuration = [];
	private const DEFAULT_ACTION = 'start';
	private const DEFAULT_ACTION_FOR_DASHBOARD = 'start';

	private const VIEW_ALIASES = [
		'galeria' => 'galllery',
		'przysiega_do_jo' => 'dojoOath',
		'wymagania' => 'requirements',
		'grafik' => 'timetable',
		'regulamin' => 'statute',
		'oyama' => 'oyama',
		'obozy' => 'camp',
		'oplaty' => 'fees',
		'zapisy' => 'registration',
		'kontakt' => 'contact',
		'aktualnosci' => 'news',
		'start' => 'start',
	];

	private const VIEW_DASHBOARD_ALIASES = [
		'oplaty' => 'fees',
		'kontakt' => 'contact',
		'obozy' => 'camp',
		'start' => 'start',
		'aktualnosci' => 'news',
		'grafik' => 'timetable',
		'important_posts' => 'important_posts',
	];


	public static function initConfiguration(array $configuration):void {
		self::$configuration = $configuration;
	}

	public function __construct($request) {
		if(empty(self::$configuration['db'])) {
			throw new Exception('Configuration Error');
		}

		$this->contentModel = new ContentModel(self::$configuration['db']);
		$this->dashboardModel = new DashboardModel(self::$configuration['db']);
		$this->userModel = new UserModel(self::$configuration['db']);
		$this->view = new View();
		$this->request = $request;

	}

	public function run(): void {
		try{
			$dashboard = $this->request->getParam('dashboard');
			$auth = $this->request->getParam('auth');

			if($dashboard === 'start') {
				$action = $this->dashboardAction().'DashboardAction';
				if(!method_exists($this, $action)){
					$action = self::DEFAULT_ACTION_FOR_DASHBOARD.'DashboardAction';
				}
				$this->$action();
			}else if($auth) {
				$action = $this->authAction() . 'Action';
				if (!method_exists($this, $action)) {
					$action = self::DEFAULT_ACTION_FOR_DASHBOARD . 'Action';
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
		$viewParam = $this->request->getParam('view', self::DEFAULT_ACTION);
		return self::VIEW_ALIASES[$viewParam] ?? self::DEFAULT_ACTION;
	}

	private function authAction() {
		return $this->request->getParam('auth', self::DEFAULT_ACTION);
	}

	private function dashboardAction() {
		$viewParam = $this->request->getParam('subpage', self::DEFAULT_ACTION_FOR_DASHBOARD);
		return self::VIEW_DASHBOARD_ALIASES[$viewParam] ?? self::DEFAULT_ACTION_FOR_DASHBOARD;
	}
}