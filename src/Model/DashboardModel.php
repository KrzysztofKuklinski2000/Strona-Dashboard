<?php 
declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use App\Model\ContentModel;


class DashboardModel extends ContentModel {

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

	public function edit(array $data, string $table): void {
		try {
			$table = $this->validateTable($table);

			$this->runQuery("UPDATE $table SET title = :title, description = :description, updated = :updated WHERE id = :id", [
				":title" => $data['title'],
				":description" => $data['description'],
				":updated" => $data['date'],
				":id" => $data['id'],
			]);
 		}catch(Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować posta');
		} 
	}

	public function create(array $data, string $table): void {
		try {
			$table = $this->validateTable($table);

			$this->runQuery(
				"INSERT INTO $table (title, description, created, updated, status) 
				VALUES (:title, :description, :created, :updated, :status)", [
				":title" => $data['title'],
				":description" => $data['description'],
				":created" => $data['created'],
				":updated" => $data['updated'],
				":status" => 1,
			]);
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
			$this->runQuery("DELETE FROM $table WHERE id = $id LIMIT 1", [":id" => $id]);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się usunąć posta !!!', 400, $e);
		}
	}

	public function editCamp(array $data): void {
		try {
			$this->runQuery("UPDATE camp SET city = :city, city_start = :cityStart, date_start = :dateStart, date_end = :dateEnd, time_start = :timeStart,time_end = :timeEnd, place = :place, accommodation = :accommodation, meals = :meals, trips = :trips, staff = :staff, transport = :transport,training = :training, insurance = :insurance, cost = :cost, advancePayment = :advancePayment, advanceDate = :advanceDate, guesthouse = :guesthouse", 
			[
					":city" => $data['city'],
					":cityStart" => $data['townStart'],
					":dateStart" => $data['dateStart'],
					":dateEnd" => $data['dateEnd'],
					":timeStart" => $data['timeStart'],
					":timeEnd" => $data['timeEnd'],
					":place" => $data['place'],
					":accommodation" => $data['accommodation'],
					":meals" => $data['meals'],
					":trips" => $data['trips'],
					":staff" => $data['staff'],
					":transport" => $data['transport'],
					":training" => $data['training'],
					":insurance" => $data['insurance'],
					":cost" => $data['cost'],
					":advancePayment" => $data['advancePayment'],
					":advanceDate" => $data['advanceDate'],
					":guesthouse" => $data['guesthouse'],
			]);
		} catch (Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować danych !', 400, $e);
		}
	}

	public function editFees(array $data): void {
		try {
			$this->runQuery("UPDATE fees SET reduced_contribution_1_month =  :reduced_contribution_1_month, reduced_contribution_2_month = :reduced_contribution_2_month, family_contribution_month = :family_contribution_month, contribution = :contribution, entry_fee = :entry_fee, reduced_contribution_1_year = :reduced_contribution_1_year, reduced_contribution_2_year = :reduced_contribution_2_year, family_contribution_year = :family_contribution_year, reduced_contribution_holidays = :reduced_contribution_holidays, extra_information = :extra_information", 
			[
					":reduced_contribution_1_month" => $data['fees1'],
					":reduced_contribution_2_month" => $data['fees2'],
					":family_contribution_month" => $data['fees3'],
					":contribution" => $data['fees4'],
					":entry_fee" => $data['fees5'],
					":reduced_contribution_1_year" => $data['fees6'],
					":reduced_contribution_2_year" => $data['fees7'],
					":family_contribution_year" => $data['fees8'],
					":reduced_contribution_holidays" => $data['fees9'],
					":extra_information" => $data['fees10'],
			]);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować danych !', 400, $e);
		}
	}

	public function editContact(array $data): void {
		try {
			$this->runQuery("UPDATE contact SET email = :email, phone = :phone, address = :address", [
				":email" => $data['email'],
				":phone" => $data['phone'],
				":address" => $data['address'],
			]);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować danych !', 400, $e);
		}
	}

	public function	addDayToTimetable(array $data): void {
		try {
				$this->runQuery(
					"INSERT INTO timetable (day, city, advancement_group, place, start, end) 
					VALUES(:day, :city, :group, :place, :startTime, :endTime)", [
					":day" => $data['day'],
					":city" => $data['city'],
					":group" => $data['group'],
					":place" => $data['place'],
					":startTime" => $data['startTime'],
					":endTime" => $data['endTime']
				]);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się dodać danych !', 400, $e);
		}
	}

	public function	editTimetable(array $data): void
	{
		try {
			$this->runQuery("UPDATE timetable SET day = :day, city = :city, advancement_group = :group, place = :place, start = :startTime, end = :endTime WHERE id = :id", [
				":day" => $data['day'],
				":city" => $data['city'],
				":advancement_group" => $data['group'],
				":place" => $data['place'],
				":startTime" => $data['startTime'],
				":endTime" => $data['endTime'],
				":id" => $data['id']
			]);
			
		} catch (Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować Notatki !', 400, $e);
		}
	}
}