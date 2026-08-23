<?php

declare(strict_types=1);

namespace App\Service\Contracts;

use App\DTO\Dashboard\CreateSubscriberDto;

interface SubscriptionServiceInterface
{
    public function subscribe(CreateSubscriberDto $data): void;
    public function unsubscribe(string $token): void;
    public function confirm(string $token): void;
}
