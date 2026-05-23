<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\SubscribersDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGeneratorInterface;
use App\Service\Dashboard\Traits\StandardCrudTrait;
use Random\RandomException;

class SubscribersService extends AbstractDashboardService implements SubscribersManagementServiceInterface
{
    use StandardCrudTrait;

    private const TABLE = 'subscribers';

    public function __construct(
        SubscriberRepository $repository,
        private readonly TokenGeneratorInterface $tokenGenerator)
    {
        parent::__construct($repository);
    }

    /**
     * @throws ServiceException
     */
    public function getAllSubscribers(): array
    {
        return $this->getAll(self::TABLE);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {
        return $this->getRow($table, $id);
    }

    /**
     * @throws ServiceException
     * @throws RandomException
     */
    public function createSubscriber(DataTransferObjectInterface $data): string
    {
        if ($this->repository->emailExists($data->email)) {
            throw new ServiceException("Ten adres email jest już zapisany w bazie.", 409);
        }

        $token = $this->tokenGenerator->generate();

        $saveDto = SubscribersDto::fromArray([
            'id' => 0,
            'email' => $data->email,
            'is_active' => 0,
            'token' => $token,
        ]);

        $this->create(self::TABLE, $saveDto);

        return $token;
    }

    /**
     * @throws ServiceException
     */
    public function updateSubscriber(DataTransferObjectInterface $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    public function deleteSubscriber(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     * @throws RandomException
     */
    public function activateSubscriber(string $token): void
    {
        $subscriber = $this->repository->getSubscriberByToken(self::TABLE, $token);
        $unsubscribeToken = $this->tokenGenerator->generate();

        $updateDto = SubscribersDto::fromArray([
            'id' => $subscriber->id,
            'email' => $subscriber->email,
            'is_active' => 1,
            'token' => $unsubscribeToken
        ]);

        $this->edit(self::TABLE, $updateDto);
    }

    /**
     * @throws ServiceException
     */
    public function unsubscribe(string $token): void
    {
        $subscriber = $this->repository->getSubscriberByToken(self::TABLE, $token);

        $this->deleteSubscriber($subscriber->id);
    }
}