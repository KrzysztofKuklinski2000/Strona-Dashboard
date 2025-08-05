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
use Exception;


class AbstractController {
	public View $view;
	public Request $request;
	public ContentModel $contentModel;
	public DashboardModel $dashboardModel;
	public UserModel $userModel;
	private ActionResolver $actionResolver;

	private static array $configuration = [];

	private const DEFAULT_ACTION = 'start';

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

		$this->actionResolver = new ActionResolver();

	}

	public function run(): void {
		try{
			$action = $this->actionResolver->resolve($this->request);
			
			if(!method_exists($this, $action)){
				if(str_ends_with($action, 'DashboardAction')) {
					$action = self::DEFAULT_ACTION . "DashboardAction";
				}else {
					$action = self::DEFAULT_ACTION . "Action";
				}
			}
			$this->$action();
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
}