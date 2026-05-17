<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\SubscribersDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\BaseDashboardRepository;
use App\Security\TokenGeneratorInterface;
use App\Service\Dashboard\Traits\StandardCrudTrait;
use Random\RandomException;

class SubscribersService extends AbstractDashboardService implements SubscribersManagementServiceInterface
{
    use StandardCrudTrait;

    private const TABLE = 'subscribers';

    public function __construct(
        BaseDashboardRepository                  $repository,
        private readonly TokenGeneratorInterface $tokenGenerator)
    {
        parent::__construct($repository);
    }

    /**
     * @throws ServiceException
     */
    public function getAllSubscribers(): array
    {
        return array_map(fn(array $row) => SubscribersDto::fromArray($row), $this->getAll(self::TABLE));
    }


    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {
        return SubscribersDto::fromArray($this->getRow($table, $id));
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

        $saveData = $data->toArray();

        $saveData['token'] = $token;
        $saveData['is_active'] = 0;

        $this->create(self::TABLE, $saveData);

        return $token;
    }

    /**
     * @throws ServiceException
     */
    public function updateSubscriber(DataTransferObjectInterface $data): void
    {
        $this->edit(self::TABLE, $data->toArray());
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

        if (!$subscriber) {
            throw new ServiceException("Nieprawidłowy lub wygasły token.", 404);
        }

        $unsubscribeToken = $this->tokenGenerator->generate();

        $this->edit(self::TABLE, [
            'id' => $subscriber['id'],
            'is_active' => 1,
            'token' => $unsubscribeToken
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function unsubscribe(string $token): void
    {
        $subscriber = $this->repository->getSubscriberByToken(self::TABLE, $token);

        if (!$subscriber) {
            throw new ServiceException("Nieprawidłowy lub wygasły token.", 404);
        }

        $this->deleteSubscriber((int)$subscriber['id']);
    }
}
