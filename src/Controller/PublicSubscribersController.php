<?php

namespace App\Controller;

use App\Core\ContextController;
use App\DTO\Dashboard\CreateSubscriberDto;
use App\Exception\ServiceException;
use App\Notification\Notifier;
use App\Service\Dashboard\SubscribersService;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use Exception;
use Random\RandomException;

class PublicSubscribersController extends AbstractController
{
    public function __construct(
        private readonly SubscribersService $service,
        private readonly Notifier           $notifier,
        ContextController                   $contextController,
    )
    {
        parent::__construct($contextController);
    }

    /**
     * @throws InvalidCsrfTokenException
     * @throws RandomException
     */
    public function subscribeAction(): void
    {
        $this->csrfMiddleware->verify();

        $email = (string) $this->validator->validate(name: 'email', value: $this->request->getFormParam('email'), required: true, type: 'email');

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
            $token = $this->service->createSubscriber($dto);

            $this->notifier->sendConfirmationEmail($email, $token);

            $this->sessionManager->setFlash('success', 'Dziękujemy za zapisanie się!', 'public');

        } catch (ServiceException $e) {
            $this->sessionManager->setFlash('warning', $e->getMessage(), 'public');
        }

        $this->redirect($this->contextController->config->getHomeRoute());
    }

    public function confirmAction(): void
    {
        $token = $this->request->getQueryParam('token');

        if (!$token) {
            $this->redirect("{$this->contextController->config->getHomeRoute()}?error=invalid_token");
            return;
        }

        try {

            $this->service->activateSubscriber($token);
            $this->sessionManager->setFlash('success', 'Subskrypcja została potwierdzona! Oss!', 'public');
        } catch (Exception) {
            $this->sessionManager->setFlash('warning', 'Link aktywacyjny jest nieprawidłowy.', 'public');
        }

        $this->redirect($this->contextController->config->getHomeRoute());
    }

    public function unsubscribeAction(): void
    {
        $token = $this->request->getQueryParam('token');

        if (!$token) {
            $this->sessionManager->setFlash('warning', 'Brak klucza wypisania.', 'public');
            $this->redirect($this->contextController->config->getHomeRoute());
            return;
        }

        try {
            $this->service->unsubscribe($token);
            $this->sessionManager->setFlash('success', 'Twoje dane zostały usunięte. Nie będziesz już otrzymywać powiadomień.', 'public');
        } catch (ServiceException) {
            $this->sessionManager->setFlash('warning', 'Nie udało się przetworzyć prośby o wypisanie.', 'public');
        }

        $this->redirect($this->contextController->config->getHomeRoute());
    }
}