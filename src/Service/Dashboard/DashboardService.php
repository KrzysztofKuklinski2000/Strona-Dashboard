<?php 
declare(strict_types= 1);

namespace App\Service\Dashboard;

use App\Repository\DashboardRepository;
use App\Core\FileHandler;
use App\Exception\FileException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;

class DashboardService implements NewsManagementServiceInterface, SharedGetDataServiceInterface, StartManagementServiceInterface, ImportantPostsManagementServiceInterface, GalleryManagementServiceInterface, TimeTableManagementServiceInterface, FeesManagementServiceInterface, CampManagementServiceInterface, ContactManagementServiceInterface {

    
    public function __construct(public DashboardRepository $dashboardRepository, private FileHandler $fileHandler){}

    private function getDashboardData(string $table): array {
        try {
            return $this->dashboardRepository->getDashboardData($table);
        }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać postów",500, $e);
        }
        
    }

    private function timetablePageData(): array {
        try {
            return $this->dashboardRepository->timetablePageData();
        }catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać grafiku",500, $e);
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

    public function addImage(array $data): void {
        try{
            $this->dashboardRepository->beginTransaction();
            $imageName = $this->fileHandler->uploadImage($data['image_name']);
            $this->dashboardRepository->incrementPosition('gallery');
            $data['image_name'] = $imageName;
            $this->dashboardRepository->addImage($data);
            $this->dashboardRepository->commit();
        }catch (RepositoryException | FileException $e) {
            $this->dashboardRepository->rollBack();
            throw new ServiceException("Nie udało się dodać zdjęcia",500, $e);
        }
    }

    public function getAllNews(): array {
        return $this->getDashboardData('news');
    }

    public function updateNews(array $data): void {
        $this->edit('news', $data);
    }

    public function createNews(array $data): void {
        $this->create('news', $data);
    }

    public function publishedNews(array $data): void {
        $this->published('news', $data);
    }

    public function deleteNews(int $id): void {
        $this->delete('news', $id);
    }

    public function moveNews(array $data): void{
        $this->move('news', $data);
    }

    public function getAllImportantPosts(): array
    {
        return $this->getDashboardData('important_posts');
    }

    public function updateImportantPost(array $data): void
    {
        $this->edit('important_posts', $data);
    }

    public function createImportantPost(array $data): void
    {
        $this->create('important_posts', $data);
    }

    public function publishedImportantPost(array $data): void
    {
        $this->published('important_posts', $data);
    }

    public function deleteImportantPost(int $id): void
    {
        $this->delete('important_posts', $id);
    }

    public function moveImportantPost(array $data): void
    {
        $this->move('important_posts', $data);
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
    
    public function getAllGallery(): array {
        return $this->getDashboardData('gallery');
    }
    
    public function updateGallery(array $data): void {
        $this->edit('gallery', $data);
    }

    public function createGallery(array $data): void {
        $this->addImage($data);
    }

    public function publishedGallery(array $data): void {
        $this->published('gallery', $data);
    }

    public function deleteGallery(int $id): void {
        $this->delete('gallery', $id);
    }

    public function moveGallery(array $data): void {
        $this->move('gallery', $data);
    }

    public function getAllTimetable(): array {
        return $this->timetablePageData();
    }

    public function updateTimetable(array $data): void {
        $this->edit('timetable', $data);
    }

    public function createTimetable(array $data): void {
        $this->create('timetable', $data);
    }

    public function publishedTimetable(array $data): void {
        $this->published('timetable', $data);
    }

    public function deleteTimetable(int $id): void {
        $this->delete('timetable', $id);
    }

    public function moveTimetable(array $data): void {
        $this->move('timetable', $data);
    }

    public function updateFees(array $data): void {
        $this->edit('fees', $data);
    }
    public function getFees(): array {
        return $this->getDashboardData('fees')[0];
    }

    public function updateCamp(array $data): void {
        $this->edit('camp', $data);
    }

    public function getCamp(): array {
        return $this->getDashboardData('camp')[0];
    }

    public function updateContact(array $data): void {
        $this->edit('contact', $data);
    }

    public function getContact(): array {
        return $this->getDashboardData('contact')[0];
    }
}       