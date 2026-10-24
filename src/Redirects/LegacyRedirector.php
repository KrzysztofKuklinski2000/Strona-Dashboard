<?php

declare(strict_types=1);

namespace App\Redirects;

use App\Core\Request;

final readonly class LegacyRedirector
{
    private array $articleTargets;

    /**
     * @param array<string, string> $paths
     * @param array<int, string> $newsOffsets
     */
    public function __construct(
        private array $paths,
        private array $newsOffsets,
    ) {
        $articleTargets = [];

        foreach ($paths as $path => $target) {
            if (preg_match('~/[0-9]+-[^/]+/([0-9]+)-[^/]*$~D', $path, $matches) === 1) {
                $articleTargets[(int) $matches[1]] = $target;
            }
        }

        $this->articleTargets = $articleTargets;
    }

    public function getTarget(Request $request): ?string
    {
        // Przekierowania dotyczą wyłącznie odczytu dawnych publicznych stron.
        if (!in_array($request->getMethod(), ['GET', 'HEAD'], true)) {
            return null;
        }

        $uri = $request->getServerParam('REQUEST_URI', '/');

        if (!is_string($uri)) {
            return null;
        }

        $path = rtrim(rawurldecode(explode('?', $uri, 2)[0]), '/') ?: '/';

        if ($path === '/index.php' && (
            $request->getQueryParam('view') !== null
            || $request->getQueryParam('option') !== null
            || $request->getQueryParam('format') !== null
        )) {
            return $this->getArticleTarget($request);
        }

        if (in_array($path, [
            '/index.php/aktualnoci',
            '/index.php/aktualnoci/15-aktualnoci',
        ], true)) {
            $start = $request->getQueryParam('start', '0');

            if (!is_scalar($start) || !ctype_digit((string) $start)) {
                return null;
            }

            return $this->newsOffsets[(int) $start] ?? null;
        }

        // Brak wpisu w mapie oznacza zwykłe 404, nie przekierowanie na główną.
        return $this->paths[$path] ?? null;
    }

    private function getArticleTarget(Request $request): ?string
    {
        $option = $request->getQueryParam('option');

        if ($option !== null && $option !== 'com_content') {
            return null;
        }

        if ($request->getQueryParam('view') !== 'article') {
            return null;
        }

        $id = $request->getQueryParam('id');

        if (!is_scalar($id)
            || preg_match('/^([0-9]+)(?::[a-zA-Z0-9_-]+)?$/D', (string) $id, $matches) !== 1) {
            return null;
        }

        // Obsługa dawnych linków w formacie index.php?view=article&id=123:alias.
        return $this->articleTargets[(int) $matches[1]] ?? null;
    }
}
