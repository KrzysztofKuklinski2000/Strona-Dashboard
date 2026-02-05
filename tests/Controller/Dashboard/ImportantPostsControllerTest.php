<?php

namespace Tests\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use App\Controller\Dashboard\ImportantPostsController;
use App\Service\Dashboard\ImportantPostsManagementServiceInterface;

class ImportantPostsControllerTest extends TestCase 
{
  private ImportantPostsManagementServiceInterface | MockObject $importantPostsService;
  private Request | MockObject $request;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private ActionResolver | MockObject $actionResolver;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private ImportantPostsController | MockObject $controller;


  public function setUp(): void
  {
    $this->importantPostsService = $this->createMock(ImportantPostsManagementServiceInterface::class);
    $this->request = $this->createMock(Request::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->actionResolver = $this->createMock(ActionResolver::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);

    $this->controller = $this->getMockBuilder(ImportantPostsController::class)
      ->setConstructorArgs([
        $this->importantPostsService,
        $this->request,
        $this->easyCSRF,
        $this->view,
        $this->actionResolver,
        $this->csrfMiddleware
      ])
      ->onlyMethods(['redirect'])
      ->getMock();
  }

  public function testShouldRenderImportantPostsListViewWithDataAndCsrfTokenWhenActionIsIndex(): void
  {
    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->importantPostsService->expects($this->once())
      ->method('getAllImportantPosts')
      ->willReturn(['title' => 'test']);

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'important_posts/index',
        'data' => ['title' => 'test'],
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->indexAction();
  }

  public function testShouldRenderImportantPostsEditViewWithSinglePostDataAndCsrfTokenWhenActionIsEdit(): void
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
    $this->importantPostsService->expects($this->once())
      ->method('getPost')
      ->with(1, 'important_posts')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'important_posts/edit',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->editAction();
  }

  public function testShouldRenderImportantPostsCreateViewWithCsrfTokenWhenActionIsCreate(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'important_posts/create',
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->createAction();
  }

  public function testShouldRenderImportantPostsShowViewWithCsrfTokenWhenActionIsShow(): void
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
    $this->importantPostsService->expects($this->once())
      ->method('getPost')
      ->with(1, 'important_posts')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'important_posts/show',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->showAction();
  }

  public function testShouldRenderImportantPostsConfirmDeleteViewWithCsrfTokenWhenActionIsConfirmDelete(): void
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
    $this->importantPostsService->expects($this->once())
      ->method('getPost')
      ->with(1, 'important_posts')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'important_posts/delete',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->confirmDeleteAction();
  }

  public function testShouldReturnImportantPostsWhenMethodGetModuleNameIsCalled(): void
  {
    //GIVEN 
    $method = new \ReflectionMethod(ImportantPostsController::class, 'getModuleName');
    $method->setAccessible(true);

    //WHEN
    $result = $method->invoke($this->controller);

    //THEN
    $this->assertEquals('important_posts', $result);
  }


  public function testShouldReturnDataToUpdateWhenMethodGetDataToUpdateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(ImportantPostsController::class, 'getDataToUpdate');
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

    $method = new \ReflectionMethod(ImportantPostsController::class, 'getDataToCreate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals(date('Y-m-d'), $result['created']);
    $this->assertEquals('postDescription', $result['description']);
  }

  public function testShouldCallServiceToUpdateImportantPostsWhenActionIsHandleUpdate(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'title' => 'test'];
    $method = new \ReflectionMethod(ImportantPostsController::class, 'handleUpdate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->importantPostsService->expects($this->once())
      ->method('updateImportantPost')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToCreateImportantPostsWhenActionIsHandleCreate(): void
  {
    // GIVEN 
    $data = ['title' => 'test'];
    $method = new \ReflectionMethod(ImportantPostsController::class, 'handleCreate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->importantPostsService->expects($this->once())
      ->method('createImportantPost')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToDeleteImportantPostsWhenActionIsHandleDelete(): void
  {
    // GIVEN 
    $id = 1;
    $method = new \ReflectionMethod(ImportantPostsController::class, 'handleDelete');
    $method->setAccessible(true);

    // EXPECTS 
    $this->importantPostsService->expects($this->once())
      ->method('deleteImportantPost')
      ->with($id);

    // WHEN 
    $method->invoke($this->controller, $id);
  }

  public function testShouldCallServiceToPublishImportantPostsWhenActionIsHandlePublish(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'published' => 1];
    $method = new \ReflectionMethod(ImportantPostsController::class, 'handlePublish');
    $method->setAccessible(true);

    // EXPECTS 
    $this->importantPostsService->expects($this->once())
      ->method('publishedImportantPost')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToMoveImportantPostsWhenActionIsHandleMove(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'dir' => 'up'];
    $method = new \ReflectionMethod(ImportantPostsController::class, 'handleMove');
    $method->setAccessible(true);

    // EXPECTS 
    $this->importantPostsService->expects($this->once())
      ->method('moveImportantPost')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }
}