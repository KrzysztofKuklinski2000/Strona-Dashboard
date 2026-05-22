<?php 
declare(strict_types= 1);
namespace App\Repository;

use App\DTO\Auth\UserCredentialsDto;
use App\Exception\RepositoryException;
use PDO;

class AuthRepository extends AbstractRepository {

    /**
     * @throws RepositoryException
     */
    public function getUser(string $login): ?UserCredentialsDto {
    try {
      $stmt = $this->runQuery("SELECT * FROM user WHERE login = :login LIMIT 1", [":login" => $login]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);


      return $result ? UserCredentialsDto::fromArray($result) : null;
    }catch(RepositoryException $e) {
      throw new RepositoryException("Nie udało się pobrać użytkownika", 500 , $e);
    }
  }
}