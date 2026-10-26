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

    public function csrfTokenAction(): void
    {
        header('Cache-Control: no-store, private');
        header('Content-Type: application/json; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');

        echo json_encode(
            ['token' => $this->csrfMiddleware->generateToken()],
            JSON_THROW_ON_ERROR,
        );
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
                'Aby włączyć powiadomienia, potwierdź swój adres e-mail linkiem z wiadomości. '
                . 'Sprawdź skrzynkę i folder spam. Link jest ważny przez 24 godziny. '
                . 'Ponowna próba wysyłki potwierdzenia jest możliwa po 5 minutach.',
                'public',
            );

        } catch (ServiceException $e) {
            $this->sessionManager->setFlash('warning', $e->getMessage(), 'public');
        }

        $this->redirect($this->contextController->config->getHomeRoute());
    }

    public function confirmAction(): void
    {
        $token = $this->request->getQueryParam('token');

        $invalidLinkMessage =
            'Link potwierdzający jest nieprawidłowy, wygasł lub został już wykorzystany. '
            . 'Jeśli subskrypcja nie została jeszcze potwierdzona, '
            . 'ponownie wpisz adres w formularzu powiadomień, aby poprosić o nowy link.';


        if (!is_string($token) || $token === '') {
            $this->sessionManager->setFlash(
                'warning',
                $invalidLinkMessage,
                'public',
            );

            $this->redirect($this->contextController->config->getHomeRoute());
            return;
        }

        try {

            $this->service->confirm($token);
            $this->sessionManager->setFlash('success', 'Subskrypcja została potwierdzona! Oss!', 'public');
        }  catch (NotFoundException) {
            $this->sessionManager->setFlash(
                'warning',
                $invalidLinkMessage,
                'public',
            );
        } catch (ServiceException) {
            $this->sessionManager->setFlash(
                'warning',
                'Nie udało się teraz potwierdzić subskrypcji. '
                . 'Spróbuj ponownie później, korzystając z tego samego linku.',
                'public',
            );
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
