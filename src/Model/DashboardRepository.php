<?php 
declare(strict_types= 1);

namespace App\Model;

use PDO;
use Throwable;
use PDOStatement;
use App\Model\AbstractModel;
use App\Exception\StorageException;
use App\Exception\NotFoundException;


class DashboardRepository extends AbstractModel {
    public function getDashboardData(string $table) {
		try {	
			$table = $this->validateTable($table);
			$sql = "SELECT * FROM $table";
			if(!in_array($table, ['contact', 'fees', 'camp'])) $sql .= " ORDER BY position ASC";

			return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
		}catch(Throwable $e) {
			throw new StorageException("Nie udało się pobrać danych");
		}
	}

    public function getPost(int $id, string $table): array {
		try {
			$table = $this->validateTable($table);
			$result = $this->runQuery("SELECT * FROM $table WHERE id = :id", [':id' => $id])->fetch(PDO::FETCH_ASSOC);
		} catch (Throwable $e) {
			throw new StorageException('Nie udało się pobrać notatki', 400, $e);
		}

		if(!$result) {
			throw new NotFoundException('Nie ma takiej notatki');
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
		}catch(Throwable $e) {
			throw new StorageException("Nie udało się zaktualizować danych");
		}
    }

    public function movePosition(string $table, array $params): PDOStatement {
		try {
			$table = $this->validateTable($table);
			return $this->runQuery("UPDATE $table SET position = :pos WHERE id = :id", $params);
		}catch (Throwable $e) {
			throw new StorageException("Nie udało się zmienić pozycji");
		}
		
	}

	public function getPostByPosition(string $table, int $position):array|bool {
		try{
			$table = $this->validateTable($table);
			return $this->runQuery("SELECT * FROM $table WHERE position = :pos", [':pos' => $position])->fetch(PDO::FETCH_ASSOC);
		}catch(Throwable $e) {
			throw new StorageException("Nie udałi się pobrać elementu");
		}
	}

	public function incrementPosition(string $table):void {
		try{
			$table = $this->validateTable($table);
			$this->runQuery("UPDATE $table SET position = position + 1");
		}catch(Throwable $e) {
			throw new StorageException("Nie udało się zmienić pozycji");
		}
	}

	public function decrementPosition(string $table, int $position) :void {
		try {
			$table = $this->validateTable($table);
			$this->runQuery("UPDATE $table set position = position - 1 WHERE position > :pos", [':pos' => $position]);
		}catch(Throwable $e) {

		}
	}

	public function delete(int $id, string $table) {
		$this->runQuery("DELETE FROM $table WHERE id = :id LIMIT 1", [":id" => $id]);
	}

	public function create(array $data, string $table): void {
		try {
			$table = $this->validateTable($table);
			$col = implode(", ", array_map(fn($k) => "$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
			$val = implode(", ", array_map(fn($k) => ":$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
			$result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);

			$sql = "INSERT INTO $table ($col) VALUES ($val)";

			$this->runQuery($sql,$result);
		}catch(Throwable $e) {
			throw new StorageException("Nie udało się utworzyć posta");
		}
	}

	public function published(array $data, string $table) {
		try {
			$table = $this->validateTable($table);
			$this->runQuery("UPDATE $table SET status = :published WHERE id = :id", [
				':published' => $data['published'],
				':id' => $data['id'],
			]);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się zmienić statusu');
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
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się dodać zdjęcia');
		}
	}
}