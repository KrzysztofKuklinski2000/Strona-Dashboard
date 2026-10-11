<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Controller\Dashboard\AbstractDashboardController;
use App\Core\Config;
use App\Core\SessionManager;
use App\DTO\Auth\UserDto;
use JetBrains\PhpStorm\NoReturn;

readonly class AuthMiddleware
{
    public function __construct(
        private SessionManager $sessionManager,
        private Config         $config
    ) {
    }

    /**
     * @codeCoverageIgnore
     */
    #[NoReturn]
    private function redirect(string $to): void
    {
        header("Location: $to", true, 302);
        exit();
    }

    public function handle(string $controllerClass): void
    {

        if(!is_a($controllerClass, AbstractDashboardController::class, true)) {
            return;
        }

        $user = $this->sessionManager->get('user');

        if (!$user instanceof UserDto) {
            $this->redirect($this->config->getLoginRoute());
        }
    }
}
