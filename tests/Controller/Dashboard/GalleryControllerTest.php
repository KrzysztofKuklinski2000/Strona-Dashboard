<?php

namespace Tests\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use App\Controller\Dashboard\GalleryController;
use App\Service\Dashboard\GalleryManagementServiceInterface;

class GalleryControllerTest extends TestCase 
{
  private GalleryManagementServiceInterface | MockObject $galleryService;
  private Request | MockObject $request;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private GalleryController | MockObject $controller;


  public function setUp(): void
  {
    $this->galleryService = $this->createMock(GalleryManagementServiceInterface::class);
    $this->request = $this->createMock(Request::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);

    $this->controller = $this->getMockBuilder(GalleryController::class)
      ->setConstructorArgs([
        $this->galleryService,
        $this->request,
        $this->easyCSRF,
        $this->view,
        $this->csrfMiddleware
      ])
      ->onlyMethods(['redirect'])
      ->getMock();
  }

  public function testShouldRenderGalleryListViewWithDataAndCsrfTokenWhenActionIsIndex(): void
  {
    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->galleryService->expects($this->once())
      ->method('getAllGallery')
      ->willReturn(['gallery' => 'test']);

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'gallery/index',
        'data' => ['gallery' => 'test'],
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->indexAction();
  }

  public function testShouldRenderGalleryEditViewWithSinglePostDataAndCsrfTokenWhenActionIsEdit(): void
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
    $this->galleryService->expects($this->once())
      ->method('getPost')
      ->with(1, 'gallery')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'gallery/edit',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->editAction();
  }

  public function testShouldRenderGalleryCreateViewWithCsrfTokenWhenActionIsCreate(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'gallery/create',
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->createAction();
  }

  public function testShouldRenderGalleryShowViewWithCsrfTokenWhenActionIsShow(): void
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
    $this->galleryService->expects($this->once())
      ->method('getPost')
      ->with(1, 'gallery')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'gallery/show',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->showAction();
  }

  public function testShouldRenderGalleryConfirmDeleteViewWithCsrfTokenWhenActionIsConfirmDelete(): void
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
    $this->galleryService->expects($this->once())
      ->method('getPost')
      ->with(1, 'gallery')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'gallery/delete',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->confirmDeleteAction();
  }

  public function testShouldReturnGalleryWhenMethodGetModuleNameIsCalled(): void
  {
    //GIVEN 
    $method = new \ReflectionMethod(GalleryController::class, 'getModuleName');
    $method->setAccessible(true);

    //WHEN
    $result = $method->invoke($this->controller);

    //THEN
    $this->assertEquals('gallery', $result);
  }


  public function testShouldReturnDataToUpdateWhenMethodGetDataToUpdateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(GalleryController::class, 'getDataToUpdate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals('category', $result['category']);
    $this->assertEquals('description', $result['description']);
    $this->assertEquals('id', $result['id']);
  }

  public function testShouldReturnDataToCreateWhenMethodGetDataToCreateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(GalleryController::class, 'getDataToCreate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals('category', $result['category']);
    $this->assertEquals('description', $result['description']);
  }

  public function testShouldCallServiceToUpdateGalleryWhenActionIsHandleUpdate(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'title' => 'test'];
    $method = new \ReflectionMethod(GalleryController::class, 'handleUpdate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->galleryService->expects($this->once())
      ->method('updateGallery')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToCreateGalleryWhenActionIsHandleCreate(): void
  {
    // GIVEN 
    $data = ['title' => 'test'];
    $method = new \ReflectionMethod(GalleryController::class, 'handleCreate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->galleryService->expects($this->once())
      ->method('createGallery')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToDeleteGalleryWhenActionIsHandleDelete(): void
  {
    // GIVEN 
    $id = 1;
    $method = new \ReflectionMethod(GalleryController::class, 'handleDelete');
    $method->setAccessible(true);

    // EXPECTS 
    $this->galleryService->expects($this->once())
      ->method('deleteGallery')
      ->with($id);

    // WHEN 
    $method->invoke($this->controller, $id);
  }

  public function testShouldCallServiceToPublishGalleryWhenActionIsHandlePublish(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'published' => 1];
    $method = new \ReflectionMethod(GalleryController::class, 'handlePublish');
    $method->setAccessible(true);

    // EXPECTS 
    $this->galleryService->expects($this->once())
      ->method('publishedGallery')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToMoveGalleryWhenActionIsHandleMove(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'dir' => 'up'];
    $method = new \ReflectionMethod(GalleryController::class, 'handleMove');
    $method->setAccessible(true);

    // EXPECTS 
    $this->galleryService->expects($this->once())
      ->method('moveGallery')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }
  
}