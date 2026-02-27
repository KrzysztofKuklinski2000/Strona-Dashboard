<?php

namespace Tests\Service\Dashboard;

use App\Repository\DashboardRepository;
use App\Service\Dashboard\ContactService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ContactServiceTest extends TestCase {

  private DashboardRepository | MockObject $repository;
  private ContactService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new ContactService($this->repository);
  }

  public function testShouldGetContactAndReturnFirstElement(): void
  {
    $contact = [['email' => 'test@gmail.com']];
    $this->repository->expects($this->once())->method('getDashboardData')->with('contact')->willReturn($contact);
    $this->assertEquals(['email' => 'test@gmail.com'], $this->service->getContact());
  }

  public function testShouldUpdateContact(): void
  {
    $data = ['email' => 'test@gmail.com'];
    $this->repository->expects($this->once())->method('edit')->with('contact', $data);
    $this->service->updateContact($data);
  }
}