<?php 

namespace Tests\Service\Email;

use App\Service\Email\EmailService;
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
    $mailerMock->expects($this->once())
      ->method('send')
      ->with($this->callback(function(Email $email){
        $hasCorrectSubject = $email->getSubject() === 'Aktualizacja grafiku';

        $bccAddresses = array_map(fn($address) => $address->getAddress(), $email->getBcc());

        $hasCorrectBcc = count(array_intersect(['jan@example.com', 'karol@example.com'], $bccAddresses)) === 2;

        return $hasCorrectSubject && $hasCorrectBcc;
      }));

    $config = $config = ['from_email' => 'test@strona.pl', 'from_name' => 'Test'];
    $emailService = new EmailService($mailerMock, $config);

    //WHEN
    $emailService->sendTimetableUpdate($users, $htmlContent);

  }
}