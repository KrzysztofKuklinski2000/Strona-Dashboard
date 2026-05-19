<?php

namespace App\Middleware;

use App\Core\Config;
use App\Core\Request;
use App\Core\SessionManager;
use App\DTO\Auth\UserDto;
use JetBrains\PhpStorm\NoReturn;

readonly class AuthMiddleware
{
    public function __construct(
        private SessionManager $sessionManager,
        private Config         $config
    )
    {
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

    public function handle(Request $request): void
    {
        $uri = $request->getServerParam('REQUEST_URI');
        $dashboardRoute = $this->config->getDashboardRoute();

        if (!str_starts_with($uri, $dashboardRoute)) {
            return;
        }

        $user = $this->sessionManager->get('user');

        if (!$user instanceof UserDto) {
            $this->redirect($this->config->getLoginRoute());
        }
    }
}