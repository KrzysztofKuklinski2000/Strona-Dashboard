<?php 
declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use PDOException;
use App\Exception\StorageException;


class ContentModel {

	protected PDO $con;

	public function __construct(array $config) {
		try {
			$dns = "mysql:dbname={$config['database']};host={$config['host']}";
			$this->con = new PDO($dns, $config['user'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
		}catch(PDOException $e){
			throw new StorageException('Connection Error');
		}
	}

	public function getData(string $table, ?int $page=1):array {
		try {
			if($page >= ceil($this->countData('news') / 10)) {
				$page = ceil($this->countData('news') / 10)-1;
			}
			elseif($page < 1) $page = 0;

			$sql = "SELECT * FROM $table";
			$page *= 10;
			if($table === "news") $sql .= " LIMIT 10 OFFSET $page";
			$result = $this->con->query($sql);
			$result = $result->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}catch(Throwable $e) {
			throw new StorageException("Nie udało się pobrać danych");
		}
	}

	public function countData(string $table): int {
		$result = $this->con->query("SELECT COUNT(*) FROM $table");
		return (int) $result->fetchColumn();
	}

	public function timetablePageData(): array
	{
		try {
			$sql = "
				SELECT * FROM timetable ORDER BY 
					CASE 
						WHEN day = 'PON' THEN 1
						WHEN day = 'WT' THEN 2
						WHEN day = 'ŚR' THEN 3
						WHEN day = 'CZW' THEN 4
						WHEN day = 'PT' THEN 5
						WHEN day = 'SOB' THEN 6
					END ASC, start ASC";

			$result = $this->con->query($sql);
			return $result->fetchAll(PDO::FETCH_ASSOC);
		} catch (Throwable $e) {
			throw new StorageException('Nie udało się załadować zawartości strony.', 400, $e);
		}
	}
}