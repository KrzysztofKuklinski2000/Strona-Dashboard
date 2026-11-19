<?php

declare(strict_types=1);

namespace App\Service\Analytics;

use App\Core\Request;
use App\Security\TokenGeneratorInterface;

class VisitorCookieManager
{
    public function __construct(
        private TokenGeneratorInterface $tokenGenerator,
        private bool                    $secureCookie = true,
    ) {
    }

    public function getOrCreate(Request $request, bool $hasAnalyticsConsent): ?string
    {
        if (!$hasAnalyticsConsent) {
            return null;
        }

        $visitorId = $request->getCookieParam('visitor_id');
        if (is_string($visitorId) && preg_match('/\A[a-f0-9]{64}\z/', $visitorId) === 1) {
            return $visitorId;
        }

        $visitorId = $this->tokenGenerator->generate();

        $cookieSet = setCookie(
            name: 'visitor_id',
            value: $visitorId,
            expires_or_options: [
                'expires' => time() + (86400 * 365),
                'path' => '/',
                'secure' => $this->secureCookie,
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );

        if ($cookieSet === false) {
            return null;
        }

        return $visitorId;
    }

    public function delete(): bool {
        return setCookie(
            name: 'visitor_id',
            value: '',
            expires_or_options: [
                'expires' => time() - 3600,
                'path' => '/',
                'secure' => $this->secureCookie,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
    }

    public function getExisting(Request $request): ?string {
        $visitorId = $request->getCookieParam('visitor_id');

        if (is_string($visitorId) && preg_match('/\A[a-f0-9]{64}\z/', $visitorId) === 1) {
            return $visitorId;
        }

        return null;
    }
}
