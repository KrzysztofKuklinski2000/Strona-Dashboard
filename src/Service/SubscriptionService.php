<?php

namespace App\Service;

use App\DTO\Dashboard\CreateSubscriberDto;
use App\DTO\Dashboard\SubscribersDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGeneratorInterface;
use App\Service\Contracts\SubscriptionServiceInterface;

class SubscriptionService implements SubscriptionServiceInterface
{
    private const TABLE = 'subscribers';

    public function __construct(
        private readonly SubscriberRepository    $subscriberRepository,
        private readonly TokenGeneratorInterface $tokenGenerator,
    )
    {
    }

    /**
     * @throws NotFoundException
     * @throws ServiceException
     */
    public function confirm(string $token): void
    {
        try {
            $subscriber = $this->subscriberRepository->getSubscriberByToken($token);

            $unsubscribeToken = $this->tokenGenerator->generate();

            $updateDto = SubscribersDto::fromArray([
                'id' => $subscriber->id,
                'email' => $subscriber->email,
                'is_active' => 1,
                'token' => $unsubscribeToken
            ]);

            $this->subscriberRepository->edit(self::TABLE, $updateDto);
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się potwierdzić subskrypcji.',
                500,
                $e,
            );
        }
    }

    /**
     * @throws NotFoundException
     * @throws ServiceException
     */
    public function unsubscribe(string $token): void
    {
        try {
            $subscriber = $this->subscriberRepository->getSubscriberByToken($token);

            $this->subscriberRepository->delete(self::TABLE, $subscriber->id);
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się usunąć subskrypcji.',
                500,
                $e,
            );
        }
    }

    /**
     * @throws ServiceException
     */
    public function subscribe(CreateSubscriberDto $data): string
    {
        try {
            if ($this->subscriberRepository->emailExists($data->email)) {
                throw new ServiceException("Ten adres email jest już zapisany w bazie.", 409);
            }

            $token = $this->tokenGenerator->generate();

            $saveDto = SubscribersDto::fromArray([
                'id' => 0,
                'email' => $data->email,
                'is_active' => 0,
                'token' => $token,
            ]);

            $this->subscriberRepository->create(self::TABLE, $saveDto);

            return $token;
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się utworzyć subskrypcji.',
                500,
                $e,
            );
        }
    }
}