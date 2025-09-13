<?php 
declare(strict_types=1);

namespace App\Exception;

class ValidationException extends AppException
{
    public const INVALID_INPUT = 3001;
    public const MISSING_REQUIRED_FIELD = 3002;
    public const INVALID_FORMAT = 3003;
    public const CSRF_TOKEN_INVALID = 3004;

    private array $validationErrors = [];

    public function __construct(
        string $message = '', 
        int $code = 0, 
        ?\Throwable $previous = null,
        array $context = [],
        string $userMessage = '',
        array $validationErrors = []
    ) {
        parent::__construct($message, $code, $previous, $context, $userMessage);
        $this->validationErrors = $validationErrors;
    }

    public static function invalidInput(
        string $field, 
        string $reason, 
        mixed $value = null
    ): self {
        return new self(
            "Invalid input for field '$field': $reason",
            self::INVALID_INPUT,
            null,
            ['field' => $field, 'value' => $value, 'reason' => $reason],
            "Niepoprawna wartość w polu: $field",
            [$field => $reason]
        );
    }

    public static function missingField(string $field): self
    {
        return new self(
            "Required field missing: $field",
            self::MISSING_REQUIRED_FIELD,
            null,
            ['field' => $field],
            "Pole '$field' jest wymagane.",
            [$field => 'Pole jest wymagane']
        );
    }

    public static function csrfTokenInvalid(): self
    {
        return new self(
            "CSRF token validation failed",
            self::CSRF_TOKEN_INVALID,
            null,
            ['security_issue' => 'csrf'],
            'Niepoprawny token bezpieczeństwa. Odśwież stronę i spróbuj ponownie.'
        );
    }

    public static function multipleErrors(array $errors): self
    {
        $message = "Validation failed with " . count($errors) . " errors";
        return new self(
            $message,
            self::INVALID_INPUT,
            null,
            ['errors_count' => count($errors)],
            'Formularz zawiera błędy. Sprawdź wprowadzone dane.',
            $errors
        );
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function hasValidationErrors(): bool
    {
        return !empty($this->validationErrors);
    }
}