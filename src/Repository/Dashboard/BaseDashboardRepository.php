<?php 

namespace App\Repository\Dashboard;

use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Repository\AbstractRepository;
use PDO;

class BaseDashboardRepository extends AbstractRepository {

    /**
     * @throws RepositoryException
     */
    public function getDashboardData(string $table): array
    {
		try {
			$sql = "SELECT * FROM $table";
			if(!in_array($table, ['contact', 'fees', 'camp', 'subscribers'])) $sql .= " ORDER BY position ASC";

			return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
		}catch(RepositoryException $e) {
			throw new RepositoryException("Nie udało się pobrać danych", 500, $e);
		}
	}

    /**
     * @throws RepositoryException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): array {
		try {
			$result = $this->runQuery("SELECT * FROM $table WHERE id = :id", [':id' => $id])->fetch(PDO::FETCH_ASSOC);
		} catch (RepositoryException $e) {
			throw new RepositoryException('Nie udało się pobrać posta', 500, $e);
		}

		if(!$result) {
			throw new NotFoundException('Nie ma takiego posta', 404);
		}


		return $result;
	}
}