<?php 
declare(strict_types= 1);

namespace App\Repository;

use PDO;
use PDOStatement;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;

class DashboardRepository extends AbstractRepository {
    public function getDashboardData(string $table) {
		try {	
			$table = $this->validateTable($table);
			$sql = "SELECT * FROM $table";
			if(!in_array($table, ['contact', 'fees', 'camp'])) $sql .= " ORDER BY position ASC";

			return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
		}catch(RepositoryException $e) {
			throw new RepositoryException("Nie udało się pobrać danych", 500, $e);
		}
	}

    public function getPost(int $id, string $table): array {
		try {
			$table = $this->validateTable($table);
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
			$table = $this->validateTable($table);
			$sql = "UPDATE $table SET ". implode(", ", array_map(fn($k) => "$k = :$k", array_filter(array_keys($data), fn($k)=> $k !== "id")));

			if(in_array($table, ['news', 'main_page_posts', 'important_posts', 'timetable', 'gallery'])) $sql .= " WHERE id = :id";
			$result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);

			$this->runQuery($sql, $result);
		}catch(RepositoryException $e) {
			throw new RepositoryException("Nie udało się edytować posta", 500, $e);
		}
    }

    public function movePosition(string $table, array $params): PDOStatement {
		try {
			$table = $this->validateTable($table);
			return $this->runQuery("UPDATE $table SET position = :pos WHERE id = :id", $params);
		}catch (RepositoryException $e) {
			throw new RepositoryException("Nie udało się zmienić pozycji", 500, $e);
		}
		
	}

	public function getPostByPosition(string $table, int $position): array {
		try{
			$table = $this->validateTable($table);
			return $this->runQuery("SELECT * FROM $table WHERE position = :pos", [':pos' => $position])->fetch(PDO::FETCH_ASSOC) ?: [];
		}catch(RepositoryException $e) {
			throw new RepositoryException("Nie udało się pobrać elementu", 500, $e);
		}
	}

	public function incrementPosition(string $table):void {
		try{
			$table = $this->validateTable($table);
			$this->runQuery("UPDATE $table SET position = position + 1");
		}catch(RepositoryException $e) {
			throw new RepositoryException("Nie udało się zmienić pozycji", 500, $e);
		}
	}

	public function decrementPosition(string $table, int $position) :void {
		try {
			$table = $this->validateTable($table);
			$this->runQuery("UPDATE $table set position = position - 1 WHERE position > :pos", [':pos' => $position]);
		}catch(RepositoryException $e) {
			throw new RepositoryException('Nie udało się zmienić pozycji', 500, $e);
		}
	}

	public function delete(int $id, string $table) {
		try {
			$table = $this->validateTable($table);
			$this->runQuery("DELETE FROM $table WHERE id = :id", [":id" => $id]);
		} catch (RepositoryException $e) {
			throw new RepositoryException('Nie udało się usunąć posta', 500, $e);
		}
	}

	public function create(array $data, string $table): void {
		try {
			$table = $this->validateTable($table);
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
			$table = $this->validateTable($table);
			$this->runQuery("UPDATE $table SET status = :published WHERE id = :id", [
				':published' => $data['published'],
				':id' => $data['id'],
			]);
		}catch(RepositoryException $e) {
			throw new RepositoryException('Nie udało się zmienić statusu', 500, $e);
		}
	}

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