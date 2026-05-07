<?php
declare(strict_types=1);

namespace App\Core;

use App\Exception\FileException;

readonly class FileHandler
{
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

        if (!isset($file['error']) || !isset($file['tmp_name']) || !isset($file['name'])) {
            throw new FileException("Nieprawidłowe dane pliku.");
        }

        if ($file['error'] !== 0) {
            throw new FileException("Błąd podczas przesyłania pliku");
        }

        $imageName = uniqid($this->filePrefix, true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $imagePath = $this->targetDir . $imageName;

        if (!move_uploaded_file($file['tmp_name'], $imagePath)) {
            throw new FileException('Nie udało się przesłać obrazka');
        }

        return $imageName;
    }

    /**
     * @throws FileException
     */
    private function ensureDirectoryExists(): void
    {
        if (!is_dir($this->targetDir)) {
            if (!@mkdir($this->targetDir, 0777, true) && !is_dir($this->targetDir)) {
                throw new FileException("Błąd serwera: Katalog na zdjęcia nie istnieje.");
            }
        }
    }
}