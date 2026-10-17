<?php

declare(strict_types=1);

namespace App\Core;

use App\Exception\FileException;
use finfo;
use InvalidArgumentException;
use Random\RandomException;

readonly class FileHandler
{
    private const MIME_TO_EXTENSION = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
    ];
    private string $targetDir;

    public function __construct(
        private string $uploadDir,
        private string $filePrefix,
        private string $module = '',
    )
    {
        if ($module !== '' && !in_array($module, UploadPath::MODULES, true)) {
            throw new InvalidArgumentException('Nieprawidłowy katalog uploadów.');
        }

        $this->targetDir = rtrim($this->uploadDir, '/\\') . '/'
            . ($module !== '' ? $module . '/' : '');
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

        return $this->module !== '' ? $this->module . '/' . $imageName : $imageName;
    }

    /**
     * @throws FileException
     */
    public function deleteImage(string $imageName): void
    {
        if (!$this->acceptsImagePath($imageName)) {
            throw new FileException("Nieprawidłowa nazwa zdjęcia.");
        }

        // Stare uploady pozostają w katalogu głównym do czasu podmiany/usunięcia.
        $imagePath = rtrim($this->uploadDir, '/\\') . '/' . $imageName;

        if (!file_exists($imagePath)) {
            return;
        }

        if (!unlink($imagePath)) {
            throw new FileException('Nie udało się usunąć zdjęcia.');
        }
    }

    public function acceptsImagePath(string $path): bool
    {
        if (!UploadPath::isValid($path)) {
            return false;
        }

        return !str_contains($path, '/')
            || ($this->module !== '' && str_starts_with($path, $this->module . '/'));
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
