<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\Core\Request;
use App\Core\SessionManager;
use App\Core\Validator;
use App\Middleware\CsrfMiddleware;
use App\View\View;
use JetBrains\PhpStorm\NoReturn;

class AbstractController
{
    protected Request $request;
    protected View $view;
    protected CsrfMiddleware $csrfMiddleware;
    protected SessionManager $sessionManager;
    protected Validator $validator;

    public function __construct(
        protected ContextController $contextController,
    )
    {
        $this->request = $this->contextController->request;
        $this->view = $this->contextController->view;
        $this->csrfMiddleware = $this->contextController->csrfMiddleware;
        $this->validator = $this->contextController->validator;
        $this->sessionManager = $this->contextController->sessionManager;
    }

    /**
     * @codeCoverageIgnore
     */
    #[NoReturn]
    public function redirect(string $to, int $statusCode = 302): void
    {
        header("Location: $to", true, $statusCode);
        exit();
    }

    protected function getFlash(string $prefix = 'dashboard'): ?array
    {
        $key = "flash_$prefix";
        $flash = $this->sessionManager->get($key) ?? null;
        if ($flash) $this->sessionManager->remove($key);
        return $flash;
    }

    protected function setFlash(string $type, string|array $message, string $prefix = 'dashboard'): void
    {
        $this->sessionManager->set("flash_$prefix", ["type" => $type, "message" => $message]);
    }
}