<?php

declare(strict_types=1);

namespace Tests\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\SubscribersService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SubscriberServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private SubscribersService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new SubscribersService($this->repository);
  }

  public function testShouldGetAllSubscribers(): void
  {
    // GIVEN 
    $subscribers = [
      ['id' => 1, 'email' => 'example1@test.com'],
      ['id' => 2, 'email' => 'example2@test.com'],
    ];

    // EXPECTS 
    $this->repository->method('getDashboardData')
      ->with('subscribers')
      ->willReturn($subscribers);

    // WHEN 
    $actual = $this->service->getAllSubscribers();

    // THEN
    $this->assertEquals($subscribers, $actual);
  }

  public function testShouldCreateSubscriberSuccessfully(): void
  {
    // GIVEN
    $data = ['email' => 'example@gmail.com'];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->never())->method('incrementPosition');
    $this->repository->expects($this->once())
      ->method('create')
      ->with($this->callback(function($passedData) {
            return isset($passedData['token']) && 
                   strlen($passedData['token']) === 64 && 
                   $passedData['is_active'] === 0 &&
                   $passedData['email'] === 'example@gmail.com';
        }), 'subscribers');
    $this->repository->expects($this->once())->method('commit');

    // WHEN
    $this->service->createSubscriber($data);
  }

  public function testShouldThrowServiceExceptionWhenCreateSubscriberFailure(): void
  {
    // EXPECTS
    $this->expectException(ServiceException::class);
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('rollback');

    // WHEN 
    $this->repository->method('create')->willThrowException(new RepositoryException('Błąd'));
    $this->service->createSubscriber(['']);
  }

  public function testShouldUpdateSubscriberSuccessfully(): void
  {
    // GIVEN
    $data = ['id' => 1, 'email' => 'example@gmail.com'];

    // EXPECTS
    $this->repository->expects($this->once())->method('edit')->with('subscribers', $data);

    // WHEN
    $this->service->updateSubscriber($data);
  }

  public function testShouldUpdateSubscriberWithActiveStatus(): void
{
    // GIVEN
    $data = [
        'id' => 1, 
        'email' => 'example@gmail.com', 
        'is_active' => 0 
    ];

    // EXPECTS
    $this->repository->expects($this->once())
        ->method('edit')
        ->with('subscribers', $data);

    // WHEN
    $this->service->updateSubscriber($data);
}

  public function testShouldThrowServiceExceptionWhenUpdateSubscriberFailure(): void
  {
    // EXPECTS
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się edytować');
    // WHEN 
    $this->repository->method('edit')->willThrowException(new RepositoryException('Błąd'));
    $this->service->updateSubscriber(['']);
  }

  public function testShouldDeleteSubscriber(): void
  {
    // GIVEN 
    $id = 1;
    $postData = ['id' => 1, 'email' => 'test@gmail.com'];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with($id, 'subscribers')->willReturn($postData);
    $this->repository->expects($this->once())->method('delete')->with($id, 'subscribers');
    $this->repository->expects($this->never())->method('decrementPosition');
    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->deleteSubscriber($id);
  }

  public function testShouldThrowServiceExceptionWhenDeleteSubscriberFailure(): void
  {
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się usunąć posta');

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->method('getPost')->willThrowException(new RepositoryException('Błąd'));
    $this->repository->expects($this->once())->method('rollBack');

    $this->service->deleteSubscriber(1);
  }

  public function testShouldActivateSubscriberSuccessfully(): void
  {
    // GIVEN
    $token = 'valid-token-123';
    $subscriberData = [
        'id' => 10,
        'email' => 'test@example.com',
        'token' => $token,
        'is_active' => 0
    ];

    // EXPECTS
    $this->repository->expects($this->once())
        ->method('getSubscriberByToken')
        ->with('subscribers', $token)
        ->willReturn($subscriberData);

    $this->repository->expects($this->once())
        ->method('edit')
        ->with(
            $this->equalTo('subscribers'),
            $this->callback(function ($data) {
                $isIdCorrect = $data['id'] === 10;
                $isActiveCorrect = $data['is_active'] === 1;
                
                $isTokenGenerated = isset($data['token']) && strlen($data['token']) === 64;

                return $isIdCorrect && $isActiveCorrect && $isTokenGenerated;
            })
        );

    // WHEN
    $this->service->activateSubscriber($token);
  }

  public function testShouldThrowServiceExceptionWhenSubscriberNotFoundByToken(): void
  {
    // GIVEN
    $token = 'non-existent-token';

    // EXPECTS
    $this->repository->expects($this->once())
        ->method('getSubscriberByToken')
        ->with('subscribers', $token)
        ->willReturn([]);

    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage("Nieprawidłowy lub wygasły token.");
    $this->expectExceptionCode(404);

    // WHEN
    $this->service->activateSubscriber($token);
  }

  public function testShouldActivateAndGenerateNewToken(): void
  {
      // GIVEN
      $oldToken = 'old-activation-token';
      $subscriber = ['id' => 1, 'token' => $oldToken];
      
      $this->repository->expects($this->once())
          ->method('getSubscriberByToken')
          ->willReturn($subscriber);

      // EXPECTS
      $this->repository->expects($this->once())
          ->method('edit')
          ->with('subscribers', $this->callback(function($data) use ($oldToken) {
              return $data['is_active'] === 1 && 
                    $data['token'] !== $oldToken && 
                    strlen($data['token']) === 64; 
          }));

      // WHEN
      $this->service->activateSubscriber($oldToken);
  }

  public function testShouldUnsubscribeSuccessfully(): void
  {
      // GIVEN
      $token = 'permanent-unsubscribe-token';
      $subscriber = ['id' => 5, 'token' => $token];

      $this->repository->expects($this->once())
          ->method('getSubscriberByToken')
          ->with('subscribers', $token)
          ->willReturn($subscriber);

      // EXPECTS
      $this->repository->expects($this->once())
          ->method('delete')
          ->with(5, 'subscribers');

      // WHEN
      $this->service->unsubscribe($token);
  }
}