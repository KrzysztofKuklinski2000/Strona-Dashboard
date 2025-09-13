<?php 
declare(strict_types=1);

namespace App\Exception;

use Throwable;

class StorageException extends AppException 
{
    public const DATABASE_CONNECTION_ERROR = 1001;
    public const QUERY_EXECUTION_ERROR = 1002;
    public const DATA_NOT_FOUND = 1003;
    public const VALIDATION_ERROR = 1004;
    public const TRANSACTION_ERROR = 1005;
    public const FILE_UPLOAD_ERROR = 1006;
    public const FILE_SAVE_ERROR = 1007;

    public static function databaseConnection(
        string $details = '', 
        ?Throwable $previous = null
    ): self {
        return new self(
            "Database connection failed: $details",
            self::DATABASE_CONNECTION_ERROR,
            $previous,
            ['operation' => 'database_connection'],
            'Przepraszamy, wystąpił problem z połączeniem. Spróbuj ponownie.'
        );
    }

    public static function queryFailed(
        string $operation, 
        ?Throwable $previous = null,
        array $context = []
    ): self {
        return new self(
            "Database query failed during: $operation",
            self::QUERY_EXECUTION_ERROR,
            $previous,
            array_merge(['operation' => $operation], $context),
            'Nie udało się wykonać operacji. Spróbuj ponownie.'
        );
    }

    public static function dataNotFound(string $entity, mixed $identifier = null): self
    {
        $context = ['entity' => $entity];
        if ($identifier !== null) {
            $context['identifier'] = $identifier;
        }

        return new self(
            "Data not found for entity: $entity",
            self::DATA_NOT_FOUND,
            null,
            $context,
            'Nie znaleziono żądanych danych.'
        );
    }

    public static function fileUpload(string $details, array $fileInfo = []): self
    {
        return new self(
            "File upload failed: $details",
            self::FILE_UPLOAD_ERROR,
            null,
            ['file_info' => $fileInfo],
            'Nie udało się przesłać pliku. Sprawdź czy plik jest poprawny.'
        );
    }

    public static function transactionFailed(
        string $operation, 
        ?Throwable $previous = null
    ): self {
        return new self(
            "Transaction failed during: $operation",
            self::TRANSACTION_ERROR,
            $previous,
            ['operation' => $operation],
            'Nie udało się wykonać operacji. Dane nie zostały zmienione.'
        );
    }
}