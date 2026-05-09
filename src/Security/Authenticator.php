<?php

namespace App\Security;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\AuthRepository;

class Authenticator
{
    public function __construct(public AuthRepository $authRepository)
    {
    }

    /**
     * @throws ServiceException
     */
    public function authenticate(string $login, string $password): array
    {
        try {
            $user = $this->authRepository->getUser($login);

            if (!$user || !password_verify($password, $user['password'])) {
                throw new ServiceException("Nieprawidłowy login lub hasło.", 401);
            }

            unset($user['password']);
            return $user;
        } catch (RepositoryException $e) {
            throw new ServiceException("Wystąpił błąd podczas autoryzacji", 500, $e);
        }
    }
}