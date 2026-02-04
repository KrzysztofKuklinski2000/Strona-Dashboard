<?php 

namespace Tests\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use App\Controller\Dashboard\CampController;
use PHPUnit\Framework\MockObject\MockObject;
use App\Service\Dashboard\CampManagementServiceInterface;

class CampControllerTest extends TestCase {
  private Request | MockObject $request;
  private CampManagementServiceInterface | MockObject $campService;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private ActionResolver | MockObject $actionResolver;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private CampController | MockObject $controller;

  public function setUp(): void
  {
    $this->request = $this->createMock(Request::class);
    $this->campService = $this->createMock(CampManagementServiceInterface::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->actionResolver = $this->createMock(ActionResolver::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);


    $this->controller = $this->getMockBuilder(CampController::class)
      ->setConstructorArgs([
        $this->campService,
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
      ->with('/?dashboard=camp&action=edit');

    // WHEN
    $this->controller->indexAction();

  }

  public function testShouldRenderViewWithCsrfTokenWhenActionIsEdit(): void {
    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->campService->expects($this->once())
      ->method('getCamp')
      ->willReturn(['city' => 'Warszawa']);

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'camp/edit',
        'data' => ['city' => 'Warszawa'],
        'flash' => null,
        'csrf_token' => 'token'
      ]);

    // WHEN 
    $this->controller->editAction();
  }

  public function testShouldReturnCampWhenMethodGetModuleNameIsCalled(): void {
    //GIVEN 
    $method = new \ReflectionMethod(CampController::class, 'getModuleName');
    $method->setAccessible(true);
    
    //WHEN
    $result = $method->invoke($this->controller);

    //THEN
    $this->assertEquals('camp', $result);
  }

  public function testShouldReturnDataToUpdateWhenMethodGetDataToUpdateIsCalled(): void
  {
    // GIVEN 
    $inputData = [
      'town' => 'Warszawa', 
      'cost' => 1200
    ];

    $this->request->method('validate')
      ->willReturnArgument(0);

    $method = new \ReflectionMethod(CampController::class, 'getDataToUpdate');
    $method->setAccessible(true);

    // WHEN
    $result = $method->invoke($this->controller);

    // THEN
    $this->assertEquals('town', $result['city']);
    $this->assertEquals('cost', $result['cost']);
    $this->assertEquals('transport', $result['transport']);
  }

  public function testShouldCallServiceToUpdateCampWhenActionIsHandleUpdate(): void 
  {
    // GIVEN 
    $data = ['city' => 'Warszawa'];
    $method = new \ReflectionMethod(CampController::class, 'handleUpdate');
    $method->setAccessible(true);

    // EXPECTS 
    $this->campService->expects($this->once())
      ->method('updateCamp')
      ->with($data);

    // WHEN 
    $method->invoke($this->controller, $data);
  }
}