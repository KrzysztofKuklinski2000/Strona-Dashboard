<?php

declare(strict_types=1);

namespace App\Service\Analytics;

use App\Core\Request;

class UniqueVisitorTracker
{
    private const AUTOMATED_USER_AGENT_PATTERN = '~\b(?:'
        . 'googlebot|googleother|google-inspectiontool|google-site-verification|google-safety'
        . '|adsbot-google|mediapartners-google|feedfetcher-google|apis-google|storebot-google'
        . '|bingbot|bingpreview|adidxbot|duckduckbot|baiduspider|yandexbot|yandeximages|applebot|petalbot'
        . '|ahrefsbot|semrushbot|dotbot|mj12bot|blexbot|amazonbot|bytespider|ccbot'
        . '|gptbot|chatgpt-user|oai-searchbot|claudebot|claude-searchbot|claude-user'
        . '|facebookexternalhit|meta-externalagent|meta-externalfetcher|twitterbot|linkedinbot|discordbot|telegrambot|whatsapp'
        . '|headlesschrome|chrome-lighthouse|pagespeed|selenium|playwright|puppeteer'
        . '|curl|wget|python-requests|python-urllib|go-http-client|guzzlehttp|libwww-perl|apache-httpclient'
        . ')\b~i';

    public function getTrackablePath(
        Request $request,
        int $responseStatus = 200,
        bool $isAdministrator = false,
        ?string $visitorId = null,
    ): ?string {
        if (!$request->isGet()
            || $responseStatus !== 200
            || $isAdministrator
            || $this->isAutomatedRequest($request)) {
            return null;
        }

        $requestUri = $request->getServerParam('REQUEST_URI', '');

        if (!is_string($requestUri)) {
            return null;
        }

        return $this->getNormalizedPath($requestUri, $visitorId);
    }

    public function getTrackablePathAfterConsent(
        Request $request,
        string $path,
        bool $isAdministrator = false,
        ?string $visitorId = null,
    ): ?string {
        if (!$request->isPost()
            || $isAdministrator
            || $this->isAutomatedRequest($request, allowFetch: true)) {
            return null;
        }

        return $this->getNormalizedPath($path, $visitorId);
    }

    private function getNormalizedPath(string $requestUri, ?string $visitorId): ?string
    {
        if ($visitorId === null || preg_match('/\A[a-f0-9]{64}\z/', $visitorId) !== 1) {
            return null;
        }

        $path = parse_url($requestUri, PHP_URL_PATH);

        if (!is_string($path)
            || !str_starts_with($requestUri, '/')
            || str_starts_with($requestUri, '//')
            || strlen($path) > 255) {
            return null;
        }

        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = substr($path, 0, -1);
        }

        return $path;
    }

    private function isAutomatedRequest(Request $request, bool $allowFetch = false): bool
    {
        $userAgent = $request->getServerParam('HTTP_USER_AGENT', '');

        if (!is_string($userAgent)
            || trim($userAgent) === ''
            || preg_match(self::AUTOMATED_USER_AGENT_PATTERN, $userAgent) === 1) {
            return true;
        }

        $destination = $request->getServerParam('HTTP_SEC_FETCH_DEST', '');
        $allowedDestinations = $allowFetch ? ['document', 'empty'] : ['document'];

        if (is_string($destination) && $destination !== ''
            && !in_array(strtolower($destination), $allowedDestinations, true)) {
            return true;
        }

        foreach (['HTTP_PURPOSE', 'HTTP_SEC_PURPOSE', 'HTTP_X_PURPOSE'] as $header) {
            $purpose = $request->getServerParam($header, '');

            if (is_string($purpose) && preg_match('~\b(?:prefetch|prerender)\b~i', $purpose) === 1) {
                return true;
            }
        }

        return false;
    }
}
