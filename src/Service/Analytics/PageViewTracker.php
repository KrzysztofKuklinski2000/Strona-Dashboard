<?php
declare(strict_types=1);

namespace App\Service\Analytics;

use App\Core\Request;
use App\Exception\RepositoryException;
use App\Repository\Analytics\PageViewRepository;

class PageViewTracker
{
    public function __construct(private readonly PageViewRepository $repository)
    {
    }

    public function track(Request $request): void {
        if(!$request->isGet()) {
            return;
        }

        $requestUri = (string) $request->getServerParam('REQUEST_URI');
        $path =  (parse_url($requestUri, PHP_URL_PATH) ?? '');

        if($path !== '' && is_string($path)) {
            try{
                $this->repository->record($path);
            }catch (RepositoryException $e) {
                error_log($e->getMessage());
            }
        }
    }
}