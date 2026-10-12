<?php

declare(strict_types=1);

namespace App\DTO\Dashboard\Subscriber;

use App\DTO\DataTransferObjectInterface;

readonly class SubscribersDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $email,
        public int $isActive,
        public ?string $confirmationTokenHash = null,
        public ?string $confirmationExpiresAt = null,
        public ?string $confirmationLastSentAt = null,
        public ?string $confirmedAt = null,
        public ?string $unsubscribeToken = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            email: (string) $data['email'],
            isActive: (int) $data['is_active'],
            confirmationTokenHash: isset($data['confirmation_token_hash'])
                ? (string) $data['confirmation_token_hash'] : null,
            confirmationExpiresAt: isset($data['confirmation_expires_at'])
                ? (string) $data['confirmation_expires_at'] : null,
            confirmationLastSentAt: isset($data['confirmation_last_sent_at'])
                ? (string) $data['confirmation_last_sent_at'] : null,
            confirmedAt: isset($data['confirmed_at'])
                ? (string) $data['confirmed_at'] : null,
            unsubscribeToken: isset($data['unsubscribe_token'])
                ? (string) $data['unsubscribe_token'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'is_active' => $this->isActive,
            'confirmation_token_hash' => $this->confirmationTokenHash,
            'confirmation_expires_at' => $this->confirmationExpiresAt,
            'confirmation_last_sent_at' => $this->confirmationLastSentAt,
            'confirmed_at' => $this->confirmedAt,
            'unsubscribe_token' => $this->unsubscribeToken,
        ];
    }
}
