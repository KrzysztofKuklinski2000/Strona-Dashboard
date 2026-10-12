<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\Subscriber\CreateSubscriberDto;
use App\DTO\Dashboard\Subscriber\SubscribersDto;
use App\DTO\Dashboard\Subscriber\UpdateSubscriberDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGeneratorInterface;
use App\Service\Dashboard\Contracts\SubscribersManagementServiceInterface;
use App\Service\Dashboard\Traits\StandardCrudTrait;
use Random\RandomException;

/**
 * Administracyjne zarządzanie subskrybentami, oddzielone od publicznego zapisu.
 * Obecne dodawanie z dashboardu od razu ustawia rekord jako aktywny, bez maila potwierdzającego.
 */
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
     * Lista obejmuje rekordy aktywne i oczekujące, widoczne dla administratora.
     *
     * @throws ServiceException
     */
    public function getAllSubscribers(): array
    {
        return $this->getAll(self::TABLE, 'id');
    }

    /**
     * Pobiera pojedynczy rekord do podglądu lub formularza edycji.
     *
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(int $id): DataTransferObjectInterface
    {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * Dodaje aktywnego odbiorcę na podstawie decyzji administratora.
     * Generuje token wypisania, ale nie wykonuje publicznego potwierdzenia adresu.
     *
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
            'unsubscribe_token' => $token,
        ]);

        $this->create(self::TABLE, $saveDto);
    }

    /**
     * Zapisuje email i status z formularza administratora.
     * Obecnie nie resetuje tokenów ani potwierdzenia po zmianie adresu;
     * obsługa takiej zmiany wymaga jeszcze dopracowania.
     *
     * @throws ServiceException
     */
    public function updateSubscriber(UpdateSubscriberDto $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    /**
     * Administracyjne usunięcie wskazanego rekordu, bez publicznego tokenu wypisania.
     */
    public function deleteSubscriber(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }
}
