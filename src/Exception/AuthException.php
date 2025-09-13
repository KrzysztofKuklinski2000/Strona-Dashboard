<?php 
declare(strict_types=1);

namespace App\Exception;

use Throwable;

class AuthException extends AppException
{
    public const LOGIN_FAILED = 4001;
    public const INVALID_CREDENTIALS = 4002;
    public const ACCESS_DENIED = 4003;
    public const SESSION_EXPIRED = 4004;
    public const USER_NOT_FOUND = 4005;

    public static function loginFailed(
        string $reason = '', 
        ?Throwable $previous = null
    ): self {
        return new self(
            "Login attempt failed: $reason",
            self::LOGIN_FAILED,
            $previous,
            ['login_attempt' => true],
            'Logowanie nie powiodło się. Sprawdź dane i spróbuj ponownie.'
        );
    }

    public static function invalidCredentials(): self
    {
        return new self(
            "Invalid username or password provided",
            self::INVALID_CREDENTIALS,
            null,
            ['authentication' => 'failed'],
            'Niepoprawny login lub hasło.'
        );
    }

    public static function accessDenied(string $resource = ''): self
    {
        return new self(
            "Access denied" . ($resource ? " to resource: $resource" : ""),
            self::ACCESS_DENIED,
            null,
            ['resource' => $resource],
            'Brak uprawnień do tej strony.'
        );
    }

    public static function sessionExpired(): self
    {
        return new self(
            "User session has expired",
            self::SESSION_EXPIRED,
            null,
            ['session' => 'expired'],
            'Sesja wygasła. Zaloguj się ponownie.'
        );
    }

    public static function userNotFound(string $identifier): self
    {
        return new self(
            "User not found: $identifier",
            self::USER_NOT_FOUND,
            null,
            ['user_identifier' => $identifier],
            'Użytkownik nie został znaleziony.'
        );
    }
}