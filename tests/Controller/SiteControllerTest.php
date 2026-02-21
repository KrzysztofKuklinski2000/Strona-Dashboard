<?php

namespace Tests\Controller;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Service\SiteService;
use PHPUnit\Framework\TestCase;
use App\Controller\SiteController;
use PHPUnit\Framework\MockObject\MockObject;

class SiteControllerTest extends TestCase 
{
  private Request | MockObject $request;
  private SiteService | MockObject $siteService;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private SiteController $controller;

  public function setUp(): void
  {
    $this->request = $this->createMock(Request::class);
    $this->siteService = $this->createMock(SiteService::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);

    $this->controller = new SiteController(
      $this->request, 
      $this->siteService, 
      $this->easyCSRF, 
      $this->view, 
    );
  }

  public function testShouldRenderStartPageWithContactWhenActionIsIndex(): void
  {
    // GIVEN
    $fakeContent = ['title' => 'Witaj na stronie'];
    $this->siteService->expects($this->once())
      ->method('getFrontPage')
      ->willReturn($fakeContent);

    $fakeContact = ['email' => 'test@gmail.com'];
    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn($fakeContact);

    // EXPECTS
    $expectParams = [
      'page' => 'start',
      'content' => $fakeContent,
      'contact' => $fakeContact
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->indexAction();
  }

  public function testShouldFetchNewsFromGivenPageAndRenderItWhenActionIsNews(): void
  {
    // GIVEN 
    $this->request->expects($this->once())
      ->method('getRouteParam')
      ->with('page')
      ->willReturn(2);

    $fakeNewsData = [
      'data' => ['news1', 'news2'],
      'totalPages' => 3,
      'currentPage' => 2
    ];

    $this->siteService->expects($this->once())
      ->method('getNews')
      ->with(2)
      ->willReturn($fakeNewsData);

    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with([
        'page' => 'news',
        'content' => ['news1', 'news2'],
        'numberOfRows' => $fakeNewsData['totalPages'],
        'currentNumberOfPage' => $fakeNewsData['currentPage'],
        'contact' => []
      ]);

    // WHEN
    $this->controller->newsAction();
  
  }

  public function testShouldRenderTimetablePageWithWhenActionIsTimetable(): void
  {
    // GIVEN
    $fakeContent = ['title' => 'Witaj w grafiku'];
    $this->siteService->expects($this->once())
      ->method('getTimetable')
      ->willReturn($fakeContent);

    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    // EXPECTS
    $expectParams = [
      'page' => 'timetable',
      'content' => $fakeContent,
      'contact' => []
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->timetableAction();
  }

  public function testShouldFetchGalleryFromGivenCategoryAndRenderItWhenActionIsGallery(): void
  {
    // GIVEN 
    $this->request->expects($this->once())
      ->method('getRouteParam')
      ->with('category')
      ->willReturn('camp');

    $this->siteService->expects($this->once())
      ->method('getGallery')
      ->with('camp')
      ->willReturn(['img1', 'img2']);

    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with([
        'page' => 'gallery',
        'content' => ['img1', 'img2'],
        'contact' => []
      ]);

    // WHEN
    $this->controller->galleryAction();
  }

  public function testShouldRenderCampPageWhenActionIsCamp(): void
  {
    // GIVENs
    $fakeContent = ['title' => 'O obozie'];
    $this->siteService->expects($this->once())
      ->method('getCamp')
      ->willReturn($fakeContent);

    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    // EXPECTS
    $expectParams = [
      'page' => 'camp-info',
      'content' => $fakeContent,
      'contact' => []
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->campAction();
  }


  public function testShouldRenderFeesPageWhenActionIsFees(): void
  {
    // GIVEN
    $fakeContent = ['title' => 'Opłaty'];
    $this->siteService->expects($this->once())
      ->method('getFees')
      ->willReturn($fakeContent);

    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    // EXPECTS
    $expectParams = [
      'page' => 'fees-info',
      'content' => $fakeContent,
      'contact' => []
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->feesAction();
  }

  public function testShouldRenderRegistrationPageWhenActionIsRegistration(): void
  {
    // GIVEN
    $fakeContent = ['title' => 'obłaty'];
    $this->siteService->expects($this->once())
      ->method('getFees')
      ->willReturn($fakeContent);

    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    // EXPECTS
    $expectParams = [
      'page' => 'entries-info',
      'content' => $fakeContent,
      'contact' => []
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->registrationAction();
  }

  public function testShouldRenderContactPageWhenActionIsContact(): void
  {
    // GIVEN
    $fakeContent = ['email' => 'test@gmail.com'];
    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn($fakeContent);

    // EXPECTS
    $expectParams = [
      'page' => 'contact',
      'contact' => $fakeContent,
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->contactAction();
  }

  public function testShouldRenderStatutePageWhenActionIsStatute(): void
  {
    // GIVEN
    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    // EXPECTS
    $expectParams = [
      'page' => 'statute',
      'contact' => []
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->statuteAction();
  }

  public function testShouldRenderOyamaPageWhenActionIsOyama(): void
  {
    // GIVEN
    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    // EXPECTS
    $expectParams = [
      'page' => 'oyama',
      'contact' => []
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->oyamaAction();
  }

  public function testShouldRenderDojoOathPageWhenActionIsDojoOath(): void
  {
    // GIVEN
    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);
    
    // EXPECTS
    $expectParams = [
      'page' => 'dojo-oath',
      'contact' => []
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->dojoOathAction();
  }

  public function testShouldRenderRequirementsPageWhenActionIsRequirements(): void
  {
    // GIVEN
    $this->siteService->expects($this->once())
      ->method('getContact')
      ->willReturn([]);

    // EXPECTS
    $expectParams = [
      'page' => 'requirements',
      'contact' => []
    ];

    $this->view->expects($this->once())
      ->method('renderPageView')
      ->with($expectParams);

    // WHEN
    $this->controller->requirementsAction();
  }
}