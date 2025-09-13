<?php 
declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

class AppException extends Exception 
{
    protected array $context = [];
    protected string $userMessage = '';

    public function __construct(
        string $message = '', 
        int $code = 0, 
        ?Throwable $previous = null,
        array $context = [],
        string $userMessage = ''
    ) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
        $this->userMessage = $userMessage ?: $message;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }

    public function getFullDetails(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'context' => $this->context,
            'user_message' => $this->userMessage,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
}