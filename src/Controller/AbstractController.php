<?php
declare(strict_types=1);

namespace App\Controller;

use App\View;
use App\Request;
use EasyCSRF\EasyCSRF;


class AbstractController {
	public View $view;
	public Request $request;
	protected EasyCSRF $easyCSRF;
	private ActionResolver $actionResolver;
	private const DEFAULT_ACTION = 'start';

	public function __construct(Request $request, EasyCSRF $easyCSRF) {
		$this->view = new View();
		$this->request = $request;
		$this->actionResolver = new ActionResolver();
		$this->easyCSRF = $easyCSRF;
	}

	public function run(): void {
		$action = $this->actionResolver->resolve($this->request);
		
		if(!method_exists($this, $action)){
			if(str_ends_with($action, 'DashboardAction')) {
				$action = self::DEFAULT_ACTION . "DashboardAction";
			}else {
				$action = self::DEFAULT_ACTION . "Action";
			}
		}
		$this->$action();
	}

	public function redirect(string $to) {
		$location = $to == '/' ? '?dashboard=start' : $to;
		header("Location: $location");
		exit();
	}

	protected function getFlash(): ?array {
		$flash = $this->request->getSession('flash') ?? null;
		if($flash) $this->request->removeSession('flash');
		return $flash;
	}

	protected function setFlash(string $type, string|array $message):void {
		$this->request->setSession('flash', ["type" => $type, "message" => $message]);
	}
}