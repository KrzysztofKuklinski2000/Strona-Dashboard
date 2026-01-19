<?php
namespace Tests\Repository;

use PDO;
use PHPUnit\Framework\TestCase;
use App\Repository\AuthRepository;
use App\Exception\RepositoryException;

class AuthRepositoryTest extends TestCase
{
    private AuthRepository $repository;
    private PDO $pdo;

    public function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE user (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            login TEXT,
            password TEXT
        )");

        $this->pdo->exec("INSERT INTO user (login, password) VALUES ('admin', 'admin')");
        $this->repository = new AuthRepository($this->pdo);
    }


    public function testShouldGetUser(): void
    {
        // WHEN
        $result = $this->repository->getUser('admin');

        // THEN
        $this->assertEquals('admin', $result['login']);
    }

    public function testShouldReturnEmptyArrayWhenUserNotFound(): void
    {
        // WHEN
        $result = $this->repository->getUser('invalid_user');

        // THEN
        $this->assertCount(0, $result);
    }

    public function testShouldThrowRepositoryExceptionWhenUserNotFound(): void
    {
        // GIVEN
        $this->repository->runQuery("DROP TABLE user");

        // EXPECT
        $this->expectException(RepositoryException::class);   
        $this->expectExceptionMessage('Nie udało się pobrać użytkownika');

        // WHEN
        $this->repository->getUser('test');
    }
}