<?php
declare(strict_types=1);

namespace App\Traits;

use PDO;
use Throwable;
use App\Exception\StorageException;

trait TransactionManager
{
    abstract public function getConnection(): PDO;

    /**
     * Wykonuje operację w transakcji z automatycznym rollback w przypadku błędu
     */
    protected function executeInTransaction(callable $operation): mixed
    {
        $connection = $this->getConnection();
        
        $connection->beginTransaction();
        
        try {
            $result = $operation();
            $connection->commit();
            return $result;
            
        } catch (Throwable $e) {
            $connection->rollBack();
            
            if ($e instanceof StorageException) {
                throw $e;
            }
            
            throw StorageException::transactionFailed(
                'Transaction execution failed',
                $e
            );
        }
    }

    /**
     * Sprawdza czy transakcja jest aktywna
     */
    protected function isInTransaction(): bool
    {
        return $this->getConnection()->inTransaction();
    }

    /**
     * Bezpieczne rozpoczęcie transakcji (jeśli nie jest już aktywna)
     */
    protected function safeBeginTransaction(): bool
    {
        if (!$this->isInTransaction()) {
            return $this->getConnection()->beginTransaction();
        }
        return true;
    }

    /**
     * Bezpieczne zakończenie transakcji
     */
    protected function safeCommit(): bool
    {
        if ($this->isInTransaction()) {
            return $this->getConnection()->commit();
        }
        return true;
    }

    /**
     * Bezpieczny rollback
     */
    protected function safeRollback(): bool
    {
        if ($this->isInTransaction()) {
            return $this->getConnection()->rollBack();
        }
        return true;
    }
}