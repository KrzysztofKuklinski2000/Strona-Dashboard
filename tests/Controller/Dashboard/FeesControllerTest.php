<?php

namespace Tests\Controller;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use App\Controller\Dashboard\FeesController;
use PHPUnit\Framework\MockObject\MockObject;
use App\Service\Dashboard\FeesManagementServiceInterface;

class FeesControllerTest extends TestCase
{
  private Request | MockObject $request;
  private FeesManagementServiceInterface | MockObject $feesService;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private ActionResolver | MockObject $actionResolver;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private FeesController | MockObject $controller;

  public function setUp(): void
  {
    $this->request = $this->createMock(Request::class);
    $this->feesService = $this->createMock(FeesManagementServiceInterface::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->actionResolver = $this->createMock(ActionResolver::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);


    $this->controller = $this->getMockBuilder(FeesController::class)
      ->setConstructorArgs([
        $this->feesService,
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
      ->with('/?dashboard=fees&action=edit');

    // WHEN
    $this->controller->indexAction();
  }

  public function testShouldRenderViewWithCsrfTokenWhenActionIsEdit(): void
  {
    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->feesService->expects($this->once())
      ->method('getFees')
      ->willReturn(['reduced_contribution_1_month' => 150]);

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'fees/edit',
        'data' => ['reduced_contribution_1_month' => 150],
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN 
    $this->controller->editAction();
  }

  public function testShouldReturnFeesWhenMethodGetModuleNameIsCalled(): void
  {
    //GIVEN 
    $method = new \ReflectionMethod(FeesController::class, 'getModuleName');
    $method->setAccessible(true);

    //WHEN
    $result = $method->invoke($this->controller);

    //THEN
    $this->assertEquals('fees', $result);
  }

  public function testShouldReturnDataToUpdateWhenMethodGetDataToUpdateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(FeesController::class, 'getDataToUpdate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals('n1', $result['reduced_contribution_1_month']);
  }

  public function testShouldCallServiceToUpdateFeesWhenActionIsHandleUpdate(): void
  {
    // GIVEN 
    $data = ['reduced_contribution_1_month' => 150];
    $method = new \ReflectionMethod(FeesController::class, 'handleUpdate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->feesService->expects($this->once())
      ->method('updateFees')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }
}
