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

    public function destroy(): void {
        session_destroy();
        $_SESSION = [];
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