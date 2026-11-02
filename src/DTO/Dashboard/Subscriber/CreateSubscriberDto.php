<?php

declare(strict_types=1);

namespace App\DTO\Dashboard\Subscriber;

use App\DTO\DataTransferObjectInterface;

readonly class CreateSubscriberDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $email,
        public string $consentVersion,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            email: (string) $data['email'],
            consentVersion: (string) $data['consent_version'],
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'consent_version' => $this->consentVersion,
        ];
    }
}
