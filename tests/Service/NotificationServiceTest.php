<?php 

namespace Test\Service;

use App\Repository\SubscriberRepository;
use App\Service\Email\EmailService;
use App\Service\NotificationService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NotificationServiceTest extends TestCase
{
    private EmailService | MockObject $emailService;
    private SubscriberRepository | MockObject $subscriberRepository;
    private NotificationService $notificationService;

    public function setUp(): void
    {
        $this->emailService = $this->createMock(EmailService::class);
        $this->subscriberRepository = $this->createMock(SubscriberRepository::class);

        $this->notificationService = new NotificationService($this->emailService, $this->subscriberRepository);
    }

    public function testShouldFetchEmailsAndSendNotification(): void
    {
      // GIVEN 
      $emails = [
        'email@example.pl',
        'email2@example.pl',
      ];

      //EXPECTS 
      $this->subscriberRepository->expects($this->once())
        ->method('getAllEmails')
        ->willReturn($emails);

      $this->emailService->expects($this->once())
        ->method('sendTimetableUpdate')
        ->with($emails, $this->stringContains('Aktualizacja Grafiku'));

      // WHEN 
      $this->notificationService->notifyAboutTimetableUpdate();      
    }

}