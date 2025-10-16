<?php
declare(strict_types=1);

namespace App\Controller;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use App\Exception\NotFoundException;

class AbstractController {
	
	public View $view;
	private ActionResolver $actionResolver;
	

	public function __construct(public Request $request, protected EasyCSRF $easyCSRF) {
		$this->view = new View();
		$this->actionResolver = new ActionResolver();
	}

	public function run(): void {
		$action = $this->actionResolver->resolve($this->request);
		
		if(!method_exists($this, $action)){
			throw new NotFoundException(sprintf('Action "%s" not found in controller "%s".', $action, static::class));
		}

		if (!method_exists($this, $action)) {
			throw new \LogicException(sprintf('Controller "%s" does not have a default "indexAction" method.', static::class));
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