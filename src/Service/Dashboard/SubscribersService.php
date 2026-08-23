<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\CreateSubscriberDto;
use App\DTO\Dashboard\SubscribersDto;
use App\DTO\Dashboard\UpdateSubscriberDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGeneratorInterface;
use App\Service\Dashboard\Contracts\SubscribersManagementServiceInterface;
use App\Service\Dashboard\Traits\StandardCrudTrait;
use Random\RandomException;

class SubscribersService extends AbstractDashboardService implements SubscribersManagementServiceInterface
{
    use StandardCrudTrait;

    private const TABLE = 'subscribers';

    public function __construct(
        SubscriberRepository $repository,
        private readonly TokenGeneratorInterface $tokenGenerator
    ) {
        parent::__construct($repository);
    }

    /**
     * @throws ServiceException
     */
    public function getAllSubscribers(): array
    {
        return $this->getAll(self::TABLE, 'id');
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(int $id): DataTransferObjectInterface
    {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     * @throws RandomException
     */
    public function createSubscriber(CreateSubscriberDto $data): void
    {
        if ($this->repository->emailExists($data->email)) {
            throw new ServiceException("Ten adres email jest już zapisany w bazie.", 409);
        }

        $token = $this->tokenGenerator->generate();

        $saveDto = SubscribersDto::fromArray([
            'id' => 0,
            'email' => $data->email,
            'is_active' => 1,
            'token' => $token,
        ]);

        $this->create(self::TABLE, $saveDto);
    }

    /**
     * @throws ServiceException
     */
    public function updateSubscriber(UpdateSubscriberDto $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    public function deleteSubscriber(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }
}
