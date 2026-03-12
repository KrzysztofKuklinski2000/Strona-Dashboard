<?php 

namespace Test\Notification;

use App\Notification\Email\Mailer;
use App\Notification\Notifier;
use App\Repository\SubscriberRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NotifierTest extends TestCase
{
    private Mailer | MockObject $mailer;
    private SubscriberRepository | MockObject $subscriberRepository;
    private Notifier $notifier;

    public function setUp(): void
    {
        $this->mailer = $this->createMock(Mailer::class);
        $this->subscriberRepository = $this->createMock(SubscriberRepository::class);

        $this->notifier = new Notifier($this->mailer, $this->subscriberRepository);
    }

  public function testShouldFetchEmailsAndSendNotificationToEachSubscriber(): void
  {
    // GIVEN
    $subscribers = [
      ['id'=> 1, 'email' => 'email1@example.pl', 'token' => 'test-token'],
      ['id'=> 2, 'email' => 'email2@example.pl', 'token' => 'test2-token']
    ];

    // EXPECTS 
    $this->subscriberRepository->expects($this->once())
      ->method('getActiveEmails')
      ->willReturn($subscribers);

    $this->mailer->expects($this->exactly(count($subscribers)))
      ->method('send')
      ->with(
        $this->isType('string'),
        $this->equalTo('Aktualizacja grafiku'),
        $this->isType('string')
      );

    // WHEN 
    $this->notifier->notifyAboutTimetableUpdate();
  }

  public function testShouldNotSendEmailsIfSubscriberListIsEmpty(): void
  {
    // GIVEN
    $this->subscriberRepository->method('getActiveEmails')->willReturn([]);

    // EXPECTS
    $this->mailer->expects($this->never())->method('send');

    // WHEN
    $this->notifier->notifyAboutTimetableUpdate();
  }

  public function testShouldSendConfirmationEmailWithCorrectTokenAndLink(): void
    {
        // GIVEN
        $email = 'nowy@uzytkownik.pl';
        $token = 'super-tajny-token-123';
        $expectedSubject = 'Potwierdź zapis do newslettera - Karate Kyokushin';
        
        // EXPECTS
        $this->mailer->expects($this->once())
            ->method('send')
            ->with(
                $this->equalTo($email),
                $this->equalTo($expectedSubject),
            );

        // WHEN
        $this->notifier->sendConfirmationEmail($email, $token);
    }
}