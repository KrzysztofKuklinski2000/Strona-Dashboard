<?php
declare(strict_types=1);

namespace App\Controller;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;

class AbstractController {
	public function __construct(
		public Request $request,
		protected EasyCSRF $easyCSRF,
		public View $view, ) {}

	/**
	 * @codeCoverageIgnore
	 */
	public function redirect(string $to, int $statusCode = 302) {
		header("Location: $to", true, $statusCode);
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