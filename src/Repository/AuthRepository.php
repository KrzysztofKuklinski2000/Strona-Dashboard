<?php 
declare(strict_types= 1);
namespace App\Repository;

use PDO;
use Throwable;
use App\Exception\StorageException;

class AuthRepository extends AbstractRepository {

    public function getUser(string $login):array {
        try {
          $stmt = $this->runQuery("SELECT * FROM user WHERE login = :login LIMIT 1", [":login" => $login]);
          return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        }catch(Throwable $e) {
          throw new StorageException("Nie udało się pobrać użytkownika", 500 , $e);
        }
      }
}