<?php
declare(strict_types=1);

namespace App\Controller;

use App\View;
use App\Request;
use App\Exception\NotFoundException; 
use App\Exception\StorageException;


class AbstractController {
	public View $view;
	public Request $request;
	private ActionResolver $actionResolver;

	private const DEFAULT_ACTION = 'start';

	public function __construct(Request $request) {
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