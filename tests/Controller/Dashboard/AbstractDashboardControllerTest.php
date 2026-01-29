<?php 

namespace Tests\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use PHPUnit\Framework\TestCase;
use App\Controller\AuthController;
use App\Middleware\CsrfMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use App\Service\Dashboard\SharedGetDataServiceInterface;
use App\Controller\Dashboard\AbstractDashboardController;

class AbstractDashboardControllerTest extends TestCase 
{
  private Request | MockObject $request;
  private SharedGetDataServiceInterface | MockObject $dataService;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private ActionResolver | MockObject $actionResolver;
  private CsrfMiddleware | MockObject $csrfMiddleware;

  private TestController $controller;

  public function setUp(): void 
  {
    $this->request = $this->createMock(Request::class);
    $this->dataService = $this->createMock(SharedGetDataServiceInterface::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->actionResolver = $this->createMock(ActionResolver::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);

    $this->controller = new TestController(
      $this->request,
      $this->easyCSRF,
      $this->dataService,
      $this->view,
      $this->actionResolver,
      $this->csrfMiddleware
    );
  }

  public function testShouldRedirectToListIfMethodIsNotPostWhenStoreActionIsCalled(): void 
  {
    // GIVEN 
    $this->request->method('isPost')
      ->willReturn(false);

    // WHEN
    $this->controller->storeAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }
  

  public function testShouldCreateEntryAndRedirectOnSuccessWhenStoreActionIsCalled(): void 
  {
    // GIVEN
    $this->request->method('isPost')
      ->willReturn(true);

    $this->csrfMiddleware->expects($this->once())->method('verify');

    $this->request->method('getErrors')
      ->willReturn([]);

    $this->request->expects($this->once())
      ->method('setSession')
      ->with('flash', ['type' => 'success', 'message' => 'Udało się utworzyć nowy wpis']);
    
    // WHEN 
    $this->controller->storeAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }

  public function testShouldReturnToFormIfValidationFailsWhenStoreActionIsCalled(): void 
  {
    // GIVEN
    $this->request->method('isPost')
      ->willReturn(true);

    $this->request->method('getErrors')
      ->willReturn(['some' => 'errors']);

    // EXPECTS
    $this->csrfMiddleware->expects($this->once())->method('verify');

    $this->request->expects($this->once())
      ->method('setSession')
      ->with('flash', ['type' => 'errors', 'message' => ['some' => 'errors'] ]);

    // WHEN 
    $this->controller->storeAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module&action=create', $this->controller->redirectUrl);
  }
}


class TestController extends AbstractDashboardController {
  public ?string $redirectUrl = null;

  protected function getModuleName(): string
  {
    return 'test_module';
  }

  protected function getDataToCreate(): array
  {
    return ['some' => 'data'];
  }

  protected function handleCreate(array $data): void {}

  public function redirect(string $to, int $statusCode = 302)
  {
    $this->redirectUrl = $to;
  }
}