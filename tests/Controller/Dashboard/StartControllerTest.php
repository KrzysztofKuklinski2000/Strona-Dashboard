<?php

namespace Tests\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use App\Controller\Dashboard\StartController;
use App\Service\Dashboard\StartManagementServiceInterface;

class StartControllerTest extends TestCase
{
  private StartManagementServiceInterface | MockObject $startService;
  private Request | MockObject $request;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private ActionResolver | MockObject $actionResolver;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private StartController | MockObject $controller;


  public function setUp(): void
  {
    $this->startService = $this->createMock(StartManagementServiceInterface::class);
    $this->request = $this->createMock(Request::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->actionResolver = $this->createMock(ActionResolver::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);

    $this->controller = $this->getMockBuilder(StartController::class)
      ->setConstructorArgs([
        $this->startService,
        $this->request,
        $this->easyCSRF,
        $this->view,
        $this->actionResolver,
        $this->csrfMiddleware
      ])
      ->onlyMethods(['redirect'])
      ->getMock();
  }

  public function testShouldRenderStartListViewWithDataAndCsrfTokenWhenActionIsIndex(): void
  {
    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->startService->expects($this->once())
      ->method('getAllMain')
      ->willReturn(['title' => 'test']);

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'start/index',
        'data' => ['title' => 'test'],
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->indexAction();
  }

  public function testShouldRenderStartEditViewWithSinglePostDataAndCsrfTokenWhenActionIsEdit(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getQueryParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'title' => 'test'];
    $this->startService->expects($this->once())
      ->method('getPost')
      ->with(1, 'main_page_posts')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'start/edit',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->editAction();
  }

  public function testShouldRenderStartCreateViewWithCsrfTokenWhenActionIsCreate(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'start/create',
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->createAction();
  }

  public function testShouldRenderStartShowViewWithCsrfTokenWhenActionIsShow(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getQueryParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'title' => 'test'];
    $this->startService->expects($this->once())
      ->method('getPost')
      ->with(1, 'main_page_posts')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'start/show',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->showAction();
  }

  public function testShouldRenderStartConfirmDeleteViewWithCsrfTokenWhenActionIsConfirmDelete(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getQueryParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'title' => 'test'];
    $this->startService->expects($this->once())
      ->method('getPost')
      ->with(1, 'main_page_posts')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'start/delete',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->confirmDeleteAction();
  }

  public function testShouldReturnStartWhenMethodGetModuleNameIsCalled(): void
  {
    //GIVEN 
    $method = new \ReflectionMethod(StartController::class, 'getModuleName');
    $method->setAccessible(true);

    //WHEN
    $result = $method->invoke($this->controller);

    //THEN
    $this->assertEquals('start', $result);
  }


  public function testShouldReturnDataToUpdateWhenMethodGetDataToUpdateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(StartController::class, 'getDataToUpdate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals(date('Y-m-d'), $result['updated']);
    $this->assertEquals('postDescription', $result['description']);
    $this->assertEquals('postId', $result['id']);
  }

  public function testShouldReturnDataToCreateWhenMethodGetDataToCreateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(StartController::class, 'getDataToCreate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals(date('Y-m-d'), $result['created']);
    $this->assertEquals('postDescription', $result['description']);
  }

  public function testShouldCallServiceToUpdateStartWhenActionIsHandleUpdate(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'title' => 'test'];
    $method = new \ReflectionMethod(StartController::class, 'handleUpdate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->startService->expects($this->once())
      ->method('updateMain')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToCreateStartWhenActionIsHandleCreate(): void
  {
    // GIVEN 
    $data = ['title' => 'test'];
    $method = new \ReflectionMethod(StartController::class, 'handleCreate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->startService->expects($this->once())
      ->method('createMain')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToDeleteStartWhenActionIsHandleDelete(): void
  {
    // GIVEN 
    $id = 1;
    $method = new \ReflectionMethod(StartController::class, 'handleDelete');
    $method->setAccessible(true);

    // EXPECTS 
    $this->startService->expects($this->once())
      ->method('deleteMain')
      ->with($id);

    // WHEN 
    $method->invoke($this->controller, $id);
  }

  public function testShouldCallServiceToPublishStartWhenActionIsHandlePublish(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'published' => 1];
    $method = new \ReflectionMethod(StartController::class, 'handlePublish');
    $method->setAccessible(true);

    // EXPECTS 
    $this->startService->expects($this->once())
      ->method('publishedMain')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToMoveStartWhenActionIsHandleMove(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'dir' => 'up'];
    $method = new \ReflectionMethod(StartController::class, 'handleMove');
    $method->setAccessible(true);

    // EXPECTS 
    $this->startService->expects($this->once())
      ->method('moveMain')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }
}
