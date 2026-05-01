<?php

namespace App\Core;

class Validator
{
    private array $errors = [];

    public function getErrors(): array {
        return $this->errors;
    }

    public function validate(
        string $name,
        mixed $value,
        bool $required = false,
        string $type = 'string',
        ?int $minLength = null,
        ?int $maxLength = null,
    ): mixed {

        if ($required && ($value === null || $value === '')) {
            $this->errors[$name] = "To pole jest wymagane.";
            return null;
        }

        if($value !== null && $value !== '') {
            if ($type === 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$name] = "Podany adres email jest nieprawidłowy.";
                    return null;
                }
            } elseif ($type === 'int') {
                if (!is_numeric($value)) {
                    $this->errors[$name] = "Pole musi zawierać tylko liczby całkowite.";
                    return null;
                }
                $value = (int)$value;
            } else {
                $value = (string) $value;
            }

            if ($maxLength !== null && strlen((string)$value) > $maxLength) {
                $this->errors[$name] = "Długość pola nie może być większa niż $maxLength znaków.";
                return null;
            }

            if ($minLength !== null && strlen((string)$value) < $minLength) {
                $this->errors[$name] = "Długość pola musi być większa niż $minLength znaków.";
                return null;
            }
        }


        if ($type === 'int' && $value !== null && $value !== '') {
            return (int)$value;
        }

        return $value !== null ? (string)$value : null;
    }

    public function validateFile(
        string $field,
        ?array $file,
        array $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'],
        int $maxSize = 2_000_000,
    ): ?array
    {
        if (!$file || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $this->errors[$field] = "Plik nie został przesłany";
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[$field] = "Błąd przesyłania pliku";
            return null;
        }

        if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
            $this->errors[$field] = "Nieprawidłowy typ pliku";
            return null;
        }

        if ($file['size'] > $maxSize) {
            $this->errors[$field] = "Plik jest zbyt duży (max " . ($maxSize / 1_000_000) . " MB)";
            return null;
        }

        return $file;
    }
}