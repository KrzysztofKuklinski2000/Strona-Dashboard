<?php 

namespace Tests\Notification\Email;

use App\Notification\Email\Mailer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerTest extends TestCase
{
  public function testShouldSendEmailToSingleUser(): void
  {
    // GIVEN 
    $user = 'jan@example.com';
    $htmlContent = "<p>Zmieniono grafik</p>";
    $config = ['from_email' => 'test@strona.pl'];

    $mailerInterfaceMock = $this->createMock(MailerInterface::class);

    // EXPECTS
    $mailerInterfaceMock->expects($this->once())
      ->method('send')
      ->with($this->callback(function (Email $email) use ($user, $config) {
        return $email->getTo()[0]->getAddress() === $user &&
          $email->getFrom()[0]->getAddress() === $config['from_email'];
      }));

    $mailer = new Mailer($mailerInterfaceMock, $config);

    // WHEN
    $mailer->send($user, 'Aktualizacja grafiku', $htmlContent);
  }
}