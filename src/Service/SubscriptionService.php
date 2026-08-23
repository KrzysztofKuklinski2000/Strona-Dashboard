<?php

namespace App\Service;

use App\DTO\Dashboard\CreateSubscriberDto;
use App\DTO\Dashboard\SubscribersDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Notification\Notifier;
use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGeneratorInterface;
use App\Service\Contracts\SubscriptionServiceInterface;
use Random\RandomException;
use Throwable;

class SubscriptionService implements SubscriptionServiceInterface
{
    private const TABLE = 'subscribers';

    public function __construct(
        private readonly SubscriberRepository    $subscriberRepository,
        private readonly TokenGeneratorInterface $tokenGenerator,
        private readonly Notifier                $notifier,
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
        } catch (RepositoryException|RandomException $e) {
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
    public function subscribe(CreateSubscriberDto $data): void
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
        } catch (RepositoryException|RandomException $e) {
            throw new ServiceException(
                'Nie udało się utworzyć subskrypcji.',
                500,
                $e,
            );
        }

        try {
            $this->notifier->sendConfirmationEmail($data->email, $token);
        } catch (Throwable $e) {
            $this->removePendingSubscriber($token);

            throw new ServiceException(
                'Nie udało się wysłać wiadomości potwierdzającej.',
                500,
                $e,
            );
        }
    }

    /**
     * @throws ServiceException
     */
    private function removePendingSubscriber(string $token): void
    {
        try {
            $this->subscriberRepository->deletePendingSubscriberByToken($token);
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się usunąć oczekującej subskrypcji.',
                500,
                $e,
            );
        }
    }
}