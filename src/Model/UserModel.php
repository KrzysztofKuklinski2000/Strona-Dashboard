<?php 
declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use App\Model\AbstractModel;
use App\Exception\StorageException;

class UserModel extends AbstractModel {
  public function getUser(string $login) {
    try {
      $stmt = $this->runQuery("SELECT * FROM user WHERE login = :login LIMIT 1", [":login" => $login]);
      return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }catch(Throwable $e) {
      throw new StorageException("Nie udało się pobrać użytkownika");
    }
  }
}