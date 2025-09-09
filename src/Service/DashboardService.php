<?php 
declare(strict_types= 1);
namespace App\Service;

use App\Repository\DashboardRepository;
use App\Exception\StorageException;
use App\Core\FileHandler;
use Throwable;

class DashboardService {

    private FileHandler $fileHandler;
    public function __construct(public DashboardRepository $dashboardRepository){
        $this->fileHandler = new FileHandler();
    }

    public function getDashboardData(string $table): array {
        try {
            return $this->dashboardRepository->getDashboardData($table);
        }catch (Throwable $e) {
            throw new StorageException("Nie udało się pobrać postów",0, $e);
        }
        
    }

    public function getPost(int $id, string $table): array {
        try{
            return $this->dashboardRepository->getPost($id, $table);
        }catch (Throwable $e) { 
            throw new StorageException("Nie udało się pobrać posta",0, $e);
        }
    }

    public function timetablePageData(): array {
        try {
            return $this->dashboardRepository->timetablePageData();
        }catch (Throwable $e) {
            throw new StorageException("Nie udało się pobrać grafiku",0, $e);
        }
    }

    public function edit(string $table, array $data): void {
        try {
            $this->dashboardRepository->edit($table, $data); 
        }catch (Throwable $e) {
            throw new StorageException("Nie udało się edytować",0, $e);
        }
    }
    
    public function published(string $table, array $data): void {
        try {
            $this->dashboardRepository->published($data, $table);
       }catch (Throwable $e) {
            throw new StorageException("Nie udało się zmienić statusu",0, $e);
       }
    }

    public function create(string $table, array $data): void {
        try {
            $this->dashboardRepository->con->beginTransaction();
            $this->dashboardRepository->incrementPosition($table);
            $this->dashboardRepository->create($data, $table);
            $this->dashboardRepository->con->commit();
        }catch (Throwable $e) {
            $this->dashboardRepository->con->rollBack();
            throw new StorageException("Nie udało się utworzyć wpisu",0, $e);
        }
    }

    public function delete(int $id, string $table): void {
        try {
            $this->dashboardRepository->con->beginTransaction();
            $currentPost = $this->dashboardRepository->getPost($id, $table);
            $this->dashboardRepository->delete($id, $table);
            $this->dashboardRepository->decrementPosition($table, (int) $currentPost['position']);
            $this->dashboardRepository->con->commit();
        }catch (Throwable $e) {
            $this->dashboardRepository->con->rollBack();
            throw new StorageException("Nie udało się usunąć wpisu",0, $e);
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
        }catch (Throwable $e) {
            $this->dashboardRepository->con->rollBack();
            throw new StorageException("Nie udało się zmienić pozycji",0, $e);
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
        }catch (Throwable $e) {
            $this->dashboardRepository->con->rollBack();
            throw new StorageException("Nie udało się dodać zdjęcia",0, $e);
        }
    }
}