<?php 

namespace Tests\Notification\Email;

use App\Notification\Email\EmailService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailServiceTest extends TestCase
{
  public function testShouldSendsTimeTableUpdateNotificationToMultipleUsers(): void {
    // GIVEN 
    $users = ['jan@example.com', 'karol@example.com'];
    $htmlContent = "<p>Zmieniono grafik</p>";

    $mailerMock = $this->createMock(MailerInterface::class);

    // EXPECTS
    $mailerMock->expects($this->exactly(count($users)))
      ->method('send')
      ->with($this->callback(function(Email $email) use ($users){
        return in_array($email->getTo()[0]->getAddress(), $users);
      }));

    $config = ['from_email' => 'test@strona.pl', 'from_name' => 'Test'];
    $emailService = new EmailService($mailerMock, $config);

    //WHEN
    $emailService->sendTimetableUpdate($users, $htmlContent);

  }
}