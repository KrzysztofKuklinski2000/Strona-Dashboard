<?php 

namespace App\Repository\Dashboard;

use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Repository\AbstractRepository;
use PDO;

class BaseDashboardRepository extends AbstractRepository {

    public function getDashboardData(string $table) {
		try {
			$sql = "SELECT * FROM $table";
			if(!in_array($table, ['contact', 'fees', 'camp', 'subscribers'])) $sql .= " ORDER BY position ASC";

			return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
		}catch(RepositoryException $e) {
			throw new RepositoryException("Nie udało się pobrać danych", 500, $e);
		}
	}

    public function getPost(int $id, string $table): array {
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

    public function edit(string $table, array $data):void {
		try {
			$sql = "UPDATE $table SET ". implode(", ", array_map(fn($k) => "$k = :$k", array_filter(array_keys($data), fn($k)=> $k !== "id")));

			if(in_array($table, ['news', 'main_page_posts', 'important_posts', 'timetable', 'gallery', 'subscribers'])) $sql .= " WHERE id = :id";
			$result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);

			$this->runQuery($sql, $result);
		}catch(RepositoryException $e) {
			throw new RepositoryException("Nie udało się edytować posta", 500, $e);
		}
    }

    public function delete(int $id, string $table) {
		try {
			$this->runQuery("DELETE FROM $table WHERE id = :id", [":id" => $id]);
		} catch (RepositoryException $e) {
			throw new RepositoryException('Nie udało się usunąć posta', 500, $e);
		}
	}

	public function create(array $data, string $table): void {
		try {
			$col = implode(", ", array_map(fn($k) => "$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
			$val = implode(", ", array_map(fn($k) => ":$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
			$result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);

			$sql = "INSERT INTO $table ($col) VALUES ($val)";
			
			$this->runQuery($sql,$result);
		}catch(RepositoryException $e) {
			throw new RepositoryException("Nie udało się utworzyć posta", 500, $e);
		}
	}

    public function published(array $data, string $table) {
		try {
			$this->runQuery("UPDATE $table SET status = :published WHERE id = :id", [
				':published' => $data['published'],
				':id' => $data['id'],
			]);
		}catch(RepositoryException $e) {
			throw new RepositoryException('Nie udało się zmienić statusu', 500, $e);
		}
	}
}