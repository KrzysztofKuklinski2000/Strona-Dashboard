<?php

namespace Tests\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use App\Controller\Dashboard\NewsController;
use App\Service\Dashboard\NewsManagementServiceInterface;

class NewsControllerTest extends TestCase 
{
  private NewsManagementServiceInterface | MockObject $newsService;
  private Request | MockObject $request;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private NewsController | MockObject $controller;


  public function setUp(): void
  {
    $this->newsService = $this->createMock(NewsManagementServiceInterface::class);
    $this->request = $this->createMock(Request::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);

    $this->controller = $this->getMockBuilder(NewsController::class)
      ->setConstructorArgs([
        $this->newsService,
        $this->request,
        $this->easyCSRF,
        $this->view,
        $this->csrfMiddleware
      ])
      ->onlyMethods(['redirect'])
      ->getMock();
  }

  public function testShouldRenderNewsListViewWithDataAndCsrfTokenWhenActionIsIndex(): void
  {
    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->newsService->expects($this->once())
      ->method('getAllNews')
      ->willReturn(['title' => 'test']);

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'news/index',
        'data' => ['title' => 'test'],
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->indexAction();
  }

  public function testShouldRenderNewsEditViewWithSinglePostDataAndCsrfTokenWhenActionIsEdit(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getRouteParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'title' => 'test'];
    $this->newsService->expects($this->once())
      ->method('getPost')
      ->with(1, 'news')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'news/edit',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->editAction();
  }

  public function testShouldRenderNewsCreateViewWithCsrfTokenWhenActionIsCreate(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'news/create',
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->createAction();
  }

  public function testShouldRenderNewsShowViewWithCsrfTokenWhenActionIsShow(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getRouteParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'title' => 'test'];
    $this->newsService->expects($this->once())
      ->method('getPost')
      ->with(1, 'news')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'news/show',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->showAction();
  }

  public function testShouldRenderNewsConfirmDeleteViewWithCsrfTokenWhenActionIsConfirmDelete(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getRouteParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'title' => 'test'];
    $this->newsService->expects($this->once())
      ->method('getPost')
      ->with(1, 'news')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'news/delete',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->confirmDeleteAction();
  }

  public function testShouldReturnNewsWhenMethodGetModuleNameIsCalled(): void
  {
    //GIVEN 
    $method = new \ReflectionMethod(NewsController::class, 'getModuleName');
    $method->setAccessible(true);

    //WHEN
    $result = $method->invoke($this->controller);

    //THEN
    $this->assertEquals('news', $result);
  }


  public function testShouldReturnDataToUpdateWhenMethodGetDataToUpdateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(NewsController::class, 'getDataToUpdate');
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

    $method = new \ReflectionMethod(NewsController::class, 'getDataToCreate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals(date('Y-m-d'), $result['created']);
    $this->assertEquals('postDescription', $result['description']);
  }

  public function testShouldCallServiceToUpdateNewsWhenActionIsHandleUpdate(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'title' => 'test'];
    $method = new \ReflectionMethod(NewsController::class, 'handleUpdate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->newsService->expects($this->once())
      ->method('updateNews')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToCreateNewsWhenActionIsHandleCreate(): void
  {
    // GIVEN 
    $data = ['title' => 'test'];
    $method = new \ReflectionMethod(NewsController::class, 'handleCreate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->newsService->expects($this->once())
      ->method('createNews')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToDeleteNewsWhenActionIsHandleDelete(): void
  {
    // GIVEN 
    $id = 1;
    $method = new \ReflectionMethod(NewsController::class, 'handleDelete');
    $method->setAccessible(true);

    // EXPECTS 
    $this->newsService->expects($this->once())
      ->method('deleteNews')
      ->with($id);

    // WHEN 
    $method->invoke($this->controller, $id);
  }

  public function testShouldCallServiceToPublishNewsWhenActionIsHandlePublish(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'published' => 1];
    $method = new \ReflectionMethod(NewsController::class, 'handlePublish');
    $method->setAccessible(true);

    // EXPECTS 
    $this->newsService->expects($this->once())
      ->method('publishedNews')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToMoveNewsWhenActionIsHandleMove(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'dir' => 'up'];
    $method = new \ReflectionMethod(NewsController::class, 'handleMove');
    $method->setAccessible(true);

    // EXPECTS 
    $this->newsService->expects($this->once())
      ->method('moveNews')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }
}