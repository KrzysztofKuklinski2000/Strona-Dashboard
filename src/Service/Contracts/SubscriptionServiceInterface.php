<?php

namespace App\Service\Contracts;

use App\DTO\Dashboard\CreateSubscriberDto;

interface SubscriptionServiceInterface
{
    public function subscribe(CreateSubscriberDto $data): string;
    public function unsubscribe(string $token): void;
    public function confirm(string $token): void;
}