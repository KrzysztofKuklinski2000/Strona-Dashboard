<?php 
declare(strict_types= 1);
namespace App\Service;

use App\Repository\DashboardRepository;
use App\Core\FileHandler;
use App\Exception\FileException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;

class DashboardService {

    private FileHandler $fileHandler;
    public function __construct(public DashboardRepository $dashboardRepository){
        $this->fileHandler = new FileHandler();
    }

    public function getDashboardData(string $table): array {
        try {
            return $this->dashboardRepository->getDashboardData($table);
        }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać postów",500, $e);
        }
        
    }

    public function getPost(int $id, string $table): array {
        try{
            return $this->dashboardRepository->getPost($id, $table);
        }catch (RepositoryException $e) { 
            throw new ServiceException("Nie udało się pobrać posta",500, $e);
        }
    }

    public function timetablePageData(): array {
        try {
            return $this->dashboardRepository->timetablePageData();
        }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać grafiku",500, $e);
        }
    }

    public function edit(string $table, array $data): void {
        try {
            $this->dashboardRepository->edit($table, $data); 
        }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się edytować",500, $e);
        }
    }
    
    public function published(string $table, array $data): void {
        try {
            $this->dashboardRepository->published($data, $table);
       }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się zmienić statusu",500, $e);
       }
    }

    public function create(string $table, array $data): void {
        try {
            $this->dashboardRepository->con->beginTransaction();
            $this->dashboardRepository->incrementPosition($table);
            $this->dashboardRepository->create($data, $table);
            $this->dashboardRepository->con->commit();
        }catch (RepositoryException $e) {
            $this->dashboardRepository->con->rollBack();
            throw new ServiceException("Nie udało się utworzyć posta",500, $e);
        }
    }

    public function delete(int $id, string $table): void {
        try {
            $this->dashboardRepository->con->beginTransaction();
            $currentPost = $this->dashboardRepository->getPost($id, $table);
            $this->dashboardRepository->delete($id, $table);
            $this->dashboardRepository->decrementPosition($table, (int) $currentPost['position']);
            $this->dashboardRepository->con->commit();
        }catch (RepositoryException $e) {
            $this->dashboardRepository->con->rollBack();
            throw new ServiceException("Nie udało się usunąć posta",500, $e);
        }
    }

    public function move(string $table, array $data):void {
        try{
            $this->dashboardRepository->con->beginTransaction();

            $currentPost = $this->dashboardRepository->getPost($data['id'], $table);

            $stmt = $this->dashboardRepository->getPostByPosition(
                $table, 
                $data['dir'] === 'up' ? (int) $currentPost['position'] - 1 : (int) $currentPost['position'] + 1,
                );

            if($stmt) {
                $this->dashboardRepository->movePosition($table, [':pos' => (int) $stmt['position'], ':id' => $currentPost['id']]);
                $this->dashboardRepository->movePosition($table, [':pos' => (int) $currentPost['position'], ':id' => $stmt['id']]);
            }
                
            $this->dashboardRepository->con->commit();
        }catch (RepositoryException $e) {
            $this->dashboardRepository->con->rollBack();
            throw new ServiceException("Nie udało się zmienić pozycji",500, $e);
        }
    }

    public function addImage(array $data): void {
        try{
            $this->dashboardRepository->con->beginTransaction();
            $imageName = $this->fileHandler->uploadImage($data['image_name']);
            $this->dashboardRepository->incrementPosition('gallery');
            $data['image_name'] = $imageName;
            $this->dashboardRepository->addImage($data);
            $this->dashboardRepository->con->commit();
        }catch (RepositoryException | FileException $e) {
            $this->dashboardRepository->con->rollBack();
            throw new ServiceException("Nie udało się dodać zdjęcia",500, $e);
        }
    }
}