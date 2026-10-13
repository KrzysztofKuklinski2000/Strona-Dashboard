<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\DTO\Dashboard\Subscriber\CreateSubscriberDto;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Service\Contracts\SubscriptionServiceInterface;
use App\View\PublicPageRenderer;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use Exception;

class PublicSubscribersController extends AbstractController
{
    public function __construct(
        private readonly SubscriptionServiceInterface $service,
        private readonly PublicPageRenderer           $renderer,
        ContextController                             $contextController,
    )
    {
        parent::__construct($contextController);
    }

    /**
     * @throws InvalidCsrfTokenException
     */
    public function subscribeAction(): void
    {
        $this->csrfMiddleware->verify();

        $email = (string)$this->validator->validate(name: 'email', value: $this->request->getFormParam('email'), required: true, type: 'email');

        $consent = $this->request->getFormParam('terms_consent');

        if ($this->validator->getErrors()) {
            $this->sessionManager->setFlash('warning', 'Niepoprawny adres email.', 'public');
            $this->redirect($this->contextController->config->getHomeRoute());
            return;
        }

        if (!$consent) {
            $this->sessionManager->setFlash('warning', 'Musisz zaakceptować zgodę na przetwarzanie danych.', 'public');
            $this->redirect($this->contextController->config->getHomeRoute());
            return;
        }

        try {
            $dto = CreateSubscriberDto::fromArray(['email' => $email]);
            $this->service->subscribe($dto);

            $this->sessionManager->setFlash(
                'success',
                'Sprawdź swoją skrzynkę e-mail i kliknij link, aby potwierdzić subskrypcję.',
                'public'
            );

        } catch (ServiceException $e) {
            $this->sessionManager->setFlash('warning', $e->getMessage(), 'public');
        }

        $this->redirect($this->contextController->config->getHomeRoute());
    }

    public function confirmAction(): void
    {
        $token = $this->request->getQueryParam('token');

        if (!is_string($token) || $token === '') {
            $this->redirect("{$this->contextController->config->getHomeRoute()}?error=invalid_token");
            return;
        }

        try {

            $this->service->confirm($token);
            $this->sessionManager->setFlash('success', 'Subskrypcja została potwierdzona! Oss!', 'public');
        } catch (Exception) {
            $this->sessionManager->setFlash('warning', 'Link aktywacyjny jest nieprawidłowy.', 'public');
        }

        $this->redirect($this->contextController->config->getHomeRoute());
    }

    /**
     * @throws InvalidCsrfTokenException
     */
    public function unsubscribeAction(): void
    {
        $this->csrfMiddleware->verify();

        $token = $this->request->getFormParam('token');

        if (!is_string($token) || $token === '') {
            $this->sessionManager->setFlash(
                'warning',
                'Brak klucza wypisania.',
                'public'
            );

            $this->redirect(
                $this->contextController->config->getHomeRoute(),
                303
            );

            return;
        }

        try {
            $this->service->unsubscribe($token);

            $this->sessionManager->setFlash(
                'success',
                'Twoje dane zostały usunięte. Nie będziesz już otrzymywać powiadomień.',
                'public'
            );
        } catch (NotFoundException) {
            $this->sessionManager->setFlash(
                'warning',
                'Link wypisania jest nieprawidłowy lub został już wykorzystany.',
                'public'
            );
        } catch (ServiceException) {
            $this->sessionManager->setFlash(
                'warning',
                'Nie udało się usunąć subskrypcji. Spróbuj ponownie później.',
                'public',
            );
        }

        $this->redirect(
            $this->contextController->config->getHomeRoute(),
            303
        );
    }

    public function unsubscribeConfirmationAction(): void {
        header('Cache-Control: no-store');
        header('Referrer-Policy: no-referrer');
        header('X-Robots-Tag: noindex, nofollow');

        $token = $this->request->getQueryParam('token');

        if (!is_string($token) || $token === '') {
            $this->sessionManager->setFlash(
                'warning',
                'Brak klucza wypisania.',
                'public',
            );

            $this->redirect($this->contextController->config->getHomeRoute());
            return;
        }

        try {
            $this->service->validateUnsubscribeToken($token);
        }catch (NotFoundException) {
            $this->sessionManager->setFlash(
                'warning',
                'Link wypisania jest nieprawidłowy lub został już wykorzystany.',
                'public',
            );

            $this->redirect($this->contextController->config->getHomeRoute());
            return;
        } catch (ServiceException) {
            $this->sessionManager->setFlash(
                'warning',
                'Nie udało się sprawdzić linku. Spróbuj ponownie później.',
                'public',
            );

            $this->redirect($this->contextController->config->getHomeRoute());
            return;
        }

        $this->renderer->render([
            'page' => 'unsubscribe',
            'unsubscribe_token' => $token,
        ]);
    }
}
