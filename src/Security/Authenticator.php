<?php

namespace App\Security;

use App\DTO\Auth\UserCredentialsDto;
use App\DTO\Auth\UserDto;
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
    public function authenticate(string $login, string $password): UserDto
    {
        try {
            $userData = $this->authRepository->getUser($login);

            if (!$userData) {
                throw new ServiceException("Nieprawidłowy login lub hasło.", 401);
            }

            $credentials = UserCredentialsDto::fromArray($userData);

            if (!password_verify($password, $credentials->passwordHash)) {
                throw new ServiceException("Nieprawidłowy login lub hasło.", 401);
            }

            return new UserDto(
                id: $credentials->id,
                login: $credentials->login
            );

        } catch (RepositoryException $e) {
            throw new ServiceException("Wystąpił błąd podczas autoryzacji", 500, $e);
        }
    }
}