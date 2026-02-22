<?php

namespace Tests\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use App\Controller\Dashboard\TimetableController;
use App\Service\Dashboard\TimeTableManagementServiceInterface;

class TimetableControllerTest extends TestCase
{
  private TimeTableManagementServiceInterface | MockObject $timetableService;
  private Request | MockObject $request;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private TimetableController | MockObject $controller;


  public function setUp(): void
  {
    $this->timetableService = $this->createMock(TimeTableManagementServiceInterface::class);
    $this->request = $this->createMock(Request::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);

    $this->controller = $this->getMockBuilder(TimetableController::class)
      ->setConstructorArgs([
        $this->timetableService,
        $this->request,
        $this->easyCSRF,
        $this->view,
        $this->csrfMiddleware
      ])
      ->onlyMethods(['redirect'])
      ->getMock();
  }

  public function testShouldRenderTimetableListViewWithDataAndCsrfTokenWhenActionIsIndex(): void
  {
    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->timetableService->expects($this->once())
      ->method('getAllTimetable')
      ->willReturn(['id' => 1, 'city' => 'Reda']);

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'timetable/index',
        'data' => ['id' => 1, 'city' => 'Reda'],
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->indexAction();
  }

  public function testShouldRenderTimetableEditViewWithSinglePostDataAndCsrfTokenWhenActionIsEdit(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getRouteParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'city' => 'Reda'];
    $this->timetableService->expects($this->once())
      ->method('getPost')
      ->with(1, 'timetable')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'timetable/edit',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->editAction();
  }

  public function testShouldRenderTimetableCreateViewWithCsrfTokenWhenActionIsCreate(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'timetable/create',
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->createAction();
  }

  public function testShouldRenderTimetableShowViewWithCsrfTokenWhenActionIsShow(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getRouteParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'city' => 'reda'];
    $this->timetableService->expects($this->once())
      ->method('getPost')
      ->with(1, 'timetable')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'timetable/show',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->showAction();
  }

  public function testShouldRenderTimetableConfirmDeleteViewWithCsrfTokenWhenActionIsConfirmDelete(): void
  {
    // GIVEN
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->request->expects($this->once())
      ->method('getRouteParam')
      ->with('id')
      ->willReturn(1);

    $data = ['id' => 1, 'city' => 'reda'];
    $this->timetableService->expects($this->once())
      ->method('getPost')
      ->with(1, 'timetable')
      ->willReturn($data);

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'timetable/delete',
        'data' => $data,
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->confirmDeleteAction();
  }

  public function testShouldReturnTimetableWhenMethodGetModuleNameIsCalled(): void
  {
    //GIVEN 
    $method = new \ReflectionMethod(TimetableController::class, 'getModuleName');
    $method->setAccessible(true);

    //WHEN
    $result = $method->invoke($this->controller);

    //THEN
    $this->assertEquals('timetable', $result);
  }


  public function testShouldReturnDataToUpdateWhenMethodGetDataToUpdateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(TimetableController::class, 'getDataToUpdate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals('group', $result['advancement_group']);
    $this->assertEquals('day', $result['day']);
    $this->assertEquals('city', $result['city']);
  }

  public function testShouldReturnDataToCreateWhenMethodGetDataToCreateIsCalled(): void
  {
    // GIVEN 
    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(TimetableController::class, 'getDataToCreate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals('group', $result['advancement_group']);
    $this->assertEquals('day', $result['day']);
    $this->assertEquals('city', $result['city']);
  }

  public function testShouldCallServiceToUpdateTimetableWhenActionIsHandleUpdate(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'city' => 'reda'];
    $method = new \ReflectionMethod(TimetableController::class, 'handleUpdate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->timetableService->expects($this->once())
      ->method('updateTimetable')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToCreateTimetableWhenActionIsHandleCreate(): void
  {
    // GIVEN 
    $data = ['city' => 'reda'];
    $method = new \ReflectionMethod(TimetableController::class, 'handleCreate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->timetableService->expects($this->once())
      ->method('createTimetable')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToDeleteTimetableWhenActionIsHandleDelete(): void
  {
    // GIVEN 
    $id = 1;
    $method = new \ReflectionMethod(TimetableController::class, 'handleDelete');
    $method->setAccessible(true);

    // EXPECTS 
    $this->timetableService->expects($this->once())
      ->method('deleteTimetable')
      ->with($id);

    // WHEN 
    $method->invoke($this->controller, $id);
  }

  public function testShouldCallServiceToPublishTimetableWhenActionIsHandlePublish(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'published' => 1];
    $method = new \ReflectionMethod(TimetableController::class, 'handlePublish');
    $method->setAccessible(true);

    // EXPECTS 
    $this->timetableService->expects($this->once())
      ->method('publishedTimetable')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }

  public function testShouldCallServiceToMoveTimetableWhenActionIsHandleMove(): void
  {
    // GIVEN 
    $data = ['id' => 1, 'dir' => 'up'];
    $method = new \ReflectionMethod(TimetableController::class, 'handleMove');
    $method->setAccessible(true);

    // EXPECTS 
    $this->timetableService->expects($this->once())
      ->method('moveTimetable')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }
}
