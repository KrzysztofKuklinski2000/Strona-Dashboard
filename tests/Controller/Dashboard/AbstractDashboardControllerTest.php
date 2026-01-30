<?php 

namespace Tests\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use PHPUnit\Framework\TestCase;
use App\Middleware\CsrfMiddleware;
use App\Exception\NotFoundException;
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

  public function testShouldRedirectToListIfMethodIsNotPostWhenUpdateActionIsCalled(): void
  {
    // GIVEN 
    $this->request->method('isPost')
      ->willReturn(false);

    // WHEN
    $this->controller->updateAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }

  public function testShouldUpdateEntryAndRedirectOnSuccessWhenUpdateActionIsCalled(): void
  {
    // GIVEN
    $this->request->method('isPost')
      ->willReturn(true);

    $this->csrfMiddleware->expects($this->once())->method('verify');

    $this->request->method('getErrors')
      ->willReturn([]);

    $this->request->expects($this->once())
      ->method('setSession')
      ->with('flash', ['type' => 'success', 'message' => 'Udało się edytować']);

    // WHEN 
    $this->controller->updateAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }

  public function testShouldReturnToFormIfValidationFailsWhenUpdateActionIsCalled(): void
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
      ->with('flash', ['type' => 'errors', 'message' => ['some' => 'errors']]);

    // WHEN 
    $this->controller->updateAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module&action=edit&id=1', $this->controller->redirectUrl);
  }

  public function testShouldRedirectToListIfMethodIsNotPostWhenDeleteActionIsCalled(): void
  {
    // GIVEN 
    $this->request->method('isPost')
      ->willReturn(false);

    // WHEN
    $this->controller->deleteAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }

  public function testShouldDeleteEntryAndRedirectToListWhenUpdateActionIsCalled(): void
  {
    // GIVEN
    $this->request->method('isPost')
      ->willReturn(true);

    $this->csrfMiddleware->expects($this->once())->method('verify');

    $this->request->method('getFormParam')
      ->with('postId')
      ->willReturn(1);

    $this->request->expects($this->once())
      ->method('setSession')
      ->with('flash', ['type' => 'success', 'message' => 'Udało się usunąć']);

    // WHEN 
    $this->controller->deleteAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }

  public function testShouldRedirectToListIfMethodIsNotPostWhenPublishedActionIsCalled(): void
  {
    // GIVEN 
    $this->request->method('isPost')
      ->willReturn(false);

    // WHEN
    $this->controller->publishedAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }

  public function testShouldPublishEntryAndRedirectToListWhenPublishedActionIsCalled(): void
  {
    // GIVEN
    $this->request->method('isPost')
      ->willReturn(true);

    $this->csrfMiddleware->expects($this->once())->method('verify');


    $this->request->expects($this->once())
      ->method('setSession')
      ->with('flash', ['type' => 'info', 'message' => 'Udało się zmienić status']);

    // WHEN 
    $this->controller->publishedAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }


  public function testShouldMoveEntryWhenMoveActionIsCalled(): void
  {
    // GIVEN
    $this->request->method('isPost')
      ->willReturn(true);

    $this->csrfMiddleware->expects($this->once())->method('verify');

    // WHEN 
    $this->controller->moveAction();

    // THEN
    $this->assertEquals('/?dashboard=test_module', $this->controller->redirectUrl);
  }

  public function testShouldThrowExceptionIfIdIsMissingWhenGetSingleDataIsCalled(): void
  {
    // GIVEN
    $this->request->method('getQueryParam')
      ->with('id')
      ->willReturn(null);

    // EXPECTS
    $this->expectException(NotFoundException::class);
    $this->expectExceptionMessage("Required 'id' parameter is missing or invalid");

    // WHEN
    $this->controller->exposeGetSingleData();
  }

  public function testShouldThrowExceptionIfIdIsNotIntegerWhenGetSingleDataIsCalled(): void
  {
    // GIVEN
    $this->request->method('getQueryParam')
      ->with('id')
      ->willReturn('test');

    // EXPECTS
    $this->expectException(NotFoundException::class);
    $this->expectExceptionMessage("Required 'id' parameter is missing or invalid");

    // WHEN
    $this->controller->exposeGetSingleData();
  }

  public function testShouldReturnDataFromServiceWhenGetSingleDataIsCalled(): void
  {
    // GIVEN
    $this->request->method('getQueryParam')
      ->with('id')
      ->willReturn('15');

    $this->dataService->expects($this->once())
      ->method('getPost')
      ->with(15, 'test_module')
      ->willReturn(['id' => 15, 'title' => 'Test']);

    // WHEN
    $result = $this->controller->exposeGetSingleData();

    // THEN
    $this->assertEquals(['id' => 15, 'title' => 'Test'], $result);
  }

  public function testShouldRenderPageWithFlashMessageAndCsrfToken(): void
  {
    // GIVEN
    $this->request->method('getSession')
      ->with('flash')
      ->willReturn(['type' => 'info', 'message' => 'test']);

    $this->csrfMiddleware->method('generateToken')
      ->willReturn('test_token');

    // EXPECTS
    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'test',
        'flash' => ['type' => 'info', 'message' => 'test'],
        'csrf_token' => 'test_token'             
      ]);

    // WHEN
    $this->controller->exposeRenderPage(['page' => 'test']);
  }

  public function testGetTableNameShouldReturnModuleName(): void
  {
    $this->assertEquals('test_module', $this->controller->exposeGetTableName());
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

  protected function getDataToUpdate(): array
  {
    return ['id' => 1, 'some' => 'data'];
  }

  protected function getDataToPublished(): array
  {
    return [
      'published' => 1,
      'id' => 1
    ];
  }

  protected function getDataToChangePostPosition(): array
  {
    return [
      'id' => 1,
      'dir' => 'up'
    ];
  }


  protected function handleCreate(array $data): void {}

  protected function handleUpdate(array $data): void {}

  protected function handleDelete(int $id): void {}

  protected function handlePublish(array $data): void {}

  protected function handleMove(array $data): void {}

  public function redirect(string $to, int $statusCode = 302)
  {
    $this->redirectUrl = $to;
  }

  public function exposeRenderPage(array $params): void
  {
    $this->renderPage($params);
  }

  public function exposeGetSingleData(): array
  {
    return $this->getSingleData();
  }

  public function exposeGetTableName(): string
  {
    return $this->getTableName();
  }
}