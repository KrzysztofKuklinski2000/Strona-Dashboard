<?php
declare(strict_types=1);

namespace App\Service\Analytics;

use App\Core\Request;

class CookieConsentManager
{
    public function __construct(private bool $secureCookie = true)
    {
    }

    public function getDecision(Request $request): ?string {
        $decision = $request->getCookieParam('analytics_consent');

        return in_array($decision, ['accepted', 'rejected'], true)
            ? $decision
            : null;
    }

    public function saveDecision(string $decision): bool {
        if(!in_array($decision, ['accepted', 'rejected'], true)) return false;

        $cookieSet = setCookie(
            name: 'analytics_consent',
            value: $decision,
            expires_or_options: [
                'expires' => time() + (86400 * 365),
                'path' => '/',
                'secure' => $this->secureCookie,
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );

        return $cookieSet;
    }
}