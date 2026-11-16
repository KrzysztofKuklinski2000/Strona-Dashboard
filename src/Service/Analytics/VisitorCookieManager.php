<?php

namespace App\Service\Analytics;

use App\Core\Request;
use App\Security\TokenGeneratorInterface;

class VisitorCookieManager
{
    public function __construct(
        private TokenGeneratorInterface $tokenGenerator,
        private bool                    $secureCookie = true,
    )
    {
    }


    public function getOrCreate(Request $request, bool $hasAnalyticsConsent): ?string
    {
        if (!$hasAnalyticsConsent) {
            return null;
        }

        $visitor = $request->getCookieParam('visitor_id');
        if (is_string($visitor) && preg_match('/\A[a-f0-9]{64}\z/', $visitor) === 1) {
            return $visitor;
        }

        $visitor = $this->tokenGenerator->generate();

        $cookieSet = setCookie(
            name: 'visitor_id',
            value: $visitor,
            expires_or_options: [
                'expires' => time() + (86400 * 365),
                'path' => '/',
                'secure' => $this->secureCookie,
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );

        if($cookieSet === false) {
            return null;
        }

        return $visitor;
    }
}