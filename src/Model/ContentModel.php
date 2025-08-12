<?php 
declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use PDOException;
use PDOStatement;
use App\Exception\StorageException;


class ContentModel {

	protected PDO $con;
	private const ALLOWED_TABLES = ['news', 'contact', 'fees', 'camp', 'user', 'timetable', 'important_posts', 'main_page_posts'];

	public function __construct(array $config) {
		try {
			$dns = "mysql:dbname={$config['database']};host={$config['host']}";
			$this->con = new PDO($dns, $config['user'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
		}catch(PDOException $e){
			throw new StorageException('Connection Error');
		}
	}

	public function runQuery(string $sql, array $params = []): PDOStatement
	{
		$stmt = $this->con->prepare($sql);

		foreach ($params as $key => $value) {
			if (is_array($value)) {
				$stmt->bindValue($key, $value[0], $value[1]);
			} else {
				$stmt->bindValue($key, $value, PDO::PARAM_STR);
			}
		}

		$stmt->execute();
		return $stmt;
	}

	protected function validateTable(string $table): string {
		if(!in_array($table, self::ALLOWED_TABLES)){
			throw new StorageException("Nie ma takiej tabeli");
		}

		return $table;
	}

	public function getData(string $table, string $orderBy, ?int $page = 1): array
	{
		try {
			$table = $this->validateTable($table);
			$orderBy = strtoupper($orderBy);

			if (!in_array($orderBy, ['ASC', 'DESC'])) {
				$orderBy = 'ASC';
			}

			$totalRecords = $this->countData($table);
			$perPage = 10;
			$totalPages = max(ceil($totalRecords / $perPage), 1);
			$page = max(min($page, $totalPages), 1);
			$offset = ($page - 1) * $perPage;

			$sql = "SELECT * FROM $table";
			if (!in_array($table, ['contact', 'fees', 'camp'])) {
				$sql .= " ORDER BY id $orderBy";
			}

			// Limit i offset tylko dla news 
			if ($table === "news") {
				$sql .= " LIMIT :limit OFFSET :offset";
				return $this->runQuery($sql, [
					':limit' => [$perPage, PDO::PARAM_INT], 
					':offset' => [$offset, PDO::PARAM_INT]
				])->fetchAll(PDO::FETCH_ASSOC);
			}

			return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
		}
		//  catch (Throwable $e) {
		// 	echo "DEBUG: " . $e->getMessage();
		// 	echo "<br>SQL: " . ($sql ?? '');
		// 	echo "<br>Params: " . print_r(($params ?? []), true);
		// 	exit;
		// 	throw new StorageException("Nie udało się pobrać danych", 500, $e);
		// }
		catch (Throwable $e) {
			throw new StorageException("Nie udało się pobrać danych", 500, $e);
		}
	}


	public function countData(string $table): int {
		$table = $this->validateTable($table);
		$stmt = $this->runQuery("SELECT COUNT(*) FROM $table");
		return (int) $stmt->fetchColumn();
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

			return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
		} catch (Throwable $e) {
			throw new StorageException('Nie udało się załadować zawartości strony.', 400, $e);
		}
	}
}