<?php

namespace App\Service\Dashboard;

use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\StandardCrudTrait;
use Random\RandomException;

class SubscribersService extends AbstractDashboardService implements SubscribersManagementServiceInterface
{

    use StandardCrudTrait;

    private const TABLE = 'subscribers';

    /**
     * @throws ServiceException
     */
    public function getAllSubscribers(): array
    {
        return $this->getAll(self::TABLE);
    }

    /**
     * @throws ServiceException
     * @throws RandomException
     */
    public function createSubscriber(array $data): string
    {
        if ($this->repository->emailExists($data['email'])) {
            throw new ServiceException("Ten adres email jest już zapisany w bazie.", 409);
        }

        $token = bin2hex(random_bytes(32));
        $data['token'] = $token;

        if (!isset($data['is_active'])) {
            $data['is_active'] = 0;
        }

        $this->create(self::TABLE, $data);

        return $token;
    }

    /**
     * @throws ServiceException
     */
    public function updateSubscriber(array $data): void
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

        if (!$subscriber) {
            throw new ServiceException("Nieprawidłowy lub wygasły token.", 404);
        }

        $unsubscribeToken = bin2hex(random_bytes(32));

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
