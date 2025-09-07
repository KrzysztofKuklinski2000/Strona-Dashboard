<?php 
declare(strict_types=1);

namespace App\Model;

use App\Model\AbstractModel;
use PDO;
use Throwable;
use App\Exception\StorageException;
use App\Exception\NotFoundException;


class DashboardModel extends AbstractModel {

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

	public function move(string $table, array $data):void {
		try {
			$this->con->beginTransaction();

			$table = $this->validateTable($table);
			// pobrać posta do przesunięcia 
			$currentPost = $this->getPost((int) $data["id"], $table);

			//pobrać post ktróry bedzie zamieniany zaleznie od dir
			$stmt = $this->runQuery(
				"SELECT * FROM $table WHERE position = :pos", 
				[':pos' => $data['dir'] === 'up' ? (int) $currentPost['position'] - 1 : (int) $currentPost['position'] + 1 ]
			)->fetch(PDO::FETCH_ASSOC);;
			
			if($stmt) {
				// zaktualizować nową pozycje dla aktualnego posta
				$this->runQuery(
					"UPDATE $table SET position = :pos WHERE id = :id", 
					[':pos'=> (int) $stmt['position'], ':id' => (int) $currentPost['id']]
				);
				// zaktualozować pozycje dla posta zamienianego 
				$this->runQuery(
					"UPDATE $table SET position = :pos WHERE id = :id", 
					[':pos'=> (int) $currentPost['position'], ':id' => (int) $stmt['id']]
				);
			}
			$this->con->commit();
		} catch(Throwable $e) {
			$this->con->rollBack();
			throw new StorageException("Nie udało się zmienić pozycji posta");
		}
	}

	public function create(array $data, string $table): void {
		try {
			$table = $this->validateTable($table);

			$this->con->beginTransaction();
			$this->runQuery("UPDATE $table SET position = position + 1");

			$col = implode(", ", array_map(fn($k) => "$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
			$val = implode(", ", array_map(fn($k) => ":$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
			$result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);

			$sql = "INSERT INTO $table ($col) VALUES ($val)";

			$this->runQuery($sql,$result);
			$this->con->commit();
		}catch(Throwable $e) {
			$this->con->rollBack();
			throw new StorageException('Nie udało się stworzyć notatki !!!', 400, $e);
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
			throw new StorageException('Nie udało się zmienić statusu posta', 400, $e);
		}
	}

	public function delete(int $id, string $table) {
		try {
			$this->con->beginTransaction();
			$table = $this->validateTable($table);

			$currenPost = $this->getPost($id, $table);

			$this->runQuery("DELETE FROM $table WHERE id = :id LIMIT 1", [":id" => $id]);

			$this->runQuery("UPDATE $table set position = position - 1 WHERE position > :pos", [':pos' => $currenPost['position']]);

			$this->con->commit();
		}catch(Throwable $e) {
			$this->con->rollBack();
			throw new StorageException('Nie udało się usunąć posta !!!', 400, $e);
		}
	}

	public function addImage(array $data): void {
		try {
			$this->con->beginTransaction();
			$imageName = NULL;

			if($data['image_name'] && $data['image_name']['error'] === 0) {
				$uploadDir = 'public/images/karate/';

				if(!is_dir($uploadDir)) {
					mkdir($uploadDir,0777, true);
				}

				$imageName = uniqid('karate_', true). '.'.pathinfo($data['image_name']['name'], PATHINFO_EXTENSION);
				$imagePath = $uploadDir . $imageName;

				if(!move_uploaded_file($data['image_name']['tmp_name'], $imagePath)) {
					throw new StorageException('Nie udało się przesłać obrazka');
				}

				$this->runQuery("UPDATE gallery SET position = position + 1");

				$this->runQuery(
					"INSERT INTO gallery (image_name, description, created_at, updated_at, category) VALUES(:image_name, :description, :created_at, :updated_at, :category)", 
				[
						":image_name" => $imageName,
						":description" => $data['description'],
						":created_at" => $data['created_at'],
						":updated_at" => $data['updated_at'],
						":category" => $data['category'],
						]);
			}
			$this->con->commit();
		}catch(Throwable $e) {
			$this->con->rollBack();
			throw new StorageException('Nie udało się dodać zdjęcia !!!');
		}
	}
}