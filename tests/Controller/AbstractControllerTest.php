<?php

namespace Tests\Controller;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Controller\AbstractController;
use PHPUnit\Framework\MockObject\MockObject;

class AbstractControllerTest extends TestCase
{
  private Request | MockObject $request;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private TestController $controller;

  public function setUp(): void
  {
    $this->request = $this->createMock(Request::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);


    $this->controller = new TestController(
      $this->request,
      $this->easyCSRF,
      $this->view,
    );

  }

  public function testShouldSaveFlashMessage(): void 
  {
    // EXPECTS
    $this->request->expects($this->once())
      ->method('setSession')
      ->with('flash', ['type' => 'info', 'message' => 'hello']);

    // WHEN
    $this->controller->publicSetFlash('info', 'hello');
  }

  public function testShouldGetAndRemoveFlashMessage(): void 
  {
    // GIVEN
    $this->request->expects($this->once())
      ->method('getSession')
      ->with('flash')
      ->willReturn(['type' => 'info', 'message' => 'hello']);

    // EXPECTS
    $this->request->expects($this->once())
      ->method('removeSession')
      ->with('flash');

    // WHEN
    $result = $this->controller->publicGetFlash();

    // THEN
    $this->assertEquals(['type' => 'info', 'message' => 'hello'], $result);
  }
}


class TestController extends AbstractController 
{

  public function publicSetFlash($type, $msg): void
  {
    $this->setFlash($type, $msg);
  }

  public function publicGetFlash(): ?array
  {
    return $this->getFlash();
  }
}