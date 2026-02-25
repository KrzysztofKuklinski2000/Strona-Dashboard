<?php

namespace App\Repository;

use App\Exception\RepositoryException;
use PDO;


class SubscriberRepository extends AbstractRepository {
  public function getAllEmails(): array {
    try {
      $stmt = $this->runQuery("SELECT email FROM subscribers");
      return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    } catch (RepositoryException $e) {
      throw new RepositoryException("Nie udało się pobrać subskrybentów", 500, $e);
    }
  }
}