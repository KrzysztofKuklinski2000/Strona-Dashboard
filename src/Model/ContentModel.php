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

	public function getData(string $table):array {
		try {
			$sql = "SELECT * FROM $table";
			$result = $this->con->query($sql);

			return $result->fetchAll(PDO::FETCH_ASSOC);
		}catch(Throwable $e) {
			throw new StorageException("Nie udało się pobrać danych");
		}
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

	// public function newsPageData():array {
	// 	try {
	// 		$sql = "SELECT id, title, description, created, status FROM news";
	// 		$result  = $this->con->query($sql);
			
	// 		return $result->fetchAll(PDO::FETCH_ASSOC);
	// 	}catch (Throwable $e){
	// 		throw new StorageException('Nie udało się załadować zawartości strony .', 400, $e);
	// 	}
	// }

	// public function mainPageData(): array {
	// 	try {
	// 		return [$this->getData("main_page_posts"), $this->getData("important_posts")];
	// 	}catch(Throwable $e) {
	// 		throw new StorageException('Nie udało się załadować zawartości strony.', 400, $e);
	// 	}
	// }

	// public function feesPageData(): array {
	// 	try{
	// 		$sql = "SELECT * FROM fees";
	// 		$result = $this->con->query($sql);

	// 		return $result->fetch(PDO::FETCH_ASSOC);
	// 	}catch(Throwable $e) {
	// 		throw new StorageException("Nie udało się załadować zawartości strony.", 400, $e);
	// 	}
	// }

	// public function contactPageData(): array {
	// 	try {
	// 		$sql = "SELECT * FROM contact";
	// 		$result = $this->con->query($sql);

	// 		return $result->fetch(PDO::FETCH_ASSOC);
	// 	}catch(Throwable $e) {
	// 		throw new StorageException('Nie udało się załadować zawartości strony.', 400, $e);
	// 	}
	// }

	// public function campPageData(): array {
	// 	try {
	// 		$sql = "SELECT * FROM camp";
	// 		$result = $this->con->query($sql);

	// 		return $result->fetch(PDO::FETCH_ASSOC);
	// 	}catch(Throwable $e) {
	// 		throw new StorageException('Nie udało się załadować zawartości strony.', 400, $e);
	// 	}
	// }

	// public function importantPostsPageData(): array {
	// 	try {
	// 		$sql = "SELECT * FROM important_posts ORDER BY updated DESC";
	// 		$result = $this->con->query($sql);

	// 		return $result->fetchAll(PDO::FETCH_ASSOC);
	// 	}catch(Throwable $e) {
	// 		throw new StorageException('Nie udało się załadować zawartości strony', 400, $e);
	// 	}
	// }
}