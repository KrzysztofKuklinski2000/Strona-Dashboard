<?php

namespace App\Repository;

use App\Exception\RepositoryException;
use PDO;


class SubscriberRepository extends AbstractRepository {
  public function getActiveEmails(): array {
    try {
      $stmt = $this->runQuery("SELECT email FROM subscribers WHERE is_active = 1");
      return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    } catch (RepositoryException $e) {
      throw new RepositoryException("Nie udało się pobrać subskrybentów", 500, $e);
    }
  }
}