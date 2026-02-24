<?php 

namespace Tests\Factories\ServiceFactories;

use App\Factories\ServiceFactories\EmailServiceFactory;
use App\Service\Email\EmailService;
use PHPUnit\Framework\TestCase;

class EmailServiceFactoryTest extends TestCase {
  public function testShouldCreateEmailServiceInstance(): void {
    $factory = new EmailServiceFactory();
    $service = $factory->createService();

    $this->assertInstanceOf(EmailService::class, $service);
  }
}