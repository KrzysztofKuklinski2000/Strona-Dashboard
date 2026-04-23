<?php

namespace App\Controller\Dashboard\Traits;

use App\Core\Request;
use App\Exception\NotFoundException;
use App\Service\Dashboard\SharedGetDataServiceInterface;

/**
 * @property Request $request
 * @property SharedGetDataServiceInterface $service
 * @method string getTableName()
 */

trait HasSingleData
{
    /**
     * @throws NotFoundException
     */
    protected function getSingleData(): array
    {
        $postId = $this->request->getRouteParam('id');
        if ($postId === null || !ctype_digit((string)$postId)) {
            throw new NotFoundException("Required 'id' parameter is missing or invalid");
        }

        $postId = (int)$postId;
        return $this->service->getPost($this->getTableName(), $postId);
    }
}