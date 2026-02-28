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
    $emails = ['email1@example.pl', 'email2@example.pl'];

    // EXPECTS 
    $this->subscriberRepository->expects($this->once())
      ->method('getAllEmails')
      ->willReturn($emails);

    $this->mailer->expects($this->exactly(count($emails)))
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
    $this->subscriberRepository->method('getAllEmails')->willReturn([]);

    // EXPECTS
    $this->mailer->expects($this->never())->method('send');

    // WHEN
    $this->notifier->notifyAboutTimetableUpdate();
  }
}