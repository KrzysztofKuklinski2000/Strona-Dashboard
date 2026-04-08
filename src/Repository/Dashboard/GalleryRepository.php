<?php

namespace App\Repository\Dashboard;

use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\Positionable;

class GalleryRepository extends BaseDashboardRepository
{
    use Positionable;

    /**
     * @throws RepositoryException
     */
    public function addImage(array $data): void {
        try {
            $this->runQuery(
                "INSERT INTO gallery (image_name, description, created_at, updated_at, category) VALUES(:image_name, :description, :created_at, :updated_at, :category)",
                [
                    ":image_name" => $data['image_name'],
                    ":description" => $data['description'],
                    ":created_at" => $data['created_at'],
                    ":updated_at" => $data['updated_at'],
                    ":category" => $data['category'],
                ]
            );
        }catch(RepositoryException $e) {
            throw new RepositoryException('Nie udało się dodać zdjęcia', 500, $e);
        }
    }
}