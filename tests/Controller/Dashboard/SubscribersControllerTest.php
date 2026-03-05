<?php

namespace Tests\Controller\Dashboard;

use App\Controller\Dashboard\SubscribersController;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\SubscribersManagementServiceInterface;
use App\View;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SubscribersControllerTest extends TestCase
{
    private SubscribersManagementServiceInterface | MockObject $subscribersService;
    private Request | MockObject $request;
    private EasyCSRF | MockObject $easyCSRF;
    private View | MockObject $view;
    private CsrfMiddleware | MockObject $csrfMiddleware;

    private SubscribersController | MockObject $controller;


    public function setUp(): void
    {
        $this->subscribersService = $this->createMock(SubscribersManagementServiceInterface::class);
        $this->request = $this->createMock(Request::class);
        $this->easyCSRF = $this->createMock(EasyCSRF::class);
        $this->view = $this->createMock(View::class);
        $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);

        $this->controller = $this->getMockBuilder(SubscribersController::class)
          ->setConstructorArgs([
            $this->subscribersService,
            $this->request,
            $this->easyCSRF,
            $this->view,
            $this->csrfMiddleware
          ])
          ->onlyMethods(['redirect'])
          ->getMock();
    }

    public function testShouldRenderSubscribersListViewWithDataAndCsrfTokenWhenActionIsIndex(): void
    {
        // EXPECTS
        $this->csrfMiddleware->expects($this->once())
          ->method('generateToken')
          ->willReturn('token');

        $this->subscribersService->expects($this->once())
          ->method('getAllSubscribers')
          ->willReturn(['email' => 'example@test.com']);

        $this->view->expects($this->once())
          ->method('renderDashboardView')
          ->with([
            'page' => 'subscribers/index',
            'data' => ['email' => 'example@test.com'],
            'flash' => null,
            'csrf_token' => 'token'
          ]);

        // WHEN
        $this->controller->indexAction();
    }

    public function testShouldReturnSubscribersWhenMethodGetModuleNameIsCalled(): void
    {
        //GIVEN
        $method = new \ReflectionMethod(SubscribersController::class, 'getModuleName');
        $method->setAccessible(true);

        //WHEN
        $result = $method->invoke($this->controller);

        //THEN
        $this->assertEquals('subscribers', $result);
    }

    public function testShouldRenderSubscribersCreateViewWithCsrfTokenWhenActionIsCreate(): void
    {
        // GIVEN
        $this->csrfMiddleware->expects($this->once())
          ->method('generateToken')
          ->willReturn('token');

        // EXPECTS
        $this->view->expects($this->once())
          ->method('renderDashboardView')
          ->with([
            'page' => 'subscribers/create',
            'flash' => null,
            'csrf_token' => 'token'
          ]);

        // WHEN
        $this->controller->createAction();
    }

    public function testShouldReturnDataToCreateWhenMethodGetDataToCreateIsCalled(): void
    {
        // GIVEN
        $this->request->method('validate')
          ->willReturnArgument(0);

        $method = new \ReflectionMethod(SubscribersController::class, 'getDataToCreate');
        $method->setAccessible(true);

        // WHEN
        $result = $method->invoke($this->controller);

        // THEN
        $this->assertEquals('email', $result['email']);
    }

    public function testShouldCallServiceToCreateNewsWhenActionIsHandleCreate(): void
    {
        // GIVEN
        $data = ['email' => 'test@gmail.com'];
        $method = new \ReflectionMethod(SubscribersController::class, 'handleCreate');
        $method->setAccessible(true);

        // EXPECTS
        $this->subscribersService->expects($this->once())
          ->method('createSubscriber')
          ->with($data);

        // WHEN
        $method->invoke($this->controller, $data);
    }
}
