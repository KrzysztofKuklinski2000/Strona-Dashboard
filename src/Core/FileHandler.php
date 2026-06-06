<?php
declare(strict_types=1);

namespace App\Core;

use App\Exception\FileException;
use finfo;
use Random\RandomException;

readonly class FileHandler
{
    private const MIME_TO_EXTENSION = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
    ];
    private string $targetDir;

    public function __construct(private string $uploadDir, private string $filePrefix)
    {
        $this->targetDir = rtrim($this->uploadDir, '/') . '/';
    }

    /**
     * @throws FileException
     */
    public function uploadImage(array $file): string
    {
        $this->ensureDirectoryExists();

        if (!isset($file['error'], $file['tmp_name'], $file['name'])) {
            throw new FileException("Nieprawidłowe dane pliku.");
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new FileException('Błąd podczas przesyłania pliku.');
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new FileException('Nieprawidłowy plik tymczasowy.');
        }

        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);

        if (!isset(self::MIME_TO_EXTENSION[$mime])) {
            throw new FileException('Nieprawidłowy typ pliku.');
        }

        try {
            $imageName = $this->filePrefix . bin2hex(random_bytes(16)) . '.' . self::MIME_TO_EXTENSION[$mime];
        } catch (RandomException $e) {
            throw new FileException('Nie udało się wygenerować nazwy pliku.', 0, $e);
        }

        $imagePath = $this->targetDir . $imageName;

        if (!move_uploaded_file($file['tmp_name'], $imagePath)) {
            throw new FileException('Nie udało się przesłać obrazka');
        }

        chmod($imagePath, 0644);

        return $imageName;
    }

    /**
     * @throws FileException
     */
    private function ensureDirectoryExists(): void
    {
        if (!is_dir($this->targetDir) && !mkdir($this->targetDir, 0755, true)) {
            throw new FileException('Błąd serwera: katalog uploadów nie istnieje.');
        }
    }
}