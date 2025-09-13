<?php 
declare(strict_types= 1); 
namespace App\Core;

use App\Exception\FileException;

class FileHandler {
    private const UPLOAD_DIR = 'public/images/karate/';

    public function uploadImage(array $file): string {
            if($file['error'] !== 0) {
                throw new FileException("Błąd podczas przesyłania pliku");
            }

            if(!is_dir(self::UPLOAD_DIR)) {
                mkdir(self::UPLOAD_DIR,0777, true);
            }

            $imageName = uniqid('karate_', true). '.'.pathinfo($file['name'], PATHINFO_EXTENSION);
            $imagePath = self::UPLOAD_DIR . $imageName;
            if(!move_uploaded_file($file['tmp_name'], $imagePath)) {
                throw new FileException('Nie udało się przesłać obrazka');
            }

        return $imageName;
    }
}