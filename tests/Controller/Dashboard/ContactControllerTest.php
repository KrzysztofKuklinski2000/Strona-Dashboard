<?php

namespace Tests\Controller;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use App\Controller\Dashboard\ContactController;
use PHPUnit\Framework\MockObject\MockObject;
use App\Service\Dashboard\ContactManagementServiceInterface;

class ContactControllerTest extends TestCase
{
  private Request | MockObject $request;
  private ContactManagementServiceInterface | MockObject $contactService;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private ActionResolver | MockObject $actionResolver;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private ContactController | MockObject $controller;

  public function setUp(): void
  {
    $this->request = $this->createMock(Request::class);
    $this->contactService = $this->createMock(ContactManagementServiceInterface::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->actionResolver = $this->createMock(ActionResolver::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);


    $this->controller = $this->getMockBuilder(ContactController::class)
      ->setConstructorArgs([
        $this->contactService,
        $this->request,
        $this->easyCSRF,
        $this->view,
        $this->actionResolver,
        $this->csrfMiddleware
      ])
      ->onlyMethods(['redirect'])
      ->getMock();
  }

  public function testShouldRedirectToEditPageWhenActionIsIndex(): void
  {
    // GIVEN 
    $this->controller->expects($this->once())
      ->method('redirect')
      ->with('/?dashboard=contact&action=edit');

    // WHEN
    $this->controller->indexAction();
  }

  public function testShouldRenderViewWithCsrfTokenWhenActionIsEdit(): void
  {
    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->contactService->expects($this->once())
      ->method('getContact')
      ->willReturn(['email' => 'test@gmail.com']);

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'contact/edit',
        'data' => ['email' => 'test@gmail.com'],
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN 
    $this->controller->editAction();
  }

  public function testShouldReturnCampWhenMethodGetModuleNameIsCalled(): void
  {
    //GIVEN 
    $method = new \ReflectionMethod(ContactController::class, 'getModuleName');
    $method->setAccessible(true);

    //WHEN
    $result = $method->invoke($this->controller);

    //THEN
    $this->assertEquals('contact', $result);
  }

  public function testShouldReturnDataToUpdateWhenMethodGetDataToUpdateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(ContactController::class, 'getDataToUpdate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals('email', $result['email']);
    $this->assertEquals('phone', $result['phone']);
  }

  public function testShouldCallServiceToUpdateCampWhenActionIsHandleUpdate(): void
  {
    // GIVEN 
    $data = ['email' => 'test@gmail.com'];
    $method = new \ReflectionMethod(ContactController::class, 'handleUpdate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->contactService->expects($this->once())
      ->method('updateContact')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }
}
