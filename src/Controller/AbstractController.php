<?php
declare(strict_types=1);

namespace App\Controller;

use App\View;
use App\Core\Request;

class AbstractController {
	public function __construct(
		public Request $request,
		public View $view, ) {}

	/**
	 * @codeCoverageIgnore
	 */
	public function redirect(string $to, int $statusCode = 302) {
		header("Location: $to", true, $statusCode);
		exit();
	}

	protected function getFlash(string $prefix = 'dashboard'): ?array {
		$key = "flash_{$prefix}";
		$flash = $this->request->getSession($key) ?? null;
		if($flash) $this->request->removeSession($key);
		return $flash;
	}

	protected function setFlash(string $type, string|array $message, string $prefix = 'dashboard'):void {
		$this->request->setSession("flash_{$prefix}", ["type" => $type, "message" => $message]);
	}
}