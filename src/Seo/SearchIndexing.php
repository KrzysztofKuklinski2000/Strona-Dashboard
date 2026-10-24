<?php

declare(strict_types=1);

namespace App\Seo;

use App\Core\Config;
use App\Core\Request;

final readonly class SearchIndexing
{
    public function __construct(private Config $config)
    {
    }

    public function isAllowed(Request $request): bool
    {
        $seo = $this->config->getSeoConfig();

        if ($this->config->getEnv() !== 'prod'
            || filter_var($seo['indexing_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN) !== true) {
            return false;
        }

        $baseUrl = $this->config->getUrl();
        $canonicalHost = strtolower((string) parse_url($baseUrl, PHP_URL_HOST));
        $requestHost = $request->getServerParam('HTTP_HOST', '');

        if (!is_string($requestHost)
            || parse_url($baseUrl, PHP_URL_SCHEME) !== 'https'
            || !in_array($canonicalHost, $seo['public_hosts'] ?? [], true)) {
            return false;
        }

        // Nawet po uruchomieniu domeny adres podglądu nie staje się indeksowalny.
        $requestHost = strtolower((string) parse_url('http://' . $requestHost, PHP_URL_HOST));

        return $requestHost === $canonicalHost;
    }
}
