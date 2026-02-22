<?php

namespace Tests\Controller;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;
use App\Controller\AuthController;
use App\Middleware\CsrfMiddleware;
use App\Exception\ServiceException;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use PHPUnit\Framework\MockObject\MockObject;

class AuthControllerTest extends TestCase {
  private Request | MockObject $request;
  private AuthService | MockObject $authService;
  private EasyCSRF | MockObject $easyCSRF;
  private View | MockObject $view;
  private AuthController | MockObject $controller;
  private CsrfMiddleware | MockObject $csrfMiddleware;


  public function setUp(): void 
  {
    $this->request = $this->createMock(Request::class);
    $this->authService = $this->createMock(AuthService::class);
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->view = $this->createMock(View::class);
    $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);


    $this->controller = $this->getMockBuilder(AuthController::class)
      ->setConstructorArgs([
        $this->request,
        $this->authService,
        $this->easyCSRF,
        $this->view,
        $this->csrfMiddleware
      ])
      ->onlyMethods(['redirect', 'setFlash'])
      ->getMock();
  }


  public function testShouldRedirectToDashboardIfUserIsLoggedInWhenActionIsLogin(): void
  {
    // GIVEN
    $this->request->expects($this->once())
      ->method('getSession')
      ->with('user')
      ->willReturn(['id' => 1]);


    // EXPECTS
    $this->controller->expects($this->once())
      ->method('redirect')
      ->with('/dashboard');

    // WHEN
    $this->controller->loginAction();
  }

  public function testShouldRenderViewWithCsrfTokenWhenActionIsLoginAndFormHasNotSubmitted(): void
  {
    // GIVEN
    $this->request->expects($this->once())
      ->method('getSession')
      ->with('user')
      ->willReturn(null);

    $this->request->expects($this->once())
      ->method('hasPost')
      ->willReturn(false);

    // EXPECTS
    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');


    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'login',
        'messages' => [],
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->loginAction();
  }

  public function testShouldRedirectToDashboardIfUserIsNotLoggedInWhenActionIsLoginAndFormHasSubmittedAndNoErrors(): void
  {
    // GIVEN
    $this->request->expects($this->once())
      ->method('getSession')
      ->with('user')
      ->willReturn(null);

    $this->request->expects($this->once())
      ->method('hasPost')
      ->willReturn(true);

    $this->csrfMiddleware->expects($this->once())
      ->method('verify');

    $this->request->expects($this->exactly(2))
      ->method('getFormParam')
      ->willReturnMap([
        ['login', null, 'admin'],
        ['password', null, 'admin']
      ]);
    
    $this->authService->expects($this->once())
      ->method('login')
      ->with('admin', 'admin')
      ->willReturn([]);

    // EXPECTS
    $this->controller->expects($this->once())
      ->method('redirect')
      ->with('/dashboard');
    
    $this->controller->expects($this->once())
      ->method('setFlash')
      ->with('info', 'Udało się zalogować');

    // WHEN
    $this->controller->loginAction();
  }

  public function testShouldRenderViewWithErrorsWhenActionIsLoginAndFormHasSubmittedButCredentialsAreInvalid(): void 
  {
    // GIVEN
    $this->request->expects($this->once())
      ->method('getSession')
      ->with('user')
      ->willReturn(null);

    $this->request->expects($this->once())
      ->method('hasPost')
      ->willReturn(true);

    $this->csrfMiddleware->expects($this->once())
      ->method('verify');

    $this->request->expects($this->exactly(2))
      ->method('getFormParam')
      ->willReturnMap([
        ['login', null, 'admin'],
        ['password', null, 'admin']
      ]);

    $errors = ['login' => 'Błędne hasło'];
    $this->authService->expects($this->once())
      ->method('login')
      ->with('admin', 'admin')
      ->willReturn($errors);

    // EXPECTS
    $this->controller->expects($this->never())
      ->method('redirect')
      ->with('/dashboard');

    $this->controller->expects($this->never())
      ->method('setFlash')
      ->with('info', 'Udało się zalogować');

    $this->csrfMiddleware->expects($this->once())
      ->method('generateToken')
      ->willReturn('token');

    $this->view->expects($this->once())
      ->method('renderDashboardView')
      ->with([
        'page' => 'login',
        'messages' => $errors,
        'csrf_token' => 'token'
      ]);

    // WHEN
    $this->controller->loginAction();
  }

  public function testShouldThrowServiceExceptionWhenActionIsLoginFormHasSubmittedAndAuthServiceThrowsException(): void 
  {
    // GIVEN 
    $this->request->expects($this->once())
      ->method('getSession')
      ->with('user')
      ->willReturn(null);

    $this->request->expects($this->once())
      ->method('hasPost')
      ->willReturn(true);

    $this->csrfMiddleware->expects($this->once())
      ->method('verify');

    $this->request->expects($this->exactly(2))
      ->method('getFormParam')
      ->willReturnMap([
        ['login', null, 'admin'],
        ['password', null, 'admin']
      ]);

    $this->authService->method('login')
      ->willThrowException(new ServiceException('Nie udało się zalogować'));

    // EXPECTS
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się zalogować');

    // WHEN
    $this->controller->loginAction();
  }

  public function testShouldThrowServiceExceptionWhenActionIsLoginFormHasSubmittedCsrftMiddlewareThrowsException(): void
  {
    // GIVEN 
    $this->request->expects($this->once())
      ->method('getSession')
      ->with('user')
      ->willReturn(null);

    $this->request->expects($this->once())
      ->method('hasPost')
      ->willReturn(true);

    $this->csrfMiddleware->method('verify')
      ->willThrowException(new InvalidCsrfTokenException());

    // EXPECTS
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Wystąpił nieznany błąd');

    // WHEN
    $this->controller->loginAction();
  }

  public function testShouldRemoveSessionAndRedirectWhenActionIsLogout(): void 
  {
    // EXPECTS 
    $this->request->expects($this->once())
      ->method('removeSession')
      ->with('user');
    
    $this->controller->expects($this->once())
      ->method('redirect')
      ->with('/auth/login');

    // WHEN
    $this->controller->logoutAction();
  }
}