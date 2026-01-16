<?php

namespace Tests\Service;

use App\Service\SiteService;
use PHPUnit\Framework\TestCase;
use App\Repository\SiteRepository;
use App\Exception\ServiceException;
use App\Exception\RepositoryException;
use PHPUnit\Framework\MockObject\MockObject;


class SiteServiceTest extends TestCase {
  private SiteRepository | MockObject $repository;
  private SiteService $service;

  public function setUp(): void
  {
    $this->repository = $this->createMock(SiteRepository::class);
    $this->service = new SiteService($this->repository);
  }

  public function testShouldReturnNewsWithPagination(): void
  {
    // GIVEN
    $perPage = 2;
    $page = 1;
    $offset = 0;

    $expected = [
      ['id' => 1, 'title' => 'test'],
      ['id' => 2, 'title' => 'test'],
    ];
    
    
    $this->repository->expects($this->once())
      ->method('countData')
      ->with('news')
      ->willReturn(4);

    $this->repository->expects($this->once())
      ->method('getNews')
      ->with($perPage, $offset)
      ->willReturn($expected);

    // WHEN 
    $actual = $this->service->getNews($page, $perPage);

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertSame($actual['data'], $expected);
    $this->assertSame($actual['currentPage'], $page);
    $this->assertEquals($actual['totalPages'], 2);  
  }

  public function testShouldReturnLastPageWhenRequestedPageExceedsTotalPages(): void
  {
    // GIVEN
    $perPage = 2;
    $requestedPage = 1000;
    $totalRecords = 50;
    $lastPage = 25; //($totalRecords/$parPage) = 25

    $expectedOffset = ($lastPage - 1) * $perPage; // 48

    $expectedData = [
      ['id' => 49, 'title' => 'test'],
      ['id' => 50, 'title' => 'test'],
    ];

    // EXPECTS
    $this->repository->expects($this->once())
      ->method('countData')
      ->with('news')
      ->willReturn($totalRecords);

    $this->repository->expects($this->once())
      ->method('getNews')
      ->with($perPage, $expectedOffset)
      ->willReturn($expectedData);

    // WHEN
    $actual = $this->service->getNews($requestedPage, $perPage);

    // THEN
    $this->assertSame($expectedData, $actual['data']);
    $this->assertEquals($lastPage, $actual['totalPages']);
    $this->assertSame($lastPage, $actual['currentPage']);
  }

  public function testShouldReturnFirstPageWhenRequestedPageIsZeroOrLess(): void 
  {
    // GIVEN 
    $perPage = 2;
    $requestedPage = -1;
    $totalRecords = 50;
    $expectedPage = 1;

    $expectedOffset = 0;

    $expectedData = [
      ['id' => 1, 'title' => 'test'],
      ['id' => 2, 'title' => 'test'],
    ];

    // EXPECTS
    $this->repository->expects($this->once())
      ->method('countData')
      ->with('news')
      ->willReturn($totalRecords);

    $this->repository->expects($this->once())
      ->method('getNews')
      ->with($perPage, $expectedOffset)
      ->willReturn($expectedData);

    // WHEN
    $actual = $this->service->getNews($requestedPage, $perPage);

    // THEN
    $this->assertSame($expectedData, $actual['data']);
    $this->assertSame($expectedPage, $actual['currentPage']);
  }

  public function testShouldReturnEmptyListWhenNoNewsFound(): void
  {
    // GIVEN
    $perPage = 2;
    $totalRecords = 0;
    $expectedData = [];

    $this->repository->expects($this->once())
      ->method('countData')
      ->with('news')
      ->willReturn($totalRecords);

    $this->repository->expects($this->once())
      ->method('getNews')
      ->with($perPage, 0) // $page = 1; $offset = ($page - 1) * $perpage = 0
      ->willReturn($expectedData);

    // WHEN
    $actual = $this->service->getNews(1, $perPage);

    // THEN
    $this->assertEmpty($actual['data']);
    $this->assertSame(1, $actual['currentPage']);
    $this->assertEquals(0, $actual['totalPages']);
  }

  public function testShouldThrowServiceExceptionWhenGetNewsFailure(): void
  {
    // EXPECT
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych');

    // WHEN 
    $this->repository->method('getNews')
      ->willThrowException(new RepositoryException());

    $this->service->getNews(1);
  }


