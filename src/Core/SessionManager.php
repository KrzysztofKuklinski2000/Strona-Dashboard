<?php

declare(strict_types=1);

namespace App\Core;

use App\DTO\Auth\UserDto;
use RuntimeException;

class SessionManager
{
    private const AUTH_IDLE_TIMEOUT = 30 * 60;
    private const AUTH_MAX_LIFETIME = 8 * 60 * 60;

    public function __construct(bool $secureCookies = true)
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.use_strict_mode', 1);
            ini_set('session.use_cookies', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.gc_maxlifetime', (string)self::AUTH_MAX_LIFETIME);
            ini_set('session.use_trans_sid', '0');

            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => '',
                'secure' => $secureCookies,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            if(!session_start()) {
                throw new RuntimeException('Nie udało się uruchomić sesji.');
            }
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function regenerate(): void
    {
        if (!session_regenerate_id(true)) {
            throw new RuntimeException(
                'Nie udało się odnowić identyfikatora sesji.'
            );
        }
    }

    public function destroy(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(session_name(), '', [
                'expires' => time() - 42000,
                'path' => $params['path'],
                'domain' => $params['domain'],
                'secure' => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'],
            ]);
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

    public function setFlash(
        string $type,
        string|array $message,
        string $prefix = 'dashboard',
        array $context = []
    ): void {
        $this->set(
            "flash_$prefix",
            [
                "type" => $type,
                "message" => $message,
                'context' => $context
            ]
        );
    }

    public function startAuthentication(UserDto $user): void
    {
        $_SESSION = [];
        $this->regenerate();

        $now = time();

        $this->set('user', $user);
        $this->set('auth_started_at', $now);
        $this->set('auth_last_activity_at', $now);
    }


    public function isAuthenticated(): bool
    {
        $user = $this->get('user');

        if (!$user instanceof UserDto) {
            return false;
        }

        $now = time();
        $startedAt = $this->get('auth_started_at');
        $lastActivityAt = $this->get('auth_last_activity_at');

        $invalidTimestamps =
            !is_int($startedAt)
            || !is_int($lastActivityAt)
            || $startedAt <= 0
            || $lastActivityAt < $startedAt
            || $startedAt > $now
            || $lastActivityAt > $now;

        if (
            $invalidTimestamps
            || $now - $lastActivityAt >= self::AUTH_IDLE_TIMEOUT
            || $now - $startedAt >= self::AUTH_MAX_LIFETIME
        ) {
            $_SESSION = [];
            $this->regenerate();

            return false;
        }

        $this->set('auth_last_activity_at', $now);

        return true;
    }
}
