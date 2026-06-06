<?php

namespace App\Core;

class SessionManager
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get(string $key, mixed $default = null): mixed {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    public function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    public function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public function destroy(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    public function getFlash(string $prefix = 'dashboard'): ?array
    {
        $key = "flash_$prefix";
        $flash = $this->get($key) ?? null;

        if ($flash) {
            $this->remove($key);
        }

        return $flash;
    }

    public function setFlash(string $type, string|array $message, string $prefix = 'dashboard'): void
    {
        $this->set("flash_$prefix", ["type" => $type, "message" => $message]);
    }
}