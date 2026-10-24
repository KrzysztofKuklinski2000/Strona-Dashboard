<?php

declare(strict_types=1);

namespace App\Service;

use App\Content\NewsPostTypes;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\PublicNewsRepository;
use App\Seo\PublicPageMetadata;

final readonly class SitemapService
{
    public function __construct(
        private PublicNewsRepository $repository,
        private string $baseUrl,
        private int $itemsPerPage,
    ) {
    }

    /**
     * @return list<string>
     * @throws ServiceException
     */
    public function getUrls(): array
    {
        try {
            $entries = $this->repository->getSitemapEntries();
        } catch (RepositoryException $e) {
            throw new ServiceException('Nie udało się przygotować mapy witryny', 500, $e);
        }

        $paths = PublicPageMetadata::indexablePaths();
        $totalPages = (int) ceil(count($entries) / max(1, $this->itemsPerPage));

        for ($page = 2; $page <= $totalPages; $page++) {
            $paths[] = '/aktualnosci/' . $page;
        }

        foreach ($entries as $entry) {
            $id = (int) $entry['id'];

            if ($id > 0 && NewsPostTypes::detailsPartial((string) $entry['type']) !== null) {
                $paths[] = '/aktualnosci/wpis/' . $id;
            }
        }

        return array_values(array_unique(array_map(
            fn (string $path): string => rtrim($this->baseUrl, '/') . $path,
            $paths,
        )));
    }
}
