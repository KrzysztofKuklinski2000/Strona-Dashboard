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
}