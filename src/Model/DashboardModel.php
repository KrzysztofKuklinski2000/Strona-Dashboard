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
			if(!in_array($table, ['contact', 'fees', 'camp'])) $sql .= " ORDER BY id DESC";
			
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

			if(in_array($table, ['news', 'main_page_posts', 'important_posts', 'timetable'])) $sql .= " WHERE id = :id";
			$result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);

			$this->runQuery($sql, $result);
		}catch(Throwable $e) {
			throw new StorageException("Nie udało się zaktualizować danych");
		}
	}

	public function create(array $data, string $table): void {
		try {
			$table = $this->validateTable($table);
			$col = implode(", ", array_map(fn($k) => "$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
			$val = implode(", ", array_map(fn($k) => ":$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
			$result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);
			
			$sql = "INSERT INTO $table ($col) VALUES ($val)";
			echo $sql."<br>";
			print_r($result);
			exit;

			$this->runQuery($sql,$result);
		}catch(Throwable $e) {
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
			$table = $this->validateTable($table);
			$this->runQuery("DELETE FROM $table WHERE id = :id LIMIT 1", [":id" => $id]);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się usunąć posta !!!', 400, $e);
		}
	}
}