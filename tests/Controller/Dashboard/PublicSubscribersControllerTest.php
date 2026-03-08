<?php

declare(strict_types=1);

namespace Tests\Controller;

use App\Controller\PublicSubscribersController;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\SubscribersService;
use App\View;
use App\Exception\ServiceException;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PublicSubscribersControllerTest extends TestCase
{
    private Request|MockObject $request;
    private EasyCSRF|MockObject $easyCSRF;
    private View|MockObject $view;
    private SubscribersService|MockObject $service;
    private CsrfMiddleware|MockObject $csrfMiddleware;
    private PublicSubscribersController $controller;

    protected function setUp(): void
    {
        $this->request = $this->createMock(Request::class);
        $this->easyCSRF = $this->createMock(EasyCSRF::class);
        $this->view = $this->createMock(View::class);
        $this->service = $this->createMock(SubscribersService::class);
        $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);

        $this->controller = $this->getMockBuilder(PublicSubscribersController::class)
            ->setConstructorArgs([
                $this->request,
                $this->easyCSRF,
                $this->view,
                $this->service,
                $this->csrfMiddleware
            ])
            ->onlyMethods(['redirect', 'setFlash'])
            ->getMock();
    }

    public function testShouldSubscribeSuccessfullyWhenDataIsValid(): void
    {
        // GIVEN
        $email = 'user@example.com';
        $this->csrfMiddleware->expects($this->once())->method('verify');
        
        $this->request->expects($this->once())
            ->method('validate')
            ->with('email', true, 'email')
            ->willReturn($email);
            
        $this->request->method('getErrors')->willReturn([]);

        // EXPECTS
        $this->service->expects($this->once())
            ->method('createSubscriber')
            ->with(['email' => $email, 'is_active' => 0]);

        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('success', 'Dziękujemy za zapisanie się!');

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('/');

        // WHEN
        $this->controller->subscribeAction();
    }

    public function testShouldRedirectWithErrorWhenEmailIsInvalid(): void
    {
        // GIVEN
        $this->csrfMiddleware->expects($this->once())->method('verify');
        $this->request->method('validate')->willReturn(null);
        $this->request->method('getErrors')->willReturn(['email' => 'Invalid']);

        // EXPECTS
        $this->service->expects($this->never())->method('createSubscriber');
        
        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('error', 'Niepoprawny adres email.');

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('/');

        // WHEN
        $this->controller->subscribeAction();
    }

    public function testShouldSetErrorFlashWhenServiceThrowsException(): void
    {
        // GIVEN
        $this->request->method('validate')->willReturn('test@test.pl');
        $this->request->method('getErrors')->willReturn([]);
        
        $this->service->method('createSubscriber')
            ->willThrowException(new ServiceException('Database error'));

        // EXPECTS
        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('error', 'Wystąpił błąd podczas zapisu.');

        // WHEN
        $this->controller->subscribeAction();
    }
}