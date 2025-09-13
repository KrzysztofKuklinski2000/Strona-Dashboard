<?php 
declare(strict_types= 1);
namespace App\Repository;

use App\Exception\RepositoryException;
use PDO;
class SiteRepository extends AbstractRepository {

    public function getData(string $table):array {
        try {
            $this->validateTable($table);
            $sql = "SELECT * FROM $table WHERE status = 1 ORDER BY position ASC";
            return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
        }catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać danych",500, $e);
        }
    }

    public function getSingleRecord(string $table):array {
        try {
            $this->validateTable($table);
            $sql = "SELECT * FROM $table";
            return $this->runQuery($sql)->fetch(PDO::FETCH_ASSOC);
        }catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać danych",500, $e);
        }
    }

    public function getNews(int $limit, int $offset):array {
        try {
            $sql = "SELECT * FROM news WHERE status = 1 ORDER BY position ASC LIMIT :limit OFFSET :offset";

            return $this->runQuery($sql, [
                ':limit' => [$limit, PDO::PARAM_INT], 
                ':offset' => [$offset, PDO::PARAM_INT]
            ])->fetchAll(PDO::FETCH_ASSOC);
        }catch(RepositoryException $e){
            throw new RepositoryException('Nie udało się pobrać aktualności',500, $e);
        }
    }

    public function getGallery(string $category = null): array {
        try {
            $sql = "SELECT * FROM gallery WHERE status = 1";
            $params = [];

            if($category && in_array($category, ["training","camp"])) {
                $sql .= " AND category = :category";
                $params[':category'] = $category;
            }

            $sql .= " ORDER BY position ASC";

            return $this->runQuery($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

        }catch(RepositoryException $e){
            throw new RepositoryException('Nie udało się pobrać galeri',500, $e);
        }
    }

    public function countData(string $table): int {
		try {
            $stmt = $this->runQuery("SELECT COUNT(*) FROM $table");
		    return (int) $stmt->fetchColumn();
        }catch(RepositoryException $e){
            throw new RepositoryException("Nie udało się pobrać liczby rekordów",500, $e);
        }
	}
}