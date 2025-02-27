<?php 
declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use PDOException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use App\Model\ContentModel;


class DashboardModel extends ContentModel {

	public function getPost(int $id, string $table): array {
		try {
			$sql = "SELECT * FROM $table WHERE id = $id";
			$result = $this->con->query($sql);
			$result = $result->fetch(PDO::FETCH_ASSOC); 
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
			$id = $data['id'];
			$title = $this->con->quote($data['title']);
			$description = $this->con->quote($data['description']);
			$date = $data['date'];

			$sql = "UPDATE $table SET title = $title, description = $description, updated = '$date' WHERE id = $id";

			$this->con->exec($sql);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować posta');
		} 
	}

	public function create(array $data, string $table): void {
		try {
			$title = $this->con->quote($data['title']);
			$description = $this->con->quote($data['description']);
			$date = $data['date'];

			$sql = "INSERT INTO $table (title, description, created, updated, status) VALUES ($title, $description, '$date', '$date', 1) ";
			$this->con->exec($sql);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się stworzyć notatki !!!', 400, $e);
		}
	}

	public function published(array $data, string $table) {
		try {
			$published = $data['published'];
			$id = $data['id'];

			$sql = "UPDATE $table SET status = $published WHERE id = $id";

			$this->con->exec($sql);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się zmienić statusu posta', 400, $e);
		}
	}

	public function delete(int $id, string $table) {
		try {
			$sql = "DELETE FROM $table WHERE id = $id LIMIT 1";
			$this->con->exec($sql);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się usunąć posta !!!', 400, $e);
		}
	}

	public function editCamp(array $data): void {
		try {
			$city = $this->con->quote($data['city']);
			$cityStart = $this->con->quote($data['townStart']);
			$guesthouse = $this->con->quote($data['guesthouse']);
			$dateStart = $this->con->quote($data['dateStart']);
			$dateEnd = $this->con->quote($data['dateEnd']);
			$timeStart = $this->con->quote($data['timeStart']);
			$timeEnd = $this->con->quote($data['timeEnd']);
			$place = $this->con->quote($data['place']);
			$accommodation = $this->con->quote($data['accommodation']);
			$meals = $this->con->quote($data['meals']);
			$trips = $this->con->quote($data['trips']);
			$staff = $this->con->quote($data['staff']);
			$transport = $this->con->quote($data['transport']);
			$training = $this->con->quote($data['training']);
			$insurance = $this->con->quote($data['insurance']);
			$cost = $this->con->quote($data['cost']);
			$advancePayment = $this->con->quote($data['advancePayment']);
			$advanceDate = $this->con->quote($data['advanceDate']);

			$sql = "UPDATE camp SET city = $city, city_start = $cityStart, date_start = $dateStart, date_end = $dateEnd, time_start = $timeStart,time_end = $timeEnd, place = $place, accommodation = $accommodation, meals = $meals, trips = $trips, staff = $staff, transport = $transport,training = $training, insurance = $insurance, cost = $cost, advancePayment = $advancePayment, advanceDate = $advanceDate, guesthouse = $guesthouse";

			$this->con->exec($sql);
		} catch (Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować danych !', 400, $e);
		}
	}

	public function editFees(array $data): void {
		try {
			$fees1 = $data['fees1'];
			$fees2 = $data['fees2'];
			$fees3 = $data['fees3'];
			$fees4 = $data['fees4'];
			$fees5 = $data['fees5'];
			$fees6 = $data['fees6'];
			$fees7 = $data['fees7'];
			$fees8 = $data['fees8'];
			$fees9 = $this->con->quote($data['fees9']);

			$sql = "UPDATE fees SET reduced_contribution_1_month =  $fees1, reduced_contribution_2_month = $fees2, family_contribution_month = $fees3, contribution = $fees4, entry_fee = $fees5, reduced_contribution_1_year = $fees6, reduced_contribution_2_year = $fees7, family_contribution_year = $fees8, reduced_contribution_holidays = $fees9";

			$this->con->exec($sql);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować danych !', 400, $e);
		}
	}

	public function editContact(array $data): void {
		try {
			$email = $this->con->quote($data['email']);
			$phone = $this->con->quote($data['phone']);
			$address = $this->con->quote($data['address']);

			$sql = "UPDATE contact SET email = $email, phone = $phone, address = $address";
			$this->con->exec($sql);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować danych !', 400, $e);
		}
	}

	public function	addDayToTimetable(array $data): void {
		try {
				$day = $this->con->quote($data['day']);
				$city = $this->con->quote($data['city']);
				$group = $this->con->quote($data['group']);
				$place = $this->con->quote($data['place']);
				$startTime = $this->con->quote($data['startTime']);
				$endTime = $this->con->quote($data['endTime']);

				$sql = "INSERT INTO timetable (day, city, advancement_group, place, start, end) VALUES($day, $city, $group, $place, $startTime, $endTime)";
				$this->con->exec($sql);
		}catch(Throwable $e) {
			throw new StorageException('Nie udało się dodać danych !', 400, $e);
		}
	}

	public function	editTimetable(array $data): void
	{
		try {
			$id = $data['id'];
			$day = $this->con->quote($data['day']);
			$city = $this->con->quote($data['city']);
			$group = $this->con->quote($data['group']);
			$place = $this->con->quote($data['place']);
			$startTime = $this->con->quote($data['startTime']);
			$endTime = $this->con->quote($data['endTime']);

			$sql = "UPDATE timetable SET 
							day = $day, 
							city = $city, 
							advancement_group = $group,
							place = $place,
							start = $startTime, 
							end = $endTime
							WHERE id = $id";
			$this->con->exec($sql);
		} catch (Throwable $e) {
			throw new StorageException('Nie udało się zaktualizować Notatki !', 400, $e);
		}
	}
}