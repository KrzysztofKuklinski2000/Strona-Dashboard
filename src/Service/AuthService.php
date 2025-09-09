<?php 
declare(strict_types= 1);
namespace App\Service;

use App\Exception\StorageException;
use App\Repository\AuthRepository;
use Throwable;

class AuthService {

    public function __construct(public AuthRepository $authRepository) {}

    public function login(string $login, string $password):array {
        $errors = [];
        try {
            $user = $this->authRepository->getUser($login);

            if (!$user) {
                $errors['login'] = "Niepoprawny login";
            }else if(!password_verify($password, $user['password'])) {
                $errors['password'] = 'Niepoprawne hasło';
            }else {
                $_SESSION['user'] = $user;
            }

            return $errors;
        }catch (Throwable $e) {
            throw new StorageException("Nie udało się zalogować", 500, $e);
        }
    }
}