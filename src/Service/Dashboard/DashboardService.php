<?php 
declare(strict_types= 1);

namespace App\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\DashboardRepository;

class DashboardService implements SharedGetDataServiceInterface, StartManagementServiceInterface {

    
    public function __construct(
        public DashboardRepository $dashboardRepository, 
    ){}

    private function getDashboardData(string $table): array {
        try {
            return $this->dashboardRepository->getDashboardData($table);
        }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać postów",500, $e);
        }
        
    }

    private function edit(string $table, array $data): void {
        try {
            $this->dashboardRepository->edit($table, $data); 
        }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się edytować",500, $e);
        }
    }
    
    private function published(string $table, array $data): void {
        try {
            $this->dashboardRepository->published($data, $table);
       }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się zmienić statusu",500, $e);
       }
    }

    private function create(string $table, array $data): void {
        try {
            $this->dashboardRepository->beginTransaction();
            $this->dashboardRepository->incrementPosition($table);
            $this->dashboardRepository->create($data, $table);
            $this->dashboardRepository->commit();
        }catch (RepositoryException $e) {
            $this->dashboardRepository->rollBack();
            throw new ServiceException("Nie udało się utworzyć posta",500, $e);
        }
    }

    private function delete(string $table, int $id): void {
        try {
            $this->dashboardRepository->beginTransaction();
            $currentPost = $this->dashboardRepository->getPost($id, $table);
            $this->dashboardRepository->delete($id, $table);
            $this->dashboardRepository->decrementPosition($table, (int) $currentPost['position']);
            $this->dashboardRepository->commit();
        }catch (RepositoryException $e) {
            $this->dashboardRepository->rollBack();
            throw new ServiceException("Nie udało się usunąć posta",500, $e);
        }
    }

    private function move(string $table, array $data):void {
        try{
            $this->dashboardRepository->beginTransaction();

            $currentPost = $this->dashboardRepository->getPost($data['id'], $table);

            $stmt = $this->dashboardRepository->getPostByPosition(
                $table, 
                $data['dir'] === 'up' ? (int) $currentPost['position'] - 1 : (int) $currentPost['position'] + 1,
                );

            if($stmt) {
                $this->dashboardRepository->movePosition($table, [':pos' => (int) $stmt['position'], ':id' => $currentPost['id']]);
                $this->dashboardRepository->movePosition($table, [':pos' => (int) $currentPost['position'], ':id' => $stmt['id']]);
            }
                
            $this->dashboardRepository->commit();
        }catch (RepositoryException $e) {
            $this->dashboardRepository->rollBack();
            throw new ServiceException("Nie udało się zmienić pozycji",500, $e);
        }
    }

    public function getPost(int $id, string $table): ?array{
        try {
            return $this->dashboardRepository->getPost($id, $table);
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać posta", 500, $e);
        }
    }

    public function getAllMain(): array
    {
        return $this->getDashboardData('main_page_posts');
    }

    public function updateMain(array $data): void
    {
        $this->edit('main_page_posts', $data);
    }

    public function createMain(array $data): void
    {
        $this->create('main_page_posts', $data);
    }

    public function publishedMain(array $data): void
    {
        $this->published('main_page_posts', $data);
    }

    public function deleteMain(int $id): void
    {
        $this->delete('main_page_posts', $id);
    }

    public function moveMain(array $data): void
    {
        $this->move('main_page_posts', $data);
    }
}       