  public function testShouldReturnFrontPageData(): void 
  {
    // GIVEN
    $firstPost = ['id' => 1, 'title' => 'test'];
    $otherPost = ['id' => 2, 'title' => 'test'];

    $expectedPosts = [
      $firstPost,
      $otherPost,
    ];
    
    $expectedImportantPosts = [
      ['id' => 1, 'title' => 'test'],
    ];

    $this->repository->method('getData')
      ->willReturnMap([
        ['main_page_posts', $expectedPosts],
        ['important_posts', $expectedImportantPosts],
      ]);

    // WHEN 
    $actual = $this->service->getFrontPage();

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertCount(1, $actual[0]);
    $this->assertContains($otherPost, $actual[0]);
    $this->assertNotContains($firstPost, $actual[0]);

    $this->assertSame($expectedImportantPosts, $actual[1]);
    $this->assertSame($firstPost, $actual[2]);
  }

  public function testShouldThrowServiceExceptionWhenGetFrontPageFailure(): void
  {
    // EXPECT 
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych');

    // WHEN 
    $this->repository->method('getData')
      ->willThrowException(new RepositoryException());

    $this->service->getFrontPage();
  }

  public function testShouldReturnGallery(): void
  {
    // GIVEN
    $expected = [
      ['id' => 1, 'title' => 'test'],
      ['id' => 2, 'title' => 'test'],
    ];

    // WHEN 
    $this->repository->method('getGallery')
      ->willReturn($expected);

    $actual = $this->service->getGallery();

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertCount(2, $actual);
    $this->assertSame($expected, $actual);

  }

  public function testShouldThrowServiceExceptionWhenGetGalleryFailure(): void
  {
    // EXPECT
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać galeri');

    // WHEN 
    $this->repository->method('getGallery')
      ->willThrowException(new RepositoryException());

    $this->service->getGallery();
  }

  public function testShouldReturnTimetable(): void
  {
    // GIVEN
    $expected = [
      ['id' => 1, 'day' => 'pon'],
      ['id' => 2, 'day' => 'wt'],
    ];
    
    // WHEN
    $this->repository->method('timetablePageData')
      ->willReturn($expected);

    $actual = $this->service->getTimetable();

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertCount(2, $actual);
    $this->assertSame($expected, $actual);
  }

  public function testShouldThrowServiceExceptionWhenGetTimetableFailure(): void
  {
    // EXPECT
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać grafiku');

    // WHEN 
    $this->repository->method('timetablePageData')
      ->willThrowException(new RepositoryException());

    $this->service->getTimetable();
  }

  public function testShouldReturnContact(): void
  {
    // GIVEN
    $expected = ['id' => 1, 'phone' => '123456789'];

    // WHEN
    $this->repository->method('getSingleRecord')
      ->with('contact')
      ->willReturn($expected);

    $actual = $this->service->getContact();

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertSame($expected, $actual);
  }

  public function testShouldThrowServiceExceptionWhenGetContactFailure(): void
  {
    // EXPECT
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych kontaktowych');

    // WHEN 
    $this->repository->method('getSingleRecord')
      ->willThrowException(new RepositoryException());

    $this->service->getContact();
  }

  public function testShouldReturnCamp(): void
  {
    // GIVEN
    $expected = ['id' => 1, 'name' => 'Summer Camp'];

    // WHEN
    $this->repository->method('getSingleRecord')
      ->with('camp')
      ->willReturn($expected);

    $actual = $this->service->getCamp();

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertSame($expected, $actual);
  }
  public function testShouldThrowServiceExceptionWhenGetCampFailure(): void
  {
    // EXPECT
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych o obozach');

    //WHEN 
    $this->repository->method('getSingleRecord')
      ->willThrowException(new RepositoryException());

    $this->service->getCamp();
  }

  public function testShouldReturnFees(): void
  {
    // GIVEN
    $expected = ['reduced_contribution_1_month' => 100];

    // WHEN
    $this->repository->method('getSingleRecord')
      ->with('fees')
      ->willReturn($expected);

    $actual = $this->service->getFees();

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertSame($expected, $actual);
  }

  public function testShouldThrowServiceExceptionWhenGetFeesFailure(): void
  {
    // EXPECT
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych o składkach');

    // WHEN 
    $this->repository->method('getSingleRecord')
      ->willThrowException(new RepositoryException());

    $this->service->getFees();
  }
}