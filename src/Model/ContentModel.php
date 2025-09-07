<?php 
declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use App\Model\AbstractModel;
use App\Exception\StorageException;


class ContentModel extends AbstractModel {

	public function getData(string $table, string $orderBy, ?int $page = 1, ?string $category=null): array
	{
		try {
			$table = $this->validateTable($table);
			$orderBy = strtoupper($orderBy);

			if (!in_array($orderBy, ['ASC', 'DESC'])) {
				$orderBy = 'ASC';
			}

			$perPage = 10;
			$totalPages = ceil($this->countData($table) / $perPage);
			$page = max(1, min($page, $totalPages));
			$offset = ($page-1) * $perPage;

			$sql = "SELECT * FROM $table";

			if (in_array($table, ['news', 'main_page_posts', 'important_posts', 'timetable'])) {
				$sql .= " WHERE status=1";
			}

			if($table === "gallery" && in_array($category, ['traning', 'camp']) ){
				$sql .= " WHERE status=1 AND category = '$category'";
			}elseif ($table === "gallery" && !$category){
				$sql .= " WHERE status=1";
			}

			if (!in_array($table, ['contact', 'fees', 'camp'])) {
				$sql .= " ORDER BY position $orderBy";
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
		catch (Throwable $e) {
			throw new StorageException("Nie udało się pobrać danych", 500, $e);
		}
	}


	public function countData(string $table): int {
		$table = $this->validateTable($table);
		$stmt = $this->runQuery("SELECT COUNT(*) FROM $table");
		return (int) $stmt->fetchColumn();
	}
}