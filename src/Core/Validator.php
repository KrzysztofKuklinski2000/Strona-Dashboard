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

        if (is_string($value)) {
            $value = trim($value);
        }

        if ($required && ($value === null || $value === '')) {
            $this->errors[$name] = 'To pole jest wymagane.';
            return null;
        }

        if ($value === null || $value === '') {
            return null;
        }

        if (!is_scalar($value)) {
            $this->errors[$name] = 'Nieprawidłowa wartość pola.';
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
            $value = (string) $value;
        }

        if ($maxLength !== null && mb_strlen((string) $value, 'UTF-8') > $maxLength) {
            $this->errors[$name] = "Długość pola nie może być większa niż $maxLength znaków.";
            return null;
        }

        if ($minLength !== null && mb_strlen((string) $value, 'UTF-8') < $minLength) {
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
        bool $required = true,
    ): ?array {
        if ($file === null) {
            if ($required) {
                $this->errors[$field] = 'Plik nie został przesłany.';
            }

            return null;
        }

        if (!isset($file['error'])) {
            $this->errors[$field] = 'Nieprawidłowe dane pliku.';
            return null;
        }

        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            if ($required) {
                $this->errors[$field] = 'Plik nie został przesłany.';
            }

            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $maxSizeMb = $maxSize / 1_000_000;

            $this->errors[$field] = match ((int) $file['error']) {
                UPLOAD_ERR_INI_SIZE,
                UPLOAD_ERR_FORM_SIZE => "Plik jest zbyt duży. Maksymalny rozmiar to $maxSizeMb MB.",

                UPLOAD_ERR_PARTIAL => 'Plik został przesłany tylko częściowo. Spróbuj ponownie.',

                UPLOAD_ERR_NO_TMP_DIR,
                UPLOAD_ERR_CANT_WRITE,
                UPLOAD_ERR_EXTENSION => 'Nie udało się zapisać pliku na serwerze.',

                default => 'Nie udało się przesłać pliku. Spróbuj ponownie.',
            };

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
