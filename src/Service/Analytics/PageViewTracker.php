<?php
declare(strict_types=1);

namespace App\Service\Analytics;

use App\Core\Request;
use App\Exception\RepositoryException;
use App\Repository\Analytics\PageViewRepository;

class PageViewTracker
{
    // Filtr statystyk, nie mechanizm blokowania dostępu do strony.
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

    public function __construct(private readonly PageViewRepository $repository)
    {
    }

    public function track(
        Request $request,
        int $responseStatus = 200,
        bool $isAdministrator = false,
    ): void {
        if (!$request->isGet()
            || $responseStatus !== 200
            || $isAdministrator
            || $this->isAutomatedRequest($request)) {
            return;
        }

        $requestUri = $request->getServerParam('REQUEST_URI', '');

        if (!is_string($requestUri)) {
            return;
        }

        $path = parse_url($requestUri, PHP_URL_PATH);

        if (!is_string($path)
            || !str_starts_with($path, '/')
            || strlen($path) > 255) {
            return;
        }

        try {
            $this->repository->record(rtrim($path, '/') ?: '/');
        } catch (RepositoryException $e) {
            error_log($e->getMessage());
        }
    }

    private function isAutomatedRequest(Request $request): bool
    {
        $userAgent = $request->getServerParam('HTTP_USER_AGENT', '');

        if (!is_string($userAgent)
            || trim($userAgent) === ''
            || preg_match(self::AUTOMATED_USER_AGENT_PATTERN, $userAgent) === 1) {
            return true;
        }

        $destination = $request->getServerParam('HTTP_SEC_FETCH_DEST', '');

        if (is_string($destination) && $destination !== '' && strtolower($destination) !== 'document') {
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
