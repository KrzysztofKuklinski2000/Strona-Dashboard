<?php 

namespace Tests\Factories\ServiceFactories;

use App\Factories\ServiceFactories\Notification\MailerFactory;
use App\Notification\Email\Mailer;
use PHPUnit\Framework\TestCase;

class MailerFactoryTest extends TestCase {
  public function testShouldCreateEmailServiceInstance(): void {
    $factory = new MailerFactory();
    $service = $factory->createService();

    $this->assertInstanceOf(Mailer::class, $service);
  }
}