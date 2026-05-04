<?php 
declare(strict_types= 1); 
namespace App\Core;

use App\Exception\FileException;

readonly class FileHandler {
    public function __construct(private string $uploadDir) {}

    /**
     * @throws FileException
     */
    public function uploadImage(array $file): string {
            if (!isset($file['error']) || !isset($file['tmp_name']) || !isset($file['name'])) {
                throw new FileException("Nieprawidłowe dane pliku.");
            }
            
            if($file['error'] !== 0) {
                throw new FileException("Błąd podczas przesyłania pliku");
            }

            $dir = rtrim($this->uploadDir, '/') . '/';

            if(!is_dir($dir)) {
                mkdir($dir,0755, true);
            }

            $imageName = uniqid('karate_', true). '.'.pathinfo($file['name'], PATHINFO_EXTENSION);
            $imagePath = $dir . $imageName;
            if(!move_uploaded_file($file['tmp_name'], $imagePath)) {
                throw new FileException('Nie udało się przesłać obrazka');
            }

        return $imageName;
    }
}