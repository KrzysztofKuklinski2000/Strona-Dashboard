<?php 

namespace Tests\Service;

use App\Service\AuthService;
use PHPUnit\Framework\TestCase;
use App\Repository\AuthRepository;
use App\Exception\ServiceException;
use App\Exception\RepositoryException;
use PHPUnit\Framework\MockObject\MockObject;


class AuthServiceTest extends TestCase {

  private AuthRepository | MockObject $repository;
  private AuthService $service;



  public function setUp(): void
  {
    $this->repository = $this->createMock(AuthRepository::class);
    $this->service = new AuthService($this->repository);
    $_SESSION = [];
  }

  public function testShouldSetSessionUserWhenLoginSuccess(): void
  {
    // GIVEN 
    $login = 'test';
    $password = 'test';
    $user = ['login' => $login, 'password' => password_hash($password, PASSWORD_BCRYPT)];

    // EXPECT 
    $this->repository->expects($this->once())
      ->method('getUser')
      ->with($login)
      ->willReturn($user);

    // WHEN
    $this->service->login($login, $password);

    // THEN
    $this->assertEquals($user, $_SESSION['user']);
    $this->assertArrayHasKey('user', $_SESSION);
  }

  public function testShouldReturnErrorsWhenLoginFails(): void
  {
    // GIVEN
    $login = 'test';
    $password = 'test';

    // EXPECT
    $this->repository->expects($this->once())
      ->method('getUser')
      ->with($login)
      ->willReturn([]);
    
    // WHEN 
    $actual = $this->service->login($login, $password);

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertArrayNotHasKey('user', $_SESSION);
    $this->assertSame($actual['login'], 'Niepoprawny login');
  }

  public function testShouldReturnErrorsWhenPasswordFails(): void
  {
    // GIVEN
    $login = 'test';
    $password = 'test';
    $user = ['login' => $login, 'password' => password_hash('test2', PASSWORD_BCRYPT)];

    // EXPECT 
    $this->repository->expects($this->once())
      ->method('getUser')
      ->with($login)
      ->willReturn($user);

    // WHEN
    $actual = $this->service->login($login, $password);

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertArrayNotHasKey('user', $_SESSION);
    $this->assertSame($actual['password'], 'Niepoprawne hasło');
  }

  public function testShouldThrowServiceExceptionWhenGetUserFailure(): void
  {
    // EXPECT
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się zalogować');


    // WHEN 
    $this->repository->method('getUser')
      ->willThrowException(new RepositoryException());

    $this->service->login('test', 'test');
    
  }
}