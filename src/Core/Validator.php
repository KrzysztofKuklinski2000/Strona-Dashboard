<?php

namespace App\Core;

class Validator
{
    private array $errors = [];

    public function getErrors(): array {
        return $this->errors;
    }

    public function addError(string $name, string $message): void
    {
        $this->errors[$name] = $message;
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
            $this->errors[$name] = 'To pole jest wymagane.';
            return null;
        }

        if ($value === null || $value === '') {
            return null;
        }

        if ($type === 'email') {
            $value = filter_var($value, FILTER_VALIDATE_EMAIL);

            if ($value === false) {
                $this->errors[$name] = 'Podany adres email jest nieprawidłowy.';
                return null;
            }
        } elseif ($type === 'int') {
            $value = filter_var($value, FILTER_VALIDATE_INT);

            if ($value === false) {
                $this->errors[$name] = 'Pole musi zawierać liczbę całkowitą.';
                return null;
            }
        } else {
            $value = trim((string) $value);
        }

        if ($maxLength !== null && strlen((string) $value) > $maxLength) {
            $this->errors[$name] = "Długość pola nie może być większa niż $maxLength znaków.";
            return null;
        }

        if ($minLength !== null && strlen((string) $value) < $minLength) {
            $this->errors[$name] = "Długość pola musi być większa niż $minLength znaków.";
            return null;
        }

        return $value;
    }

    public function validateFile(
        string $field,
        ?array $file,
        array $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'],
        int $maxSize = 2_000_000,
    ): ?array {
        if (!$file || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $this->errors[$field] = 'Plik nie został przesłany.';
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[$field] = 'Błąd przesyłania pliku.';
            return null;
        }

        if (!isset($file['tmp_name'], $file['size']) || !is_uploaded_file($file['tmp_name'])) {
            $this->errors[$field] = 'Nieprawidłowy plik.';
            return null;
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);

        if (!in_array($mime, $allowedTypes, true)) {
            $this->errors[$field] = 'Nieprawidłowy typ pliku.';
            return null;
        }

        if ($file['size'] > $maxSize) {
            $this->errors[$field] = 'Plik jest zbyt duży (max ' . ($maxSize / 1_000_000) . ' MB).';
            return null;
        }

        return $file;
    }
}
