<?php

declare(strict_types=1);

namespace Tests\Controller;

use App\Controller\PublicSubscribersController;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use App\Notification\Notifier;
use App\Service\Dashboard\SubscribersService;
use App\View;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PublicSubscribersControllerTest extends TestCase
{
    private Request|MockObject $request;
    private View|MockObject $view;
    private SubscribersService|MockObject $service;
    private CsrfMiddleware|MockObject $csrfMiddleware;
    private Notifier | MockObject $notifier;

    /** @var PublicSubscribersController&MockObject */
    private PublicSubscribersController $controller;
    

    protected function setUp(): void
    {
        $this->request = $this->createMock(Request::class);
        $this->view = $this->createMock(View::class);
        $this->service = $this->createMock(SubscribersService::class);
        $this->csrfMiddleware = $this->createMock(CsrfMiddleware::class);
        $this->notifier = $this->createMock(Notifier::class);

        $this->controller = $this->getMockBuilder(PublicSubscribersController::class)
            ->setConstructorArgs([
                $this->request,
                $this->view,
                $this->service,
                $this->csrfMiddleware,
                $this->notifier,
            ])
            ->onlyMethods(['redirect', 'setFlash'])
            ->getMock();
    }

    public function testShouldSubscribeSuccessfullyWhenDataAndConsentAreValid(): void
    {
        // GIVEN
        $email = 'user@example.com';
        $this->csrfMiddleware->expects($this->once())->method('verify');
        
        $this->request->method('validate')->willReturn($email);
        $this->request->method('getErrors')->willReturn([]);
        $this->request->method('getFormParam')->with('terms_consent')->willReturn('on');

        // EXPECTS
        $this->service->expects($this->once())
            ->method('createSubscriber')
            ->with(['email' => $email, 'is_active' => 0])
            ->willReturn('mock-token-123');

        $this->notifier->expects($this->once())
            ->method('sendConfirmationEmail')
            ->with($email, 'mock-token-123');

        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('success', 'Dziękujemy za zapisanie się!');

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('/');

        // WHEN
        $this->controller->subscribeAction();
    }

    public function testShouldRedirectWithErrorWhenConsentIsMissing(): void
    {
        // GIVEN
        $this->csrfMiddleware->method('verify');
        $this->request->method('validate')->willReturn('test@test.pl');
        $this->request->method('getErrors')->willReturn([]);
        $this->request->method('getFormParam')->with('terms_consent')->willReturn(null);

        // EXPECTS
        $this->service->expects($this->never())->method('createSubscriber');
        
        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('error', 'Musisz zaakceptować zgodę na przetwarzanie danych.');

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('/');

        // WHEN
        $this->controller->subscribeAction();
    }

    public function testShouldRedirectWithErrorWhenEmailIsInvalidButConsentIsPresent(): void
    {
        // GIVEN
        $this->request->method('validate')->willReturn(null);
        $this->request->method('getErrors')->willReturn(['email' => 'Invalid']);
        $this->request->method('getFormParam')->with('terms_consent')->willReturn('on');

        // EXPECTS
        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('error', 'Niepoprawny adres email.');

        // WHEN
        $this->controller->subscribeAction();
    }

    public function testShouldHandleServiceExceptionDuringSubscription(): void
    {
        // GIVEN
        $email = 'user@example.com';
        $this->csrfMiddleware->expects($this->once())->method('verify');
        
        $this->request->method('validate')->willReturn($email);
        $this->request->method('getErrors')->willReturn([]);
        $this->request->method('getFormParam')->with('terms_consent')->willReturn('on');

        $this->service->method('createSubscriber')
            ->willThrowException(new \App\Exception\ServiceException('Błąd bazy danych'));

        // EXPECTS
        $this->notifier->expects($this->never())->method('sendConfirmationEmail');

        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('error', 'Wystąpił błąd podczas zapisu.');

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('/');

        // WHEN
        $this->controller->subscribeAction();
    }

    public function testShouldConfirmSubscriptionSuccessfully(): void
    {
        // GIVEN
        $token = 'valid-token-123';
        $this->request->expects($this->once())
            ->method('getQueryParam')
            ->with('token')
            ->willReturn($token);

        // EXPECTS
        $this->service->expects($this->once())
            ->method('activateSubscriber')
            ->with($token);

        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('success', 'Subskrypcja została potwierdzona! Oss!');

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('/');

        // WHEN
        $this->controller->confirmAction();
    }

    public function testShouldRedirectWithErrorWhenTokenIsMissingInConfirmAction(): void
    {
        // GIVEN
        $this->request->method('getQueryParam')->with('token')->willReturn(null);

        // EXPECTS
        $this->service->expects($this->never())->method('activateSubscriber');
        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('/?error=invalid_token');

        // WHEN
        $this->controller->confirmAction();
    }

    public function testShouldRedirectWithErrorWhenActivationFails(): void
    {
        // GIVEN
        $token = 'invalid-or-expired-token';
        $this->request->method('getQueryParam')->willReturn($token);
        
        $this->service->method('activateSubscriber')
            ->willThrowException(new \Exception("Błąd bazy"));

        // EXPECTS
        $this->controller->expects($this->once())
            ->method('setFlash')
            ->with('error', 'Link aktywacyjny jest nieprawidłowy.');

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('/');

        // WHEN
        $this->controller->confirmAction();
    }
